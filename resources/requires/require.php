<?php


$send_data = array('status'=>'failed','message'=>'','data'=>'');
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // logging errors
    error_reporting(E_ALL); // Error/Exception engine, always use E_ALL
    ini_set('ignore_repeated_errors', TRUE); // always use TRUE
    ini_set('display_errors', True); // use FALSE only in production environment or real server. Use TRUE in development environment
    ini_set('log_errors', TRUE); // Error/Exception file logging engine.
    ini_set('error_log', './errors.log'); // Logging file path
    //error_reporting(0); // Does not allow errors to show up
    spl_autoload_register(function ($class_name){include $class_name.'.php';}); //brings up neccessary classes and functions for the work

    $dbConn = new Database($dbName='epiz_31902692_schooldb', $pwd='BFNdfxpklPR4ln');
    $dbConn = new DbController($dbConn->connect_db());

    $UPPERLETTERS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$LOWERLETTERS = 'abcdefghijklmnopqrstuvwxyz';
	$NUMBERS = '0123456789'; $SPEC_CHAR = '!@#$%_-';
	$idgenUPPER = substr(str_shuffle($UPPERLETTERS), rand(0,9),rand(10,19)); 
	$idgenLOWER = substr(str_shuffle($LOWERLETTERS), rand(0,9),rand(10,19)); 
	$idgenNUM = substr(str_shuffle($NUMBERS), rand(0,9),rand(10,19)); 
	$idgenSP_CHR = substr(str_shuffle($SPEC_CHAR), 0,rand(1,7));
    $currentTimestap = time(); $suffChar = $idgenUPPER.$idgenLOWER.$idgenNUM.$idgenSP_CHR.$currentTimestap;
	$suffCharM = substr(str_shuffle($suffChar), 0, rand(10,19)); 
   
    $data = '';


    switch ($_POST['type']) {
        case 'uniqueuser':
            // For creting user-id for unknown user  
            $id = uniqid('unique_',true).'_'.$suffChar;
            $r = $dbConn->Insert('userlogin', "`uniqid`", "('$id')");
            if($r==1){$send_data['status'] = 'success';$data = $id;}
            break;
        case 'usersignup':
            // for user registration/sign-up
            $name = $_POST['user'];
            $email = $_POST['email'];
            $pwd = $_POST['pwd'];
            $repwd = $_POST['repwd'];

            if(!empty($name)||!empty($email)||!empty($pwd)||!empty($repwd)){
                if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                    $mess = 'Unwanted charecters added in the Email paramenter';
                }elseif (!preg_match("/^[a-zA-Z0-9 ]*$/", $name)) {
                    $mess = 'Unwanted charecters added in the name paramenter';
                } elseif (empty($email)) {
                    $mess =  'The Email parrameter is empty.';                        
                } elseif (empty($name)) {
                    $mess =  'The Name is empty.';                        
                } elseif (empty($pwd)) {
                    $mess =  'The Password is empty.';                    
                } elseif (empty($repwd)) {
                    $mess = 'The Re-password parrameter is empty.';                        
                } else {
                    if($pwd !== $repwd){
                        $mess ='The password typed doesnot match the Re-typed password.';
                    } else {
                        $top = $dbConn->CountData('userbase', '`email`', "WHERE `email`= '$email'");
                        if($top === 0){
                            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                            $userUq = 'student_'.$suffChar;
                            $stat = $dbConn->Insert('userbase', '`name`,`unique_id`,`email`,`userpwd`,`usercatg`',"('$name','$userUq','$email','$hashedPwd',2)");
                            if ($stat == 1) {
                                $send_data['message'] = 'The user have been registered successfully.';
                                $send_data['status'] = 'success';
                            } else {
                                $send_data['message'] = 'Failed to register the user. Try Again!';
                            }
                        } else {
                            $send_data['message'] = 'The user already exists.';
                        }
                    }
                }
            }
            break;
        case 'userlogin':
            // For loging in the user

            $email = $_POST['email'];
            $pwd = $_POST['pwd'];

            if(empty($email)){
                $mess = 'Email missing!';
            }elseif (empty($pwd)){
                $mess = 'Password missing!';
            } else {
                $emailCheck = $dbConn->Fetch('userbase','`unique_id`,`userpwd`,`usercatg`',"WHERE `email`='$email'");
                if($emailCheck!==0||$emailCheck!==false){
                    $pwdCheck = password_verify($pwd, $emailCheck[0][0]['userpwd']);
                    if($pwdCheck == 1){
                        $data = $emailCheck; //[0][0]['unique_id']
                        $send_data['status'] = 'success';
                    }  else {
                        $mess = 'Wrong E-mail or Password.';
                    }
                }
            }

            break;
        case 'forgotpwd':
            // For registering the the forgotten user and creating a valid id for recreating password.
                $email = $_POST['email'];
                $t = $dbConn->CountData('userbase', '`email`', "WHERE `email` = '$email'");
                $code = substr(str_shuffle('0123456789'), 5,5);
                if ($t == 1){
                    $fogid = uniqid('forgot_',true).'_'.$suffCharM;
                    $dbConn->Insert('forgotlist','`forgotid`,`email`,`code`',"('$fogid','$email', '$code')");
                    $send_data['status'] = 'success'; 
                } else {
                    $mess = 'Email-id Not recognised.';
                }
            break;
        case  'resetpassword':
            // for ressetting password

            $code=$_POST['code'];
            $email=$_POST['email'];
            $npwd=$_POST['npwd'];
            $renpwd=$_POST['renpwd'];

            $fetchIn = $dbConn->Fetch('userbase', '`email`, `timestamp`', "WHERE `email` = '$email' AND `code` = '$code' ORDER BY DESC LIMIT 1");
            if($fetchIn != false){
                $fetchIn = $fetchIn[0];


            }
        
        
            break;
        case 'downloadfilelist':
            // For getting the list of downloadable files.
            $filedata = (isset($_POST['filename'])) ? $dbConn->Fetch('filelists', '`fileName`,`file_path`',"WHERE `downloadable` = 1 AND `fileName` ='$filename'")[0] : $dbConn->Fetch('filelists', '`fileName`,`file_path`','WHERE `downloadable` = 1')[0];

            $data = '';
            $count = count($filedata);
            for ($i=0; $i < $count; $i++) {
                $download = $filedata[$i]['file_path'];
                $name = $filedata[$i]['fileName'];
                $data .='<div class="p-2 sm:w-1/2 w-full"><div class="bg-gray-800 rounded flex p-4 h-full items-center hover:bg-gray-600" style="cursor: pointer;"  onclick="downloadItem(\''.$download.'\')"><svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-indigo-400 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24"><path d="M8 17l4 4 4-4m-4-5v9"></path><path d="M20.88 18.09A5 5 0 0018 9h-1.26A8 8 0 103 16.29"></path></svg><span class="title-font font-medium text-white">'.$name.'</span></div></div>';
            }
            $send_data['status'] = 'success';
            break;
        case 'usercontact':
            // For storing the usercontact. 
            $name = $_POST['name']; $email = $_POST['email']; $message = $_POST['message'];
            $data = "('$name','$email','$message')";
            $r = $dbConn->Insert('usercontact', '`name`,`email`,`message`', $data);
            if($r){
                $send_data['status'] = 'success';
                $mess = 'Your Message Has been Inserted';
            } else {
                $mess = 'Technical Error';
            }

            break;
        case 'notificationlist':
            // For fetching notification list..
            $data = [];
            $limit = (isset($_POST['page'])) ? $_POST['page'] : 20 ;
            $dataCount =  $dbConn->CountData('notifucation','`name`,`link`',"WHERE `valid`=0 AND `type` = 'all'");
            $notifi = $dbConn->Fetch('notifucation','`name`,`link`',"WHERE `valid`=0 AND `type` = 'all' LIMIT $limit");
            if ($notifi != false || $notifi != 0) {
                $notifi = $notifi[0];
                $data['data'] = '';
                $data['page'] = ($dataCount > $limit) ? round($dataCount/$limit):1;
                $count = count($notifi);
                for ($i=0; $i < $count; $i++) {
                    $name = $notifi[$i]['name'];
                    $link = $notifi[$i]['link'];
                    $data['data'] .='<div class="p-2 sm:w-1/2 w-full"><div class="bg-gray-800 rounded flex p-4 h-full items-center hover:bg-gray-600" style="cursor: pointer;"  onclick="downloadItem(\''.$link.'\')"><svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-indigo-400 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24"><path d="M8 17l4 4 4-4m-4-5v9"></path><path d="M20.88 18.09A5 5 0 0018 9h-1.26A8 8 0 103 16.29"></path></svg><span class="title-font font-medium text-white">'.$name.'</span></div></div>';
                }
                $send_data['status'] = 'success';
                
            }
            break;
        case 'footerSub':
            // For email subscribers
            $email =  $_POST['email'];
            $r = $dbConn->Insert('subscriptionlist', '`email`', "('$email')");
            if ($r) {
                $mess = 'Subscribed Successfully';
                $send_data['status'] = 'success';
            } else {
                $mess = 'Failed To Subscribe';
            }
           break;
        case 'getStaff':
            // For getting the staff list.
            $data='';
            $staffData = $dbConn->Fetch('staff', '`first_name`, `middle_name`, `last_name`, `image`, `subject`, `description`');
            if($staffData!=false||$staffData!=0){
                $staffData= $staffData[0];
                $count = count($staffData);
                for ($i=0; $i <$count; $i++) { 
                    $first_name = $staffData[$i]['first_name'];
                    $middle_name = $staffData[$i]['middle_name'];
                    $last_name = $staffData[$i]['last_name'];
                    $image = $staffData[$i]['image'];
                    $subject = $staffData[$i]['subject'];
                    $desc = $staffData[$i]['description'];
                    
                    $data.='<div class="xl:w-1/4 md:w-1/2 p-4"><div class="bg-gray-800 bg-opacity-40 p-6 rounded-lg"><img class="h-40 rounded w-full object-cover object-center mb-6" src="'.$image.'" alt="Teacher Image"><h3 class="tracking-widest text-white-400 text-xs font-medium title-font">'.$subject.'</h3><h2 class="text-lg text-white font-medium title-font mb-4">'.str_replace('  ',' ',$first_name.' '.$middle_name.' '.$last_name).'</h2><p>'.$desc.'</p></div></div>';
                }
                $send_data['status'] = 'success';
            }        
            break;
        case 'galleryImage':
            // For getting the images for image gallery
            $random = '';
            $amount = (isset($_POST['amount'])) ? $_POST['amount']:6 ;
            if (isset($_POST['page']) && $_POST['page'] > 1) {
                $init = (isset($_POST['init'])) ? $_POST['init'] : 0;
                $final = $init + $amount;
            } else {$init = 0;$final = $init + $amount;}
            if (isset($_POST['amount'])){
                $amount = $_POST['amount'];
            }

            if(isset($_POST['random']) && $_POST['random'] == 'true'){$random = 'ORDER BY RAND()';}
            $query = "WHERE `valid`= 1 $random LIMIT $init,$final";
            $totalImg = $dbConn->CountData('gallerydb', '`title`,`name`,`imagelink`',$query);
            $gallaryData = $dbConn->Fetch('gallerydb', '`title`,`name`,`imagelink`',$query)[0];
            $imageData = '';
            $gotamount = count($gallaryData);
            $t = 0;
            for ($i=0; $i<$gotamount; $i += 3) {
                $imageData.= '<div class="flex flex-wrap w-1/2">';
                if ($t === 0) {
                for ($j = 0; $j < 3; $j++) {
                    $num = $i + $j;
                    if ($num < $gotamount) {
                        if ($j == 0) {
                            $imageData.= '<div class="md:p-2 p-1 w-full"><img title="'.$gallaryData[$num]['title'].'" alt="'.$gallaryData[$num]['name'].'" class="w-full object-cover h-full object-center block" src="'.$gallaryData[$num]['imagelink'].'"></div>';
                        } else {
                            $imageData.= '<div class="md:p-2 p-1 w-1/2"><img title="'.$gallaryData[$num]['title'].'" alt="'.$gallaryData[$num]['name'].'" class="w-full object-cover h-full object-center block" src="'.$gallaryData[$num]['imagelink'].'"></div>';
                        }
                    }
                }
                $t = 1;
                } elseif($t === 1) {
                for ($j = 0; $j < 2; $j++) {
                    $num = $i + $j;
                    if ($num < $gotamount) {
                    $imageData.= '<div class="md:p-2 p-1 w-full"><img title="'.$gallaryData[$num]['title'].'" alt="'.$gallaryData[$num]['name'].'" class="w-full object-cover h-full object-center block" src="'.$gallaryData[$num]['imagelink'].'"></div>';
                    }
                }
                $t = 2;
                $i = $i - 1;
                } elseif($t === 2) {
                for ($j = 0; $j < 3; $j++) {
                    $num = $i + $j;
                    if ($num < $gotamount) {
                    if ($j == 2) {
                        $imageData.= '<div class="md:p-2 p-1 w-full"><img title="'.$gallaryData[$num]['title'].'" alt="'.$gallaryData[$num]['name'].'" class="w-full object-cover h-full object-center block" src="'.$gallaryData[$num]['imagelink'].'"></div>';
                    } else {
                        $imageData.= '<div class="md:p-2 p-1 w-1/2"><img title="'.$gallaryData[$num]['title'].'" alt="'.$gallaryData[$num]['name'].'" class="w-full object-cover h-full object-center block" src="'.$gallaryData[$num]['imagelink'].'"></div>';
                    }
            
                    }
                }
                $t = 3;
                } elseif($t === 3) {
                    for ($j = 0; $j < 4; $j++) {
                        $num = $i + $j;
                        if ($num < $gotamount) {
                        $imageData.= '<div class="md:p-2 p-1 w-1/2"><img title="'.$gallaryData[$num]['title'].'" alt="'.$gallaryData[$num]['name'].'" class="w-full object-cover h-full object-center block" src="'.$gallaryData[$num]['imagelink'].'"></div>';
                        }
                    }
                    $i = $i + 1;
                    $t = 0;
                }
                $imageData.= '</div>';
            }

            $fData = [];
            $fData['pages'] = round($totalImg/$gotamount);
            $fData['data'] = $imageData;
            $data = $fData;
            $send_data['status'] = 'success';
           break;
        case 'bloglist':
            // For getting the list of blogs & news.
            $num=3;
            if(isset($_POST['amount'])){$num = $_POST['amount'];}
            if($_POST['catg'] === 'blog'){$catg = '`type`=\'blog\'';}elseif ($_POST['catg'] === 'news') {$catg = '`type`=\'news\'';} else {$catg = '';}
            $returndata = '';
            $in_data = $dbConn->Fetch('blognews', '`title`,`description`,`postId`,`image`,`views`,`comments`,`type`',"WHERE `valid`=1 $catg ORDER BY RAND() LIMIT $num")[0];
            $count = count($in_data);
            for ($i=0; $i <$count; $i++) { 
                $title = $in_data[$i]['title'];
                $image = $in_data[$i]['image'];
                $desc = $in_data[$i]['description'];
                $link = $in_data[$i]['postId'];
                $views = $in_data[$i]['views'];
                $comm = $in_data[$i]['comments'];
                $type = strtoupper($in_data[$i]['type']);
                $returndata .= '<div class="p-4 md:w-1/3"><div class="h-full border-2 border-gray-800 rounded-lg overflow-hidden"><img class="lg:h-48 md:h-36 w-full object-cover object-center" src="'.$image.'" title="" alt="blog"><div class="p-6"><h2 class="tracking-widest text-xs title-font font-medium text-gray-500 mb-1">'.$type.'</h2><h1 class="title-font text-lg font-medium text-white mb-3">'.$title.'</h1><p class="leading-relaxed mb-3">'.$desc.'</p><div class="flex items-center flex-wrap "><a href="./blogpage.html?id='.$link.'" class="text-indigo-400 inline-flex items-center md:mb-2 lg:mb-0">Learn More <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="M12 5l7 7-7 7"></path></svg></a><span class="text-gray-500 mr-3 inline-flex items-center lg:ml-auto md:ml-0 ml-auto leading-none text-sm pr-3 py-1 border-r-2 border-gray-800"><svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>'.$views.' </span><span class="text-gray-500 inline-flex items-center leading-none text-sm"><svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path></svg>'.$comm.' </span></div></div></div></div></div>';
            }
            $send_data['status'] = 'success';
            $data = array('count'=>$count,'data'=>$returndata);
            break;
        case 'blogData':
            $pageid = $_POST['id'];
            $req = $dbConn->Fetch('blognews', '`title`,`postId`,`uploder`,`image`,`description`,`uplodedOn`,`views`,`comments`', "WHERE `type`='blog' AND `postId`='$pageid' AND `valid`=1", true);
            $return =  array('post'=>array(),'uploader'=>'');
            if ($req != 0) {
                $req = $req[0][0];
                $title = $req['title'];
                $link = $req['postId'];
                $uploader = $req['uploder'];
                $img = $req['image'];
                $desc = $req['description'];
                $uplodedOn = $req['uplodedOn'];
                $views = $req['views'];
                $comments = $req['comments'];

                $return['post']['img'] = $img;
                $return['post']['data'] = "";
                
                $return['uploader'] = "";

                $send_data['status'] = 'success';
            }
            $data = $return;
            break;
        case 'studentPage':
            $s = $_POST['id'];
            $r = $dbConn->Fetch('students','`first_name`,`middle_name`,`last_name`,`roll_no`,`class`,`age`,`phone_no`,`address`,`district`,`state`,`father_name`,`mother_name`, `blood_group`,`unq_identification`,`image`,`dob`',"WHERE `unq_id`= '$s'");
            if($r !== 0){
                $data = $r[0][0];
                $send_data['status'] = 'success';
            }
            break;
        }
    $send_data['data'] = $data;
}else{$mess = 'Bad Request';}
if(!empty($mess)){$send_data['message'] = $mess;}
printf(json_encode($send_data));
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="shortcut icon" href="./resources/reso/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./css/style2.css">
    <script src="./js/script.js"></script>
</head>


<!-- <body class="font-mono bg-gray-400">

    <div class="container mx-auto">
        <div class="flex justify-center px-6 my-12">

            <div class="w-full xl:w-3/4 lg:w-11/12 flex">

                
                <div class="w-full lg:w-full bg-white p-5 rounded-lg lg:rounded-l-none">
                    <div class="px-8 mb-4 text-center">
                        <h3 class="pt-4 mb-2 text-2xl">Forgot Your Password?</h3>
                        <p class="mb-4 text-sm text-gray-700">
                            We get it, stuff happens. Just enter your email address below and we'll send you a
                            link to reset your password!
                        </p>
                    </div>
                    <form class="px-8 pt-6 pb-8 mb-4 bg-white rounded">
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="email">
                                Email
                            </label>
                            <input
                                class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="email" type="email" placeholder="Enter Email Address..." />
                        </div>
                        <div class="mb-6 text-center">
                            <button
                                class="w-full px-4 py-2 font-bold text-white bg-red-500 rounded-full hover:bg-red-700 focus:outline-none focus:shadow-outline"
                                type="button">
                                Reset Password
                            </button>
                        </div>
                        <hr class="mb-6 border-t" />
                        <div class="text-center">
                            <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
                                href="./signup-page.html">
                                Create an Account!
                            </a>
                        </div>
                        <div class="text-center">
                            <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
                                href="./login.html">
                                Already have an account? Login!
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body> -->


<body>
    <div class="min-h-screen bg-gray-900 py-6 flex flex-col justify-center relative overflow-hidden sm:py-12">
        <div class="relative px-6 pt-10 pb-8 bg-white shadow-xl ring-1 ring-gray-900/5 sm:max-w-lg sm:mx-auto sm:rounded-lg sm:px-10">
            <div class="max-w-md mx-auto text-center">
                <img src="./resources/reso/logo.jpg" class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center " alt="School Logo" />
                <span class="text-xl ml-3">Forgot Password</span>
                <div id="alertBox" style="display: none;" class="flex items-center text-white text-sm font-bold px-4 py-3 rounded-md bg-red-500" role="alert"></div>                 
                <div class="mt-4 bg-white shadow-md rounded-lg">
                    <div class="h-2 bg-red-500 rounded-md"></div>
                    <div class="px-10 py-6">
                        <label for="" class="block font-semibold">Email id</label>
                        <input type="email" name="email" id="email" placeholder="User E-mail"
                            class="border w-full h-5 px-5 py-5 mt-2 hover:outline-none focus:ring-1 focus:ring-red-900 rounded-md">
                    </div>
                </div>
                <div class="flex text-center justify-between items-baseline">
                    <button type="submit" id="forgotpwdBtn" class="inline-block mt-4 bg-red-500 text-white py-2 px-6 rounded-md hover:bg-red-600">Submit Email</button>
                </div>
                <div class="text-center"><a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800" href="./signup-page.html">Create an Account! </a></div><div class="text-center"><a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800" href="./login.html">Already have an account? Login! </a></div>
            </div>
        </div>
    </div>
    <script>
            eventlisten(document.querySelector("#forgotpwdBtn"), 'click', function(){
                let u = document.querySelector('#email').value;

                if (u == '' || u == null||u == undefined) {
                    console.log('Email-id not entered!');
                } else {                    
                    httpGet('POST', './resources/requires/require.php', {
                        type: "forgotpwd",
                        email: u,
                    }, function(p) {
                        if (p.status === 'success') {
                            windows.location = './re-enter-password.html';
                        } else {
                            p.message
                        }
                    })
                }
            })
    </script>
</body>
</html>
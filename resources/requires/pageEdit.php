<?php 
// if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    spl_autoload_register(function ($class_name){include $class_name.'.php';});

    $data = '';

    $page = $_POST['page'];
    $title = (isset($_POST['title'])) ? $_POST['title'] : 0 ;
    $favicon = (isset($_POST['favicon'])) ? $_POST['favicon'] : 0 ;
    $metaData = (isset($_POST['metaData'])) ? $_POST['metaData'] : 0 ;
    

    
class WebPageMaker 
{
    public function __construct(string $pageName){
        $pagename = (strpos($pageName, '.')!==false) ? explode('.', $pageName) : $pageName ;
        $this->page = (is_array($pagename)) ? implode('.', array_pop($pagename)) : $pagename;
    }


    /**
     * The function "metaTitle" used to set the webPage title that will be displayed in the header tab.
	 * @param string $title 
	 * @return null 
	*/
    public function metaTitle(string $title){
        $this->title = $title;
    }

    /**
     * The function "metaDesc" used to set the webPage description.
	 * @param string $desc 
	 * @return null 
	*/
    public function metaDesc(string $desc){
        $this->desc = $desc;
    }

    /**
     * The function "metaAuthor" used to set the author of the webPage.
	 * @param string $author 
	 * @return null 
	*/
    public function metaAuthor(string $author){
        $this->author = $author;
    }

    /**
     * The function "metaKeywords" used to set the webPage description.
	 * @param string $keywords 
	 * @return null 
	*/
    public function metaKeywords(string $keywords){
        $this->keywords = $keywords;
    }

    /**
     * The function "metaContType" used to set the webPage description.
	 * @param string $type 
	 * @return null 
	*/
    public function metaContType(string $type){
        $this->contType = $type;
    }

    /**
     * The function "metaDesc" used to set the webPage description.
	 * @param string $desc 
	 * @return null 
	*/
    public function metaDesc(string $desc){
        $this->desc = $desc;
    }

    // /**
    //  * The function "metaDesc" used to set the webPage description.
	//  * @param string $desc 
	//  * @return null 
	// */
    // public function metaDesc(string $desc){
    //     $this->desc = $desc;
    // }

    // /**
    //  * The function "metaDesc" used to set the webPage description.
	//  * @param string $desc 
	//  * @return null 
	// */
    // public function metaDesc(string $desc){
    //     $this->desc = $desc;
    // }



}



// }

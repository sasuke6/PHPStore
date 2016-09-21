<?php

class Framework {
	//start up
	public static function run() {
//		echo "running....";
        self::init();
        self::autoload();
        self::router();
	}

	//init
	public static function init() {
		
		//get the workspace path function getcwd()
		define("DS", DIRECTORY_SEPARATOR);
		define("ROOT",getcwd() . DS);
		define("APP_PATH" , ROOT . "application" . DS);
		define("FRAMEWORK_PATH", ROOT . "framework" . DS);
		define("PUBLIC_PATH", ROOT . "public" . DS);
		define("MODEL_PATH", APP_PATH . "models" . DS);
		define("VIEW_PATH", APP_PATH . "views" . DS);
		define("CONTROLLER_PATH", APP_PATH . "controllers" . DS);
		define("CONFIG_PATH", APP_PATH . "config" . DS);
		define("CORE_PATH", FRAMEWORK_PATH . "core" . DS);
		define("DB_PATH", FRAMEWORK_PATH . "database" . DS);
		define("HELPER_PATH", FRAMEWORK_PATH . "helpers" . DS);
		define("LIB_PATH", FRAMEWORK_PATH . "libraries" . DS);
		
		
		//explain the url parameter and conform the path  such as index.php?p=admin&c=goods&a=add
		define("PLATFORM", isset($_REQUEST['p']) ?  $_REQUEST['p'] : "home");
		define("CONTROLLER", isset($_REQUEST['c']) ?  ucfirst($_REQUEST['c']) : "Index");
		define("ACTION", isset($_REQUEST['a']) ?  $_REQUEST['a'] : "index");
		
        
        define("CUR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);
        define("CUR_VIEW_PATH", VIEW_PATH . PLATFORM . DS);

        //load the core controlller

        require CORE_PATH . "Controller.php";
        require CORE_PATH . "Model.php";
        require DB_PATH . "Mysql.php";

        $GLOBALS['config'] = include CONFIG_PATH . "config.php";
		
	}

	//router
	public static function router() {
        //instance controller and call the function
        
        $controller_name = CONTROLLER . "Controller";  //IndexController
        $action_name = ACTION . "Action"; //indexAction
        
        $controller = new $controller_name;
        $controller->$action_name();
        
	}

	//register autoload
    
    public static function autoload() {

        //auto injection,"load" is reference follow function load($classname)
        spl_autoload_register(array(__CLASS__ , "load"));

	}
    
    
    //load function
    public static function load($classname) {
        
        //only load application of controller and model ,such as IndexController, AdminModel
        if (substr($classname,-10) == 'Controller') {
            require CUR_CONTROLLER_PATH . "{$classname}.php";
        } elseif (substr($classname, -5) == "Model") {
            require MODEL_PATH . "{$classname}.php";
        } else {
            
        }
        
    }
}
















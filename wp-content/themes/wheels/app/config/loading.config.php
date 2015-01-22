<?php

return array(

    /**
     * Mapping for all classes without a namespace.
     * The key is the class name and the value is the
     * absolute path to your class file.
     *
     * Watch your commas...
     */
    // Controllers
    'BaseController'     => themosis_path('app').'controllers'.DS.'BaseController.php',
    'HomeController'     => themosis_path('app').'controllers'.DS.'HomeController.php',
    'PageController'     => themosis_path('app').'controllers'.DS.'PageController.php',
    'NotFoundController' => themosis_path('app').'controllers'.DS.'NotFoundController.php',
    'ArchiveController'  => themosis_path('app').'controllers'.DS.'ArchiveController.php',
    'SingleController'   => themosis_path('app').'controllers'.DS.'SingleController.php',

    // Models
    'PostModel'             => themosis_path('app').'models'.DS.'PostModel.php',

    // Miscellaneous

);
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Archivo" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/index.css">
    <link rel="stylesheet" type="text/css" href="styles/navigation.css">
    <link rel="stylesheet" type="text/css" href="styles/products.css">
    <link rel="stylesheet" type="text/css" href="styles/cart.css">
    <link rel="stylesheet" type="text/css" href="styles/login.css">
    <link rel="stylesheet" type="text/css" href="styles/register.css">
    <link rel="stylesheet" type="text/css" href="styles/product.css">
    <link rel="stylesheet" type="text/css" href="styles/profile.css">
    <title>SupJean</title>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
</head>
<body>
<?php

    /* Enable the error's display */
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    /* Define a root constant (it's the root directory of the project) */
    define('__ROOT__', dirname(dirname(__FILE__)));
    define('__URL__', "http://".$_SERVER['SERVER_NAME']);

    /* Open the session */
    session_start();

    /* Include the routes */
    require_once(__ROOT__.'/Routes/Routes.php');

    /* Load the classes */
    function __autoload($class_name)
    {
        /* Load classes from the Classes directory */
        if (file_exists('../Classes/'.$class_name.'.php'))
        {
            require_once '../Classes/'.$class_name.'.php';
        }
        /* Load classes from the Controllers directory */
        elseif (file_exists('../Controllers/'.$class_name.'.php'))
        {
            require_once '../Controllers/'.$class_name.'.php';
        }
    }

?>
</body>
</html>


<?php

class Controller extends Database {
    public static function CreateView($viewName)
    {
        $_SESSION['parameters'] = static::main();
        $_SESSION['parameters']['isLogged'] = Session::isLogged();
        require_once(__ROOT__."/Views/$viewName.php");
    }
}
<?php

class Logout extends Controller
{
    public static function main()
    {
        /* If user is already logged in, redirect him to home page */
        if ($_SESSION['parameters']['isLogged'])
        {
            Session::logOut();
        }
        header("Location: ".__URL__);
    }
}
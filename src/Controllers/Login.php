<?php

class Login extends Controller
{
    public static function main()
    {
        /* If user is already logged in, redirect him to home page */
        if ($_SESSION['parameters']['isLogged'])
        {
            header("Location: ".__URL__);
        }

        if (!empty($_POST['email']))
        {
            if (User::login($_POST['email'], $_POST['password']))
            {
                header("Location: ".__URL__);
            }
            else
            {
                echo "<script>alert('Wrong credentials!');</script>";
            }
        }
    }
}
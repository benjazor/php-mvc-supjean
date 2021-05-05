<?php

class Receipts extends Controller
{
    public static function main()
    {
        /* If user is not logged in, redirect him to home page */
        if (!$_SESSION['parameters']['isLogged'])
        {
            header("Location: ".__URL__);
        }


        $parameters = array();

        $parameters["receipts"] = User::getReceipts(Session::getId());

        return $parameters;
    }
}
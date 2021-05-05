<?php

class Profile extends Controller
{
    public static function main()
    {
        /* If user is not logged in, redirect him to home page */
        if (!$_SESSION['parameters']['isLogged'])
        {
            header("Location: ".__URL__);
        }


        $parameters = array();

        $parameters["user"] = User::get(Session::getId());
        $parameters["address1"] = Address::get($parameters["user"]["billing_address_id"]);
        $parameters["address2"] = Address::get($parameters["user"]["delivery_address_id"]);

        return $parameters;
    }
}
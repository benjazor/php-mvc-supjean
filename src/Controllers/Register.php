<?php

class Register extends Controller
{
    public static function main()
    {
        /* If user is already logged in, redirect him to home page */
        if ($_SESSION['parameters']['isLogged'])
        {
            header("Location: ".__URL__);
        }

        /* Check if the submit key isset in the POST array and if it's value is register */
        if (isset($_POST["submit"]) && $_POST["submit"] == "register")
        {
            /* Check if the email/password confirmation match and if the password isn't empty */
            if (!empty($_POST["password"]) && $_POST["email"] === $_POST["emailConfirmation"] && $_POST["password"] === $_POST["passwordConfirmation"])
            {
                /* Hash the password to store it securely in the database */
                $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

                /* Create a temporary array to store all the user's data */
                $user = [
                    "firstName" => $_POST["firstName"]  ,
                    "lastName"  => $_POST["lastName"]   ,
                    "email"     => $_POST["email"]      ,
                    "password"  => $hashedPassword      ,
                    "role"      => $_POST["role"]
                ];

                /* Create a temporary array to store all the billing address data */
                $billingAddress = [
                    "addressLine1"  => $_POST["A1Line1"]   ,
                    "addressLine2"  => $_POST["A1Line2"]   ,
                    "country"       => $_POST["A1Country"] ,
                    "city"          => $_POST["A1City"]    ,
                    "state"         => $_POST["A1State"]   ,
                    "zip"           => $_POST["A1Zip"]
                ];

                /* Create a temporary array to store all the delivery address data */
                $deliveryAddress = [
                    "addressLine1"  => $_POST["A2Line1"]   ,
                    "addressLine2"  => $_POST["A2Line2"]   ,
                    "country"       => $_POST["A2Country"] ,
                    "city"          => $_POST["A2City"]    ,
                    "state"         => $_POST["A2State"]   ,
                    "zip"           => $_POST["A2Zip"]
                ];

                if (User::register($user, $billingAddress, $deliveryAddress))
                {
                    header("Location: ".__URL__);
                }
            }
        }
    }
}
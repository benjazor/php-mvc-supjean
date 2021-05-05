<?php

class User extends Database
{

    
    /**
     * Insert a new user into the database and returns it's id
     *
     * @prototype string -> string -> string -> string -> integer -> integer -> string -> integer
     *
     * @param string $firstName             This is the user first name
     * @param string $lastName              This is the user last name
     * @param string $email                 This is the user email
     * @param string $password              This is the user's hashed password
     * @param integer $billingAddressId     This is the user's billing address
     * @param integer $deliveryAddressId    This is the user's delivery address
     * @param string $role                  This is the user's role
     *
     * @return  integer     The id of the inserted user
     */
    public static function add($firstName, $lastName, $email, $password, $billingAddressId, $deliveryAddressId, $role="user")
    {
        return self::query("INSERT INTO users (id, first_name, last_name, email, password, billing_address_id, delivery_address_id, role) 
                            VALUES (NULL, :first_name, :last_name, :email, :password, :billing_address_id, :delivery_address_id, :role)", [
            ":first_name" => $firstName,
            ":last_name" => $lastName,
            ":email" => $email,
            ":password" => $password,
            ":billing_address_id" => $billingAddressId,
            ":delivery_address_id" => $deliveryAddressId,
            ":role" => $role
        ]);
    }


    /**
     * Return all the requested user's data
     *
     * @prototype integer -> array
     *
     * @param   integer $id  The id of an user
     *
     * @return  array   Contains all the user's data
     */
    public static function get($id)
    {
        return self::query("SELECT * FROM users WHERE id = :id", [":id" => $id])[0];
    }


    /**
     * Return all the requested user's data
     *
     * @prototype string -> array
     *
     * @param   string  $email  The id of an user
     *
     * @return  array   Contains all the user's data
     */
    public static function getByEmail($email)
    {
        return self::query("SELECT * FROM users WHERE email = :email", [":email" => $email])[0];
    }


    /**
     * Update a field with a new value, from a provided address's id
     *
     * @prototype integer -> string -> string -> boolean
     *
     * @param   integer     $id      The id of an existing address
     * @param   string      $field   The field we want to update the value from
     * @param   string      $value   The value we want to update
     *
     * @return  boolean     The id of the inserted table
     */
    public static function update($id, $field, $value)
    {
        /* All the updatable fields */
        $fields = ["first_name", "last_name", "email", "password", "billing_address_id", "delivery_address_id", "role"];

        /* Secure the field variable */
        foreach ($fields as $fld)
            if (!strcmp($fld, $field)) { $secure_field = $fld; }

        /* Make sure the field exists */
        if (isset($secure_field))
        {
            /* Special update for the addresses */
            if ($secure_field == "billing_address_id" || $secure_field == "delivery_address_id")
            {
                /* Get the user's data */
                $user = self::get($id);

                /* Break the $value variable in two with a pipe as a delimiter */
                list($addressField, $addressValue) = explode('|', $value);

                /* Use the address update method */
                Address::update($user[$secure_field], $addressField, $addressValue);
            }
            /* Regular update on other fields */
            else
            {
                /* Update the provided field with the provided value */
                self::query("UPDATE users SET " . $secure_field ." = :val WHERE id = :id", [
                    ":val" => strtolower($value),
                    ":id" => $id
                ]);
            }
            return True;
        }
        return False;
    }


    public static function showUsers()
    {
        $users = self::query("SELECT * FROM users");
        $result = '';
        $result .= "<h2>Users list</h2>";
        $result .= "<table>";
        $result .= "<th>Id</th><th>First name</th><th>Last name</th><th>Email</th><th>Password</th><th>Billing</th><th>Delivery</th><th>Role</th>";
        foreach ($users as $user)
        {
            $result .= "<tr>";
            $result .= "<td>" . $user["id"]                     . "</td>" ;
            $result .= "<td>" . $user["first_name"]             . "</td>" ;
            $result .= "<td>" . $user["last_name"]              . "</td>" ;
            $result .= "<td>" . $user["email"]                  . "</td>" ;
            $result .= "<td>" . $user["password"]               . "</td>" ;
            $result .= "<td>" . $user["billing_address_id"]     . "</td>" ;
            $result .= "<td>" . $user["delivery_address_id"]    . "</td>" ;
            $result .= "<td>" . $user["role"]                   . "</td>" ;
            $result .= "</tr>";
        }
        $result .= "</table>";

        return $result;
    }


    /**
     * Create a new user, two addresses and a session in the database, create an user and log him.
     *
     * @prototype (string * string * string * string * string)array -> (string * string * string * string * integer)array -> (string * string * string * string * integer)array -> boolean
     *
     * @param   array   $userInformation    An array containing all the data required to create a new user
     * @param   array   $billingAddress     An array containing all the data required to create a new address
     * @param   array   $deliveryAddress    An array containing all the data required to create a new address
     *
     * @return  boolean     The state of the registration
     */
    public static function register($userInformation, $billingAddress, $deliveryAddress)
    {
        /* Chack that the email is not already in the database and that the password isn't empty */
        if (!(empty($password) && self::query("SELECT * FROM users WHERE email = :email", [':email' => strtolower($userInformation["email"])])))
        {
            /* Create a new address in the database and store it's id in a variable */
            $billingAddressId = Address::add(
                NULL,
                $billingAddress["addressLine1"]         ,
                $billingAddress["addressLine2"]         ,
                strtolower($billingAddress["country"])  ,
                strtolower($billingAddress["city"])     ,
                strtolower($billingAddress["state"])    ,
                $billingAddress["zip"]
            );

            /* Create a new address in the database and store it's id in a variable */
            $deliveryAddressId = Address::add(
                NULL,
                $deliveryAddress["addressLine1"]        ,
                $deliveryAddress["addressLine2"]        ,
                strtolower($deliveryAddress["country"]) ,
                strtolower($deliveryAddress["city"])    ,
                strtolower($deliveryAddress["state"])   ,
                $deliveryAddress["zip"]
            );

            /* Create a new user in the database and store it's id in a variable */
            $userId = self::add(
                $userInformation["firstName"]           ,
                $userInformation["lastName"]            ,
                strtolower($userInformation["email"])   ,
                $userInformation["password"]            ,
                $billingAddressId                       ,
                $deliveryAddressId                      ,
                empty($userInformation["role"]) ? "user" : $userInformation["role"]
            );

            /* Set the user_id field from the two previously created addresses to the created user's id */
            Address::update($billingAddressId, "user_id", $userId);
            Address::update($deliveryAddressId, "user_id", $userId);

            /* Log the new user in */
            Session::logUser($userId);

            return True;
        }
        return False;
    }


    /**
     * Create a new session in the database, log the user in.
     *
     * @prototype string -> string -> boolean
     *
     * @param   string   $email     The user's email address
     * @param   string   $password  The user's password
     *
     * @return  boolean     The connection's status
     */
    public static function login($email, $password)
    {
        /* Retrive the user's data */
        $user = self::getByEmail($email);

        /* Check if there's an existing user with provided email in the database */
        if (!empty($user))
        {
            /* Verify the password and return the result */
            if (password_verify($password, $user['password']))
            {
                /* Log the user in */
                Session::logUser($user['id']);

                return True;
            }
        }
        return False;
    }


    /**
     * Return all the requested user's receipts
     *
     * @prototype integer -> array
     *
     * @param   integer $id  The id of an user
     *
     * @return  array   Contains all the user receipts's data
     */
    public static function getReceipts($id)
    {
        return self::query("SELECT * FROM receipts WHERE user_id = :id", [":id" => $id]);
    }


}
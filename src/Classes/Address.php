<?php

class Address extends Database
{


    /**
     * Insert a new address into the database and returns it's id
     *
     * @prototype integer -> string -> string -> string -> string -> integer -> integer
     *
     * @param   integer     $userId         The id of an existing user
     * @param   string      $addressLine1   The first line of the address
     * @param   string      $addressLine2   The second line of the address
     * @param   string      $country        The country of the address
     * @param   string      $city           The city of the address
     * @param   string      $state          The state of the address
     * @param   integer     $zip            The zip code of the address
     *
     * @return  integer     The id of the inserted table
     */
    public static function add($userId, $addressLine1, $addressLine2, $country, $city, $state, $zip)
    {
        return self::query("INSERT INTO addresses (user_id, address_line_1, address_line_2, country, city, state, zip)
                           VALUES (:user_id, :address_line_1, :address_line_2, :country, :city, :state, :zip)", [
            ":user_id" => $userId,
            ":address_line_1" => strtolower($addressLine1),
            ":address_line_2" => strtolower($addressLine2),
            ":country" => strtolower($country),
            ":city" => strtolower($city),
            ":state" => strtolower($state),
            ":zip" => $zip
        ]);
    }


    /**
     * Return all the requested address's data
     *
     * @prototype integer -> array
     *
     * @param   integer $id  The id of an existing address
     *
     * @return  array   Contains all the address data
     */
    public static function get($id)
    {
        return self::query("SELECT * FROM addresses WHERE id = :id", [":id" => $id])[0];
    }


    /**
     * Delete an address from the database
     *
     * @prototype integer -> void
     *
     * @param   integer $id  The id of an existing address
     *
     * @return  void
     */
    public static function delete($id)
    {
        self::query("DELETE FROM addresses WHERE id = :id", [":id" => $id]);
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
        $fields = ["user_id", "address_line_1", "address_line_2", "country", "city", "state", "zip"];

        /* Secure the field variable */
        foreach ($fields as $fld)
            if (!strcmp($fld, $field)) { $secure_field = $fld; }

        /* Make sure the field exists */
        if (isset($secure_field))
        {
            /* Update the privided field with the provided value */
            self::query("UPDATE addresses SET " . $secure_field ." = :val WHERE id = :id", [
                ":val" => strtolower($value),
                ":id" => $id
            ]);
            return True;
        }
        return False;
    }


}
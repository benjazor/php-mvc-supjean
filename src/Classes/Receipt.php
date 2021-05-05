<?php

class Receipt extends Database
{


    /**
     * Insert a new category into the database and returns it's id
     *
     * @prototype string -> string -> integer
     *
     * @param string $userId    This is the category name
     * @param string $date      This is the category description
     *
     * @return  integer     The id of the inserted category
     */
    public static function add($userId, $date)
    {
        return self::query("INSERT INTO receipts (id, user_id, date) 
                            VALUES (NULL, :user_id, :date)", [
            ":user_id" => $userId,
            ":date" => $date
        ]);
    }


    /**
     * Return all the requested receipts data
     *
     * @prototype integer -> array
     *
     * @param   integer $id  The id of a receipts
     *
     * @return  array   Contains all the receipts data
     */
    public static function get($id)
    {
        return self::query("SELECT * FROM receipts WHERE id = :id", [":id" => $id])[0];
    }


    /**
     * Update a field with a new value, from a provided receipts id
     *
     * @prototype integer -> string -> string -> boolean
     *
     * @param   integer     $id      The id of an existing receipt
     * @param   string      $field   The field we want to update the value from
     * @param   string      $value   The value we want to update
     *
     * @return  boolean     The id of the inserted table
     */
    public static function update($id, $field, $value)
    {
        /* All the updatable fields */
        $fields = ["user_id", "date"];

        /* Secure the field variable */
        foreach ($fields as $fld)
            if (!strcmp($fld, $field)) { $secure_field = $fld; }

        /* Make sure the field exists */
        if (isset($secure_field))
        {
            /* Update the privided field with the provided value */
            self::query("UPDATE receipts SET " . $secure_field ." = :val WHERE id = :id", [
                ":val" => strtolower($value),
                ":id" => $id
            ]);
            return True;
        }
        return False;
    }


    /**
     * Delete a receipt from the database
     *
     * @prototype integer -> void
     *
     * @param   integer $id  The id of an existing receipt
     *
     * @return  void
     */
    public static function delete($id)
    {
        self::query("DELETE FROM receipts WHERE id = :id", [":id" => $id]);
    }



    public static function getTransactions($id)
    {
        /* Get all the products Id */
        $transactionsId = self::query("SELECT * FROM transactions WHERE receipt_id = :id", [":id" => $id]);

        /* Initialize an array to store the products data */
        $transactions = array();

        /* Loops though all the products id matching the query */
        foreach ($transactionsId as $transactionId)
        {
            /* Query the product from his table */
            $transaction = self::query("SELECT * FROM transactions WHERE id = :id", [":id" => $transactionId["id"]])[0];

            /* Put the product's data into the products array */
            array_push($transactions, $transaction);
        }
        /* Returns all the products data */
        return $transactions;
    }


}
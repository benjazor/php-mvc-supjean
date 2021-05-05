<?php

class Transaction extends Database
{


    /**
     * Insert a new transaction into the database and returns it's id
     *
     * @prototype string -> string -> integer
     *
     * @param string $name          This is the transaction name
     * @param string $description   This is the transaction description
     *
     * @return  integer     The id of the inserted category
     */
    public static function add($receiptId, $productId, $quantity, $price)
    {
        return self::query("INSERT INTO transactions (id, receipt_id, product_id, quantity, price) 
                            VALUES (NULL, :receipt_id, :product_id, :quantity, :price)", [
            ":receipt_id" => $receiptId,
            ":product_id" => $productId,
            ":quantity" => $quantity,
            ":price" => $price
        ]);
    }


    /**
     * Return all the requested transaction's data
     *
     * @prototype integer -> array
     *
     * @param   integer $id  The id of a transaction
     *
     * @return  array   Contains all the transaction's data
     */
    public static function get($id)
    {
        return self::query("SELECT * FROM transactions WHERE id = :id", [":id" => $id])[0];
    }


    /**
     * Update a field with a new value, from a provided transaction's id
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
        $fields = ["quantity", "price"];

        /* Secure the field variable */
        foreach ($fields as $fld)
            if (!strcmp($fld, $field)) { $secure_field = $fld; }

        /* Make sure the field exists */
        if (isset($secure_field))
        {
            /* Update the privided field with the provided value */
            self::query("UPDATE transactions SET " . $secure_field ." = :val WHERE id = :id", [
                ":val" => strtolower($value),
                ":id" => $id
            ]);
            return True;
        }
        return False;
    }


    /**
     * Delete a transaction from the database
     *
     * @prototype integer -> void
     *
     * @param   integer $id  The id of an existing transaction
     *
     * @return  void
     */
    public static function delete($id)
    {
        self::query("DELETE FROM transactions WHERE id = :id", [":id" => $id]);
    }

}
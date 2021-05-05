<?php

class Category extends Database
{


    /**
     * Insert a new category into the database and returns it's id
     *
     * @prototype string -> string -> integer
     *
     * @param string $name          This is the category name
     * @param string $description   This is the category description
     *
     * @return  integer     The id of the inserted category
     */
    public static function add($name, $description="")
    {
        return self::query("INSERT INTO categories (id, name, description) 
                            VALUES (NULL, :name, :description)", [
            ":name" => $name,
            ":description" => $description
        ]);
    }


    /**
     * Return all the requested category's data
     *
     * @prototype integer -> array
     *
     * @param   integer $id  The id of a category
     *
     * @return  array   Contains all the category's data
     */
    public static function get($id)
    {
        return self::query("SELECT * FROM categories WHERE id = :id", [":id" => $id])[0];
    }

    public static function getAll()
    {
        return self::query("SELECT * FROM categories");
    }


    /**
     * Update a field with a new value, from a provided category's id
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
        $fields = ["name", "description"];

        /* Secure the field variable */
        foreach ($fields as $fld)
            if (!strcmp($fld, $field)) { $secure_field = $fld; }

        /* Make sure the field exists */
        if (isset($secure_field))
        {
            /* Update the privided field with the provided value */
            self::query("UPDATE categories SET " . $secure_field ." = :val WHERE id = :id", [
                ":val" => strtolower($value),
                ":id" => $id
            ]);
            return True;
        }
        return False;
    }


    /**
     * Delete a category from the database
     *
     * @prototype integer -> void
     *
     * @param   integer $id  The id of an existing category
     *
     * @return  void
     */
    public static function delete($id)
    {
        self::query("DELETE FROM categories WHERE id = :id", [":id" => $id]);
    }


    /**
     * Return all the requested category's products
     *
     * @prototype integer -> array
     *
     * @param   integer $id  The id of an category
     *
     * @return  array   Contains all the category products's data
     */
    public static function getProducts($id)
    {
        if ($id == 0)
        {
            return query("SELECT * FROM products");
        }
        else
        {
            /* Get all the products Id */
            $productsId = self::query("SELECT * FROM products_categories WHERE category_id = :id", [":id" => $id]);

            /* Initialize an array to store the products data */
            $products = array();

            /* Loops though all the products id matching the query */
            foreach ($productsId as $productId)
            {
                /* Query the product from his table */
                $product = self::query("SELECT * FROM products WHERE id = :id", [":id" => $productId["id"]])[0];

                /* Put the product's data into the products array */
                array_push($products, $product);
            }
            /* Returns all the products data */
            return $products;
        }
    }


}
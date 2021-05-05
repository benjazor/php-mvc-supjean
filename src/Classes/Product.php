<?php

class Product extends Database
{


    /**
     * Insert a new product into the database and returns it's id
     *
     * @prototype string -> string -> integer
     *
     * @param string $name          This is the product's name
     * @param string $description   This is the product's description
     * @param float $price          This is the product's price
     * @param integer $quantity     This is the product's quantity
     *
     * @return  integer     The id of the inserted product
     */
    public static function add($name, $description, $price, $quantity=0)
    {
        return self::query("INSERT INTO products (id, name, description, price, quantity) 
                            VALUES (NULL, :name, :description, :price, :quantity)", [
            ":name" => $name,
            ":description" => $description,
            ":price" => $price,
            ":quantity" => $quantity
        ]);
    }


    /**
     * Return all the requested product's data
     *
     * @prototype integer -> array
     *
     * @param   integer $id  The id of a product
     *
     * @return  array   Contains all the product's data
     */
    public static function get($id)
    {
        return self::query("SELECT * FROM products WHERE id = :id", [":id" => $id])[0];
    }


    /**
     * Update a field with a new value, from a provided product's id
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
        $fields = ["name", "description", "price", "quantity"];

        /* Secure the field variable */
        foreach ($fields as $fld)
            if (!strcmp($fld, $field)) { $secure_field = $fld; }

        /* Make sure the field exists */
        if (isset($secure_field))
        {
            /* Update the privided field with the provided value */
            self::query("UPDATE products SET " . $secure_field ." = :val WHERE id = :id", [
                ":val" => strtolower($value),
                ":id" => $id
            ]);
            return True;
        }
        return False;
    }


    /**
     * Delete a product from the database
     *
     * @prototype integer -> void
     *
     * @param   integer $id  The id of an existing product
     *
     * @return  void
     */
    public static function delete($id)
    {
        self::query("DELETE FROM products WHERE id = :id", [":id" => $id]);
    }


    /**
     * Return all the requested product's categories
     *
     * @prototype integer -> array
     *
     * @param   integer $id  The id of a product
     *
     * @return  array   Contains all the product's categories
     */
    public static function getCategories($id)
    {
        /* Get all the categories Id */
        $categoriesId = self::query("SELECT * FROM products_categories WHERE product_id = :id", [":id" => $id]);

        /* Initialize an array to store the categories data */
        $categories = array();

        /* Loops though all the categories id matching the query */
        foreach ($categoriesId as $categoryId)
        {
            /* Query the category from his table */
            $category = self::query("SELECT * FROM categories WHERE id = :id", [":id" => $categoryId["category_id"]])[0];


            /* Put the categories data into the categories array */
            array_push($categories, $category);
        }

        /* Returns all the categories data */
        return $categories;
    }


    public static function search($word, $category)
    {
        if ($category==0)
        {
            return self::query("SELECT * FROM products WHERE name LIKE :word", [":word" => "%". $word ."%"]);
        }
        else
        {
            $products = self::query("SELECT * FROM products WHERE name LIKE :word", [":word" => "%". $word ."%"]);
            $result = array();

            foreach ($products as $product)
            {
                foreach (self::getCategories($product['id']) as $searchcat)
                {
                    if ($searchcat['id'] == $category)
                    {
                        array_push($result, $product);
                    }
                }
            }
            return $result;
        }
    }


}
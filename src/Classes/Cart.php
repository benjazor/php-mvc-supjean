<?php

class Cart extends Database
{


    public static function add($productId)
    {

        if(!isset($_SESSION['cart'][$productId]))
        {
            $_SESSION['cart'][$productId] = 1;
        }
        else
        {
            $_SESSION['cart'][$productId]++;
        }
    }


    public static function get()
    {
        return isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    }


    public static function delete($id)
    {
        unset($_SESSION['cart'][$id]);
    }


    public static function emptyC()
    {
        unset($_SESSION['cart']);
    }


}
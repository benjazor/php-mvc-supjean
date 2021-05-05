<?php

class Item extends Controller
{
    public static function main()
    {
        if (!isset($_SESSION["product_id"]))
        {
            header("Location: ".__URL__."/products");
        }

        if (isset($_POST['buy']))
        {
            Cart::add($_POST['buy']);
            header("Location: ".__URL__."/cart");
            exit;
        }

        $paramaters = array();

        $productId = $_SESSION["product_id"];
        unset($_SESSION["product_id"]);

        $paramaters['product'] = Product::get($productId);

        return $paramaters;
    }
}
<?php

class Carts extends Controller
{

    public static function main()
    {
        $paramaters = array();

        if (isset($_POST['emptyCart']))
        {
            Cart::emptyC();
            header("Location: ".__URL__);
        }

        if (isset($_POST['deleteFromCart']))
        {
            Cart::delete($_POST['deleteFromCart']);
        }

        if (isset($_POST['buy']))
        {
            /* Create a new receipt */
            $receiptId = Receipt::add($_SESSION['userId'], date_create()->format('Y-m-d H:i:s'));

            /* Iterate through all the items in the post array */
            foreach ($_POST as $id => $quantity)
            {
                /* Check if the variable is an item */
                if (!($id == "buy"))
                {
                    /* Get the item from the database */
                    $item = Product::get($id);

                    //var_dump($item);
                    //echo $quantity;
                    //echo '</br>';

                    /* Check if there is enough items for the transaction to happen */
                    if ($item["quantity"] >= $quantity)
                    {
                        //echo "OK";
                        //echo '</br>';

                        /* Update the item's quantity value in the database */
                        Product::update($id, $quantity, $item["quantity"] - $quantity);

                        /* Add a new transaction into the database*/
                        Transaction::add($receiptId, $item["id"], $quantity, ($quantity*$item["price"]));
                    }
                }
            }

            /* Empty the cart */
            Cart::emptyC();
        }


        $cart = Cart::get();

        if (empty($cart))
        {
            $results = "<p>Your cart is empty!</p>";
        }

        else
        {
            $results = "<form method='post'>";

            foreach ($cart as $id => $quantity)
            {
                $item = Product::get($id);

                $results .= "<div class='cart-item'>";
                $results .= "<button class='cart-delete' name='deleteFromCart' value='". $id ."'>-</button>";
                $results .= "<img src='media/image.png'>";
                $results .= "<p class='product-name'>". $item['name'] ."</p>";
                $results .= "<p class='product-price'>". $item['price'] ." €/u</p>";
                $results .= "<p>Quantity:</p>";
                $results .= "<input type='text' name='". $id ."' value='". $quantity ."' size='2'>";
                $results .= "</div>";
            }
            $results .= "<div class='buy-cart'>";
            $results .=  $_SESSION['parameters']['isLogged'] ? "<button name='buy' value='true'>Buy cart</button>" : "<a href='login'>Please log in to buy cart</a>";
            $results .= "<button name='emptyCart' value=true>Empty cart</button>";
            $results .= "</div>";

            $results .= "</form>";
        }



        $paramaters['cart'] = $results;

        return $paramaters;
    }
}
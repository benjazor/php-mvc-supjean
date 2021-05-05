<?php

class Products extends Controller
{

    public static function main()
    {
        $paramaters = array();
        if (isset($_POST))
        {
            $searchWord = isset($_POST['searchWord']) ? $_POST['searchWord'] : "";
            $category = isset($_POST['category']) ? $_POST['category'] : 0;
            $searchResults = Product::search($searchWord, $category);
        }

        if (isset($_POST['buy']))
        {
            Cart::add($_POST['buy']);
            header("Location: ".__URL__."/cart");
            exit;
        }

        if (isset($_POST['more']))
        {
            $_SESSION["product_id"] = $_POST['more'];
            header("Location: ".__URL__."/product");
            exit;
        }

        if (isset($_POST['product']))
        {
            $_SESSION["product_id"] = $_POST['product'];
            header("Location: ".__URL__."/product");
            exit;
        }

        if (isset($_POST['addToCart']))
        {
            Cart::add($_POST['addToCart']);
        }


        $results = '<ul class="results">';
        foreach ($searchResults as $product)
        {
            $results .= '<li class="product">
                            <div class="product-image">
                                <form method="post">
                                    <button class="buy" name="buy" value="'. $product["id"] .'">Buy</button>
                                </form>
                                <form method="post">
                                    <button name="product" value="'. $product["id"] .'"><img src="media/image.png" alt="product-image"></button>
                                </form>
                            </div>
                            
                            <form class="cartView" method="post">';
                $results .= '<div><p>'. $product['name'] .'</p><p>'. ($product['quantity'] == 0 ? "out of stock" : $product['price'] . '€');
            $results .= '</p></div>
                                <div>
                                    <button name="more" value="'. $product["id"] .'">More</button>
                                    <button name="addToCart" value="'. $product["id"] .'">Add to cart</button>
                                </div>
                            </form>
                        </li>';
        }
        $results .= '</ul>';

        $paramaters['searchResults'] = $results;

        return $paramaters;
    }
}
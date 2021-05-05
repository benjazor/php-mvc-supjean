<?php include('Navigation.php')?>
<div class="reveipts">
    <?php
    print_r($_SESSION["parameters"]["receipts"]);

    foreach ($_SESSION["parameters"]["receipts"] as $receipt)
    {
        echo "<div class='receipt'>";
            echo "<h2>". $receipt['date'] ."</h2>";
            $transactions = Receipt::getTransactions($receipt['id']);
            foreach ($transactions as $transaction)
            {
                $product = Product::get($transaction['product_id']);
                echo "<p>". $product['name'] . ' x' . $transaction['quantity'] .' -> ' . $transaction['price'] ."€</p>";
            }
        echo "</div>";
    }

    ?>

</div>
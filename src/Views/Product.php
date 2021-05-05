<?php include('Navigation.php')?>
<div class="product-view">
    <a href="products">&#8592; Back to products</a>
    <div class="product-content">
        <img src="media/image.png">
        <div>
            <h2><?php echo $_SESSION["parameters"]["product"]["name"] ." : ". $_SESSION["parameters"]["product"]["price"] ."€"; ?></h2>
            <p><?php echo $_SESSION["parameters"]["product"]["description"]; ?></p>
        </div>
    </div>
    <form class="product-buy" method="post">
        <button name="buy" value="<?php echo $_SESSION["parameters"]["product"]["id"]; ?>">Buy</button>
    </form>
</div>


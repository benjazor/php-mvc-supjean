<nav>
    <a href="<?php echo __URL__ ?>">Home</a>

    <?php /* THIS IS THE SEARCH BAR */?>
    <form id="searchBar" class="searchBar" action="products" method="post">
        <input type="submit" value="SEARCH">
        <input type="text" name="searchWord">
        <select name="category">
            <option value="0">All</option>
            <?php
                foreach (Category::getAll() as $category)
                {
                    echo("<option value=". $category["id"] .">". ucfirst($category["name"]) ."</option>");
                }
            ?>
        </select>
    </form>

    <div class="cart">
        <a href="cart" id="cart">Cart</a>
        <div class="items">
            <?php
            $cart = Cart::get();
            if (empty($cart))
            {
                echo "<p>Empty</p>";
            }
            foreach ($cart as $id => $quantity)
            {
                $item =Product::get($id);
                echo "<p>". $item['name'] ." x ". $quantity ."</p>";
                echo "</br>";
            }
            ?>
        </div>
    </div>


    <?php if ($_SESSION['parameters']['isLogged'])
        {
            echo '<a href="logout">Logout</a>';
            echo '<a href="profile">Profile</a>';
        }
        else
        {
            echo '<a href="login">Login</a>';
            echo '<a href="register">Register</a>';
        }
        ?>

</nav>
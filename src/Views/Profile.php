<?php include('Navigation.php')?>
<div class="profile">
    <div class="informations">
        <div class="info">
            <h2>Profile</h2>
            <p><?php echo ucfirst($_SESSION["parameters"]["user"]["first_name"])?></p>
            <p><?php echo ucfirst($_SESSION["parameters"]["user"]["last_name"])?></p>
            <p><?php echo $_SESSION["parameters"]["user"]["email"]?></p>
            <p><?php echo $_SESSION["parameters"]["user"]["role"]?></p>
        </div>
        <div class="address1">
            <h2>Billing address</h2>
            <p><?php echo $_SESSION["parameters"]["address1"]["address_line_1"]?></p>
            <p><?php echo $_SESSION["parameters"]["address1"]["address_line_2"]?></p>
            <p><?php echo ucfirst($_SESSION["parameters"]["address1"]["country"]) ?></p>
            <p><?php echo ucfirst($_SESSION["parameters"]["address1"]["city"]) ?></p>
            <p><?php echo ucfirst($_SESSION["parameters"]["address1"]["state"]) ?></p>
            <p><?php echo $_SESSION["parameters"]["address1"]["zip"]?></p>
        </div>
        <div class="address2">
            <h2>Delivery address</h2>
            <p><?php echo $_SESSION["parameters"]["address2"]["address_line_1"] ?></p>
            <p><?php echo $_SESSION["parameters"]["address2"]["address_line_2"] ?></p>
            <p><?php echo ucfirst($_SESSION["parameters"]["address2"]["country"]) ?></p>
            <p><?php echo ucfirst($_SESSION["parameters"]["address2"]["city"]) ?></p>
            <p><?php echo ucfirst($_SESSION["parameters"]["address2"]["state"]) ?></p>
            <p><?php echo $_SESSION["parameters"]["address2"]["zip"]?></p>
        </div>
    </div>
    <div class="navigation">
        <a href="cart">Cart</a>
        <a href="receipts">Receipts</a>
        <a href="edit-profile">Edit Infos</a>
        <a href="logout">Logout</a>
    </div>
</div>
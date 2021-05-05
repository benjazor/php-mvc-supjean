<?php include('Navigation.php')?>
<div class="register">


    <h1>Register</h1>


    <form method="post">


        <div class="informations">


            <div class="infobox">
                <h2>Informations</h2>

                <div class="inputs">
                    <label>First name:</label>              <input type="text"      name="firstName"            placeholder="First name">
                    <label>Last name:</label>               <input type="text"      name="lastName"             placeholder="Last name">
                    <label>Email:</label>                   <input type="email"     name="email"                placeholder="email">
                    <label>Confirmation email:</label>      <input type="email"     name="emailConfirmation"    placeholder="confirmation">
                    <label>Password</label>                 <input type="password"  name="password"             placeholder="password">
                    <label>Confirmation password:</label>   <input type="password"  name="passwordConfirmation" placeholder="confirmation">

                    <label>Role</label><select name="role">
                        <option value="user">           user            </option>
                        <option value="administrator">  administrator   </option>
                    </select>
                </div>

            </div>



            <div class="infobox">
                <h2>Billing Address</h2>
                <div class="inputs">
                    <label>Line 1:</label>  <input type="text" name="A1Line1"      placeholder="Line 1">
                    <label>Line 2:</label>  <input type="text" name="A1Line2"      placeholder="Line 2">
                    <label>Country:</label> <input type="text" name="A1Country"    placeholder="Country">
                    <label>City:</label>    <input type="text" name="A1City"       placeholder="City">
                    <label>State:</label>   <input type="text" name="A1State"      placeholder="State">
                    <label>Zip:</label>     <input type="text" name="A1Zip"        placeholder="Zip">
                </div>
            </div>


            <div class="infobox">
                <h2>Delivery Address</h2>

                <div class="inputs">
                    <label>Line 1:</label>  <input type="text" name="A2Line1"      placeholder="Line 1">
                    <label>Line 2:</label>  <input type="text" name="A2Line2"      placeholder="Line 2">
                    <label>Country:</label> <input type="text" name="A2Country"    placeholder="Country">
                    <label>City:</label>    <input type="text" name="A2City"       placeholder="City">
                    <label>State:</label>   <input type="text" name="A2State"      placeholder="State">
                    <label>Zip:</label>     <input type="text" name="A2Zip"        placeholder="Zip">
                </div>


            </div>


        </div>


        <input type="submit" name="submit" value="&rarr;">


    </form>

</div>
<?php

Route::set('index.php', function ()
{
    Index::CreateView('Index');
});

Route::set('login', function ()
{
    Login ::CreateView('Login');
});

Route::set('logout', function ()
{
    Logout ::CreateView('Logout');
});

Route::set('register', function ()
{
    Register::CreateView('Register');
});

Route::set('products', function ()
{
    Products::CreateView('Products');
});

Route::set('cart', function ()
{
    Carts::CreateView('Cart');
});

Route::set('product', function ()
{
    Item::CreateView('Product');
});

Route::set('profile', function ()
{
    Profile::CreateView('Profile');
});

Route::set('receipts', function ()
{
    Receipts::CreateView('Receipts');
});
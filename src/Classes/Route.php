<?php

class Route
{
    public static $validRoutes = array();

    public static function set($route, $function)
    {
        self::$validRoutes[] = $route;
        //print_r(self::$validRoutes);

        /* If the URL corresponds to the route */
        if ($_GET['url'] == $route)
        {
            $function->__invoke();
        }
    }
}
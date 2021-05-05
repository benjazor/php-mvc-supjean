<?php

class Index extends Controller
{
    public static function main()
    {
        $paramaters = array();

        $paramaters['userList'] = User::showUsers();

        return $paramaters;
    }
}
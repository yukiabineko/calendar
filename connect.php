<?php

class Connect{
    public static string $dbinfo;
    public static string $dbuser;
    public static string $dbpass;

    public static function setConnect($info, $nm, $ps)
    {
        self::$dbinfo = $info;
        self::$dbuser = $nm;
        self::$dbpass = $ps;
    }
}
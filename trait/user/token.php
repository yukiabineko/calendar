<?php
namespace user\create;

trait tokenCreate
{
    public function createToken(){
        $str = openssl_random_pseudo_bytes(16);
        $token = bin2hex($str);
        return $token;
    }
}

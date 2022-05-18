<?php

namespace Vigilant\TestData;

class CustomerData
{
    public $firstName = 'FirstNameTest';
    public $lastName = 'LastNameTest';
    public $password = 'Password1!';

    public static function generateEmail($length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString . '@Test.com';
    }
}

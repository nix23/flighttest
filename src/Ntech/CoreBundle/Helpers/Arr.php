<?php
namespace Ntech\CoreBundle\Helpers;

class Arr
{
    public static function getByKey($key, $arr)
    {
        return array_key_exists($key, $arr) ? $arr[$key] : null;
    }
}
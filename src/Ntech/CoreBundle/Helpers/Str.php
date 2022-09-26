<?php
namespace Ntech\CoreBundle\Helpers;

class Str
{
    public static function normalizeFilename($name)
    {
        return self::getLettersAndNumbers(
            trim(self::lower($name))
        );
    }

    public static function getLettersAndNumbers($str)
    {
        if(strlen($str) == 0)
            return $str;

        preg_match_all("![a-zA-Z0-9]+!", $str, $matches);
        $res = "";
        foreach($matches[0] as $match)
            $res .= $match;

        return $res;
    }

    public static function urldecode($str)
    {
        $str = urldecode($str);
        $str = htmlspecialchars_decode($str);
        return $str;
    }

    public static function slugify($str)
    {
        $slug = str_replace(" ", "-", $str);
        $slug = self::lower($slug);

        return $slug;
    }

    public static function link($site)
    {
        if(substr($site, 0, 4) == "http" || substr($site, 0, 5) == "https")
            return $site;

        if(self::len($site) == 0)
            return "";

        return "http://" . $site;
    }

    public static function len($str)
    {
        if(function_exists('mb_strlen')
            && false !== $encoding = mb_detect_encoding($str)) {
            return mb_strlen($str, $encoding);
        }

        return strlen($str);
    }

    public static function copy($str, $from, $to = null)
    {
        if(function_exists('mb_substr')
            && false !== $encoding = mb_detect_encoding($str)) {
            return mb_substr($str, $from, $to, $encoding);
        }

        return substr($str, $from, $to);
    }

    public static function isFirstSlash($str)
    {
        return $str[0] == "/" || $str[0] == "\\";
    }

    public static function isLastSlash($str)
    {
        return $str[Str::len($str) - 1] == "/" || $str[Str::len($str) - 1] == "\\";
    }

    public static function lower($str)
    {
        if(function_exists('mb_strtolower')
            && false !== $encoding = mb_detect_encoding($str)) {
            return mb_strtolower($str, $encoding);
        }

        return strtolower($str);
    }

    public static function upper($str)
    {
        if(function_exists('mb_strtoupper')
            && false !== $encoding = mb_detect_encoding($str)) {
            return mb_strtoupper($str, $encoding);
        }

        return strtoupper($str);
    }

    public static function ucfirst($str)
    {
        if(function_exists('mb_strtoupper') && function_exists('mb_substr')
            && false !== $encoding = mb_detect_encoding($str)) {
            $tail = mb_substr($str, 1, self::len($str) - 1, $encoding);
            return mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding) . $tail;
        }

        $tail = substr($str, 1, self::len($str) - 1);
        return ucfirst($str) . $tail;
    }

    public static function formatPhone($phone, $open = "(", $close = ")", $end = "-")
    {
        $firstPart = substr($phone, 0, 3);
        $secondPart = substr($phone, 3, 3);
        $lastPart = substr($phone, 6, Str::len($phone) - 6);

        return $open . $firstPart . $close . $secondPart . $end . $lastPart;
    }

    public static function explodeByNewLines($str)
    {
        $rows = preg_split("/\\r\\n|\\r|\\n/", $str);
        $cleanedRows = array();

        foreach($rows as $row) {
            if(Str::len($row) == 0)
                continue;

            $cleanedRows[] = $row;
        }

        return $cleanedRows;
    }

    public static function startsWith($haystack, $needle)
    {
         $length = Str::len($needle);
         return (Str::copy($haystack, 0, $length) === $needle);
    }

    public static function endsWith($haystack, $needle)
    {
        $length = Str::len($needle);
        return $length === 0 || (Str::copy($haystack, -$length) === $needle);
    }

    public static function contains($str, $substr)
    {
        return (strpos($str, $substr) !== false);
    }

    public static function isNotBlank($str)
    {
        if($str == null)
            return false;

        $str = trim($str);
        return (self::len($str) > 0);
    }

    public static function isBlank($str)
    {
        return !self::isNotBlank($str);
    }

    public static function isUpper($char)
    {
        return ctype_upper($char);
    }

    public static function spacesBeforeUpper($string)
    {
        $result = "";
        array_map(function($char) use (&$result) {
            if(self::isUpper($char))
                $result .= " " . self::lower($char);
            else
                $result .= $char;
        }, str_split($string));
        
        return $result;
    }
}
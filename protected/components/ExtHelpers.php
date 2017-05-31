<?php

class ExtHelpers
{

    public static function declOfNum($number, $titles)
    {
        $cases = array(2, 0, 1, 1, 1, 2);
        return $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }

    public static function cropString($str, $num, $allowedTags=null)
    {
        $str = strip_tags($str, $allowedTags);
        $strCrop = '';
        $strCrop = mb_substr($str, 0, $num);
        if(mb_substr($str, $num, $num + 1) != ' ' && mb_substr($str, $num - 1, $num) != ' ')
        {
            $strCrop = mb_substr($strCrop, 0, strrpos($strCrop, ' '));
        }
        if(strlen($strCrop) < strlen($str))
        {
            $strCrop.="...";
        }
        return $strCrop;
    }

    public static function translit($string, $url = false)
    {
        $table = array(
            'А' => 'A',
            'Б' => 'B',
            'В' => 'V',
            'Г' => 'G',
            'Д' => 'D',
            'Е' => 'E',
            'Ё' => 'YO',
            'Ж' => 'ZH',
            'З' => 'Z',
            'И' => 'I',
            'Й' => 'J',
            'К' => 'K',
            'Л' => 'L',
            'М' => 'M',
            'Н' => 'N',
            'О' => 'O',
            'П' => 'P',
            'Р' => 'R',
            'С' => 'S',
            'Т' => 'T',
            'У' => 'U',
            'Ф' => 'F',
            'Х' => 'H',
            'Ц' => 'C',
            'Ч' => 'CH',
            'Ш' => 'SH',
            'Щ' => 'SCH',
            'Ь' => '',
            'Ы' => 'Y',
            'Ъ' => '',
            'Э' => 'E',
            'Ю' => 'YU',
            'Я' => 'YA',
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'yo',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'j',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sch',
            'ь' => '',
            'ы' => 'y',
            'ъ' => '',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            '"' => '',
            "'" => '',
            '.' => ' '
        );

        $string = str_replace(
            array_keys($table), array_values($table), $string
        );
        $string = preg_replace('/[^-a-z0-9._\[\]\'"]/i', ' ', $string);

        if($url)
        {
            $string = strtolower(trim($string));
            $string = preg_replace('/ +/', '-', $string);
            $string = str_replace('---', '-', $string);
        }

        return $string;
    }

    public static function priceFormatted($number, $decimals = 0)
    {
        switch(app()->language)
        {
            case 'ru': return number_format($number, $decimals, ',', ' ');
            case 'en': return number_format($number, $decimals, '.', ',');
        }
    }

    public static function assyncRoutine($path)
    {
        $path = ltrim($path, '/');
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, request()->hostInfo.'/'.$path);
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($c, CURLOPT_HEADER, false);
        curl_setopt($c, CURLOPT_NOBODY, true);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($c, CURLOPT_TIMEOUT, 1);
        curl_exec($c);
    }

}

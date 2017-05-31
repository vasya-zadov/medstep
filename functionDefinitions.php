<?php

if(!function_exists('mb_ucfirst')) {
    /**
     * Capitalizes word
     * @param string $str word to be capitalized
     * @param string $enc encoding identifier to use with this string
     * @return string
     */
    function mb_ucfirst($str, $enc = 'utf-8') { 
    		return mb_strtoupper(mb_substr($str, 0, 1, $enc), $enc).mb_substr($str, 1, mb_strlen($str, $enc), $enc); 
    }
}
if(!function_exists('mb_ucwords')) {
    /**
     * Conwerts first leters of each word into upper case
     * @param string $str string to be capitalized
     * @param string $enc encoding identifier to use with this string
     * @return string
     */
    function mb_ucwords($str, $enc = 'utf-8') {
        $words = explode(' ',$str);
        $upperWords = array();
        foreach($words as $word)
        {
            $upperWords[] = mb_ucfirst($word, $enc);
        }
        return implode(' ',$upperWords);
    }
}
if(!function_exists('strToHex')) {
    /**
     * Converts string into hexadecimal
     * @param string $string
     * @return string
     */
    function strToHex($string){
        $hex = '';
        for ($i=0; $i<strlen($string); $i++){
            $ord = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0'.$hexCode, -2);
        }
        return strToUpper($hex);
    }
}
if(!function_exists('hexToStr')) {
    /**
     * Converts hexadecimal into string
     * @param string $hex
     * @return string
     */
    function hexToStr($hex){
        $string='';
        for ($i=0; $i < strlen($hex)-1; $i+=2){
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }
}
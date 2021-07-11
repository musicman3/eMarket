<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use eMarket\Core\{
    Valid
};

/**
 * Func
 *
 * @package Func
 * @author eMarket
 * 
 */
class Func {

    /**
     * Array filtering to key
     * 
     * 
     * Example:
      Array
      (
      [0] => Array
      (
      [0] => 1
      [1] => Germany
      [2] => Berlin
      )

      [1] => Array
      (
      [0] => 2
      [1] => Russia
      [2] => Moscow
      )
      [2] => Array
      (
      [0] => 3
      [1] => USA
      [2] => New York
      )
      [3] => Array
      (
      [0] => 4
      [1] => USA
      [2] => Boston
      )
      )
     * 
     * 
     * $search_key = [1];
     * 
     * $search_value = 'USA'; Country
     * 
     * $data_key = 2; City
     *
     * $sort = true; Sorting
     * 
     * Output:
     * 
     * [0] => Boston
     * [1] => New York
     * 
     * @param array $basic_array Input array
     * @param string $search_key Key 
     * @param string $search_value Value for $search_key
     * @param string $data_key Data key
     * @param string $sort Sorting (null/true)
     * @return array
     * 
     */
    public static function filterArrayToKey($basic_array, $search_key, $search_value, $data_key, $sort = null) {

        $arr = [];
        foreach ($basic_array as $value) {
            if ($value[$search_key] == $search_value) {
                array_push($arr, $value[$data_key]);
            }
        }
        if ($sort == null) {
            $array_lowercase = array_map('strtolower', $arr);
            array_multisort($array_lowercase, SORT_ASC, SORT_STRING, $arr);
        }
        return $arr;
    }

    /**
     * Filtering an array while keeping keys
     * 
     * 
     * Example:
      Array
      (
      [0] => Array
      (
      [0] => 1
      [1] => Germany
      [2] => Berlin
      )

      [1] => Array
      (
      [0] => 2
      [1] => Russia
      [2] => Moscow
      )
      [2] => Array
      (
      [0] => 3
      [1] => USA
      [2] => New York
      )
      [3] => Array
      (
      [0] => 4
      [1] => USA
      [2] => Boston
      )
      )
     * 
     * $search_key = [1];
     * 
     * $search_value = 'USA'; Country
     * 
     * $key_1 = [2]; City
     * 
     * $key_2] = [0]; Key
     *
     * 
     * Output:
     * 
     * [4] => Boston
     * [3] => New York
     * 
     * 
     * @param array $basic_array Input array
     * @param string $search_key Search key
     * @param string $search_value Search value
     * @param string $key_1 Key 1
     * @param string $key_2 Key 2
     * @return array 
     * 
     */
    public static function filterArrayToKeyAssoc($basic_array, $search_key, $search_value, $key_1, $key_2) {

        foreach ($basic_array as $value) {
            if ($value[$search_key] == $search_value) {
                $arr[$value[$key_2]] = $value[$key_1];
            }
        }

        natcasesort($arr);

        return $arr;
    }

    /**
     * Function for creating a multidimensional array from a one-dimensional one in which the values are separated by a marker
     *
     * EXAMPLE:
      /*
      Array
      (
      [0] => 13-0
      [1] => 13-1
     * 
     * 
     * Ouptut array
     * 
      Array (
      [0] => Array
      (
      [0] => 13
      [1] => 0
      )

      [1] => Array
      (
      [0] => 13
      [1] => 1
      )
     * 
     * Use example: $multiselect = \eMarket\Core\Func::arrayExplode($array, '-');
     * 
     * @param array $array Input array
     * @param string $delimiter Delimiter
     * @return array
     */
    public static function arrayExplode($array, $delimiter) {
        $array_return = [];
        foreach ($array as $v) {
            $array_return = array_merge($array_return, array(explode($delimiter, $v)));
        }
        return $array_return;
    }

    /**
     * Files deleting

     * @param string $file Path
     */
    public static function deleteFile($file) {

        if (file_exists($file)) {
            chmod($file, 0777);
            unlink($file);
        }
    }

    /**
     * Function of merging arrays with continuation of key numbering
     * 
     * Example:
     * 
     * Array 1 + parameter $name_1 = 'cat'
     * 
     * 0 Array
      (
      [0] => 3
      [1] => 2
      [2] => 1
      )
     * 
     * Array 2 + parameter $name_2 = 'prod'
     * 
     * 1 Array
      (
      [0] => 4
      [1] => 6
      [2] => 7
      )
     * 
     * Output array
     * 
     * 0 Array
      (
      [cat] => Array
      (
      [0] => 3
      [1] => 2
      [2] => 1
      )

      [prod] => Array
      (
      [3a] => 4
      [4a] => 6
      [5a] => 7
      )

      )

     * @param string $name_1 Value in main array
     * @param string $name_2 Value in optional array
     * @param array $arr_1 Main array
     * @param array $arr_2 Optional array
     * @return array
     */
    public static function arrayMergeOriginKey($name_1, $name_2, $arr_1, $arr_2) {

        $a = array($name_1 => $arr_1);

        $count_a = count($arr_1);
        for ($x = 0; $x < count($arr_2); $x++) {
            $value = $arr_2[$x];
            unset($arr_2[$x]);
            $arr_2[$x + $count_a . 'a'] = $value;
        }

        $b = array($name_2 => $arr_2);

        return array_merge($a, $b);
    }

    /**
     * Function for removing a value from an array
     *
     * @param array $array Input array
     * @param array $val Values to be removed - ['val', 'val2']
     * @return array|false
     */
    public static function deleteValInArray($array, $val) {

        if (isset($array) && is_array($array)) {
            $result = array_diff($array, $val);
            $array_return = array_values($result);
            return $array_return;
        } else {
            return FALSE;
        }
    }

    /**
     * Reset function for named keys of an associated array
     * 
     * Input:
     * 
     * 0 Array
      (
      [0] => Array
      (
      [id] => 3
      [price] => 2
      )
     * 
     * Output:
     * 
     * 0 Array
      (
      [0] => Array
      (
      [0] => 3
      [1] => 2
      )
     *
     * @param array $input Input array
     * @return array
     */
    public static function resetKeyAssocArray($input) {

        $output = [];
        foreach ($input as $val) {
            array_push($output, array_values($val));
        }

        return $output;
    }

    /**
     * Function to remove empty value from array
     *
     * @param array $array Input array
     * @return array|false
     */
    public static function deleteEmptyInArray($array) {
        if (isset($array) && is_array($array)) {
            $result = array_filter($array);
            $array_return = array_values($result);
            return $array_return;
        } else {
            return FALSE;
        }
    }

    /**
     * Token
     *
     * @param string $length Length
     * @return string
     */
    public static function getToken($length) {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet);

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }

        return $token;
    }

    /**
     * Delete GET-parameter
     *
     * @param string|array $key GET-parameter
     * @return string
     */
    public static function deleteGet($key) {
        if (!is_array($key)) {
            $array = [$key => ''];
        } else {
            $array = [];
            foreach ($key as $val) {
                $array[$val] = '';
            }
        }

        parse_str(Valid::inSERVER('QUERY_STRING'), $vars);
        $url = http_build_query(array_diff_key($vars, $array));
        return '?' . $url;
    }

    /**
     * Function for escaping special characters
     *
     * @param string|array $string String to escape characters
     * @return string|array
     */
    public static function escapeSign($string) {
        // symbol and replacement
        $symbols = ["'", "<script>", "</script>"];
        $escape = ["&#8216;", "!script!", "!/script!"];

        if (is_array($string)) {
            $output = [];
            foreach ($string as $key => $value) {
                $output[$key] = str_ireplace($symbols, $escape, $value);
            }
        } else {
            $output = str_ireplace($symbols, $escape, $string);
        }
        return $output;
    }

    /**
     * Array filtering
     *
     * @param array $data Input array
     * @param string $key Key
     * @param string $val Value
     * @return array
     */
    public static function filterData($data, $key, $val) {
        $output = [];
        foreach ($data as $value) {
            if ($value[$key] == $val) {
                array_push($output, $value);
            }
        }
        return $output;
    }

}

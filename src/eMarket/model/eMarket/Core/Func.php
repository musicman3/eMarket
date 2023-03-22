<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

/**
 * Functions
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Func {

    /**
     * Array filtering to key
     * 
     * Example:
     * 
     * $basic_array = [
     * ['id' => 1, 'country' => 'Germany', 'city' => 'Berlin'],
     * ['id' => 2, 'country' => 'Russia', 'city' => 'Moskow'],
     * ['id' => 3, 'country' => 'USA', 'city' => 'New York'],
     * ['id' => 4, 'country' => 'USA', 'city' => 'Boston'],
     * ['id' => 5, 'country' => 'Russia', 'city' => 'Saint-Petersburg'],
     * ['id' => 6, 'country' => 'USA', 'city' => 'Chicago']
     * ];
     *
     * $search_key = 'country';
     * $search_value = 'USA';
     * $data_key = 'city';
     * $sort = null;
     *
     * Output:
     *
     * [0] => Boston
     * [1] => Chicago
     * [2] => New York
     *
     * @param array $basic_array Input array
     * @param string|int $search_key Search key 
     * @param mixed $search_value Value for $search_key
     * @param string|int $data_key Data key
     * @param mixed $sort Sorting (null/true)
     * @return array
     * 
     */
    public static function filterArrayToKey(array $basic_array, string|int $search_key, mixed $search_value, string|int $data_key, mixed $sort = null): array {
        $output = [];
        foreach ($basic_array as $value) {
            if ($value[$search_key] == $search_value) {
                array_push($output, $value[$data_key]);
            }
        }
        if ($sort == null) {
            $array_lowercase = array_map('strtolower', $output);
            array_multisort($array_lowercase, SORT_ASC, SORT_STRING, $output);
        }
        return $output;
    }

    /**
     * Filtering an array while keeping keys
     * 
     * Example:
     * 
     * $basic_array = [
     * ['id' => 1, 'country' => 'Germany', 'city' => 'Berlin'],
     * ['id' => 2, 'country' => 'Russia', 'city' => 'Moskow'],
     * ['id' => 3, 'country' => 'USA', 'city' => 'New York'],
     * ['id' => 4, 'country' => 'USA', 'city' => 'Boston'],
     * ['id' => 5, 'country' => 'Russia', 'city' => 'Saint-Petersburg'],
     * ['id' => 6, 'country' => 'USA', 'city' => 'Chicago']
     * ];
     * 
     * $search_key = 'country';
     * $search_value = 'USA';
     * $key_1 = 'city';
     * $key_2 = 'id';
     * 
     * Output:
     * 
     * [4] => Boston
     * [3] => New York
     * 
     * @param array $basic_array Input array
     * @param string|int $search_key Search key
     * @param mixed $search_value Search value
     * @param string|int $key_1 Key 1
     * @param string|int $key_2 Key 2
     * @return array 
     * 
     */
    public static function filterArrayToKeyAssoc(array $basic_array, string|int $search_key, mixed $search_value, string|int $key_1, string|int $key_2): array {
        foreach ($basic_array as $value) {
            if ($value[$search_key] == $search_value) {
                $output[$value[$key_2]] = $value[$key_1];
            }
        }

        natcasesort($output);

        return $output;
    }

    /**
     * Function for creating a multidimensional array from a one-dimensional one in which the values are separated by a marker
     *
     * EXAMPLE:
     * 
     * $array = ['12-0', '12-1'];
     * $delimiter = '-';
     * 
     * Ouptut:
     * 
     * [
     *   [12, 0],
     *   [12, 1]
     * ]
     * 
     * @param array $array Input array
     * @param string $delimiter Delimiter
     * @return array
     */
    public static function arrayExplode(array $array, string $delimiter): array {
        $output = [];
        foreach ($array as $v) {
            $output = array_merge($output, [explode($delimiter, $v)]);
        }
        return $output;
    }

    /**
     * Files deleting

     * @param string $file Path
     */
    public static function deleteFile(string $file): void {
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
     * $arr_1 = ['3', '2', '1'];
     * $name_1 = 'cat'
     * $arr_2 = ['4', '6', '7'];
     * $name_2 = 'prod'
     * 
     * Output:
     * 
     * [
     * 'cat' => [
     *   '0' => '3',
     *   '1' => '2',
     *   '2' => '1'],
     * 'prod' => [
     *   '3a' => '4',
     *   '4a' => '6',
     *   '5a' => '7']
     * ]
     *
     * @param string|int $name_1 Value in main array
     * @param string|int $name_2 Value in optional array
     * @param array $arr_1 Main array
     * @param array $arr_2 Optional array
     * @return array
     */
    public static function arrayMergeOriginKey(string|int $name_1, string|int $name_2, array $arr_1, array $arr_2): array {
        return [$name_1 => $arr_1, $name_2 => array_combine(array_map(function ($key) use ($arr_1) {
                        return $key + count($arr_1) . 'a';
                    }, array_keys($arr_2)), array_values($arr_2))];
    }

    /**
     * Function for removing a value from an array
     * 
     * EXAMPLE:
     * 
     * $array = ['apple', 'banana', 'green', 'mango'];
     * $val = ['banana', 'mango'];
     * 
     * Output:
     * 
     * ['apple', 'green']
     *
     * @param mixed $array Input array
     * @param array $val Values to be removed - ['val', 'val2']
     * @return mixed
     */
    public static function deleteValInArray(mixed $array, array $val): mixed {
        if (isset($array) && is_array($array)) {
            $result = array_diff($array, $val);
            $output = array_values($result);
            return $output;
        }
        return FALSE;
    }

    /**
     * Reset function for named keys of an associated array
     * 
     * EXAMPLE:
     * 
     * $input = [
     *  ['id' => '1', 'price' => '1250'],
     *  ['id' => '2', 'price' => '1320']
     * ];
     * 
     * Output:
     * 
     * {
     *   [0 => '1', 1 => '1250'],
     *   [0 => '2', 1 => '1320']
     * ]
     *
     * @param array $input Input array
     * @return array
     */
    public static function resetKeyAssocArray(array $input): array {
        $output = [];
        foreach ($input as $val) {
            array_push($output, array_values($val));
        }

        return $output;
    }

    /**
     * Function to remove empty value from array
     * 
     * EXAMPLE:
     * 
     * $array = ['banana', '', 'apple'];
     * 
     * Output:
     * 
     * ['banana', 'apple']
     *
     * @param array $array Input array
     * @return mixed
     */
    public static function deleteEmptyInArray(mixed $array): mixed {
        if (isset($array) && is_array($array)) {
            $result = array_filter($array);
            $output = array_values($result);
            return $output;
        }
        return FALSE;
    }

    /**
     * Token
     *
     * @param int|string $length Length
     * @return string
     */
    public static function getToken(int|string $length): string {
        $token = '';
        $symbols = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $symbols .= 'abcdefghijklmnopqrstuvwxyz';
        $symbols .= '0123456789';
        $max = strlen($symbols);

        for ($i = 0; $i < (int) $length; $i++) {
            $token .= $symbols[random_int(0, $max - 1)];
        }

        return $token;
    }

    /**
     * Delete GET-parameter
     *
     * @param string $get GET-request
     * @param mixed $key GET-parameter
     * @return string
     */
    public static function deleteGet(string $get, mixed $key): string {
        if (is_bool($key) || is_null($key)) {
            return $key;
        }
        $array = is_array($key) ? array_fill_keys($key, '') : [$key => ''];
        parse_str($get, $vars);
        return http_build_query(array_diff_key($vars, $array));
    }

    /**
     * Function for escaping special characters.
     * Output data filtering 
     *
     * @param string|array $data Data to escape characters
     * @return mixed
     */
    public static function outputDataFiltering(mixed $data): mixed {
        // symbol and replacement
        $find = ["'", "script", "/.", "./"];
        $replace = ["&#8216;", "!s-c-r-i-p-t!", "!/.!", "!./!"];

        $output = self::recursiveArrayReplace($find, $replace, $data);

        return $output;
    }

    /**
     * Recursive array replace
     *
     * @param string|array $find Find value
     * @param string|array $replace Replace value
     * @param string|array $data Input data
     * @return mixed
     */
    public static function recursiveArrayReplace(array|string $find, array|string $replace, mixed $data): mixed {
        if (is_bool($data) || is_null($data)) {
            return $data;
        }

        if (is_int($data)) {
            return str_ireplace($find, $replace, (string) $data);
        }

        if (!is_array($data)) {
            return str_ireplace($find, $replace, $data);
        }

        $output = [];
        foreach ($data as $key => $value) {
            $output[$key] = self::recursiveArrayReplace($find, $replace, $value);
        }
        return $output;
    }

    /**
     * Array filtering
     *
     * @param array $data Input array
     * @param string|int $key Key
     * @param string|int $val Value
     * @return array
     */
    public static function filterData(array $data, string|int $key, string|int $val): array {
        $output = [];
        foreach ($data as $value) {
            if ($value[$key] == $val) {
                array_push($output, $value);
            }
        }
        return $output;
    }

}

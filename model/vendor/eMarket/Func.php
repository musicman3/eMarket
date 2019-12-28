<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Класс для вспомогательных функций
 *
 * @package Func
 * @author eMarket
 * 
 */
class Func {

    /**
     * Функция выборки (фильтрации) из двухмерного массива значений по имени ключа и его значению.
     * 
     * 
     * ПРИМЕР: Есть масиив
      Array
      (
      [0] => Array
      (
      [0] => 1
      [1] => Россия
      [2] => Калининград
      )

      [1] => Array
      (
      [0] => 2
      [1] => Россия
      [2] => Владивосток
      )
      [2] => Array
      (
      [0] => 3
      [1] => Белоруссия
      [2] => Гомель
      )
      [3] => Array
      (
      [0] => 4
      [1] => Белоруссия
      [2] => Брест
      )
      )
     * 
     * Нужно собрать в одномерный массив все значения городов для страны Россия, 
     * и отсортировать по названию города (на увеличение).
     * 
     * $array - исходный двухмерный массив
     * 
     * $name_key = 1; - ключ  значения [1], по которому делаем фильтрацию
     * 
     * $value_key = 'Россия'; - Значение ключа (=> Россия), по которому делаем фильтрацию
     * 
     * $val = 2; - это ключ ячейки Город [2] из которого берется значение Города для нового одномерного массива
     *
     * $mass = \eMarket\Func::filterArrayToKey($array, $value_key, $name_key, $val);
     * 
     * на выходе получаем сортированный массив
     * 
     * [0] => Владивосток
     * [1] => Калининград
     * 
     * @param array $basic_array (базовый массив)
     * @param string $name_key (ключ  значения [1], по которому делаем фильтрацию)
     * @param string $value_key (значение ключа (=> 'Value'), по которому делаем фильтрацию)
     * @param string $val (это ключ ячейки [2] из которого берется значение для нового одномерного массива)
     * @return array $arr (новый массив)
     * 
     */
    public static function filterArrayToKey($basic_array, $name_key, $value_key, $val) {

        $arr = [];
        foreach ($basic_array as $value) {
            if ($value[$name_key] == $value_key) {
                array_push($arr, $value[$val]);
            }
        }
        // Сортируем массив по возрастанию (регистронезависимо)
        $array_lowercase = array_map('strtolower', $arr);
        array_multisort($array_lowercase, SORT_ASC, SORT_STRING, $arr);
        return $arr;
    }

    /**
     * Функция создания многомерного массива из одномерного, в котором значения разделены маркером
     *
     * ПРИМЕР: Массив на входе
      /*
      Array
      (
      [0] => 13-0
      [1] => 13-1
     * 
     * 
     * Массив на выходе
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
     * Использовать так: $multiselect = \eMarket\Func::arrayExplode($array, '-');
     * 
     * @param array $array (исходный одномерный массив с разделителем)
     * @param string $delimiter (разделитель)
     * @return array $array_return (новый массив)
     */
    public static function arrayExplode($array, $delimiter) {
        $array_return = [];
        foreach ($array as $v) {
            $array_return = array_merge($array_return, array(explode($delimiter, $v)));
        }
        return $array_return;
    }

    /**
     * Функция удаления файлов

     * @param string $file (путь к файлу)
     */
    public static function deleteFile($file) {

        if (file_exists($file)) {
            chmod($file, 0777);
            unlink($file); // Удаляем файлы
        }
    }

    /**
     * Функция слияния массивов с продолжением нумерации ключа
     * 
     * ПРИМЕР:
     * 
     * Массив 1 + параметр имени $name_1 = 'cat'
     * 
     * 0 Array
      (
      [0] => 3
      [1] => 2
      [2] => 1
      )
     * 
     * Массив 2 + параметр имени $name_2 = 'prod'
     * 
     * 1 Array
      (
      [0] => 4
      [1] => 6
      [2] => 7
      )
     * 
     * Массив на выходе
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

     * @param string $name_1 (имя в основном массиве)
     * @param string $name_2 (имя в дополнительном массиве)
     * @param array $arr_1 (основной массив)
     * @param array $arr_2 (дополнительный массив)
     * @return array (слитый массив)
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
     * Функция удаления значения из массива
     *
     * @param array $array (исходный массив)
     * @param array $val (значения, которые необходимо удалить - ['val', 'val2']) 
     * @return array|false $array_return (итоговый массив)
     */
    public static function deleteValInArray($array, $val) {

        if (isset($array) && is_array($array)) {
            $result = array_diff($array, $val);
            $array_return = array_values($result); // Сбрасываем ключи
            return $array_return;
        } else {
            return FALSE;
        }
    }

    /**
     * Функция сброса именованных ключей ассоциированного массива
     * 
     * На входе:
     * 
     * 0 Array
      (
      [0] => Array
      (
      [id] => 3
      [price] => 2
      )
     * 
     * На выходе:
     * 
     * 0 Array
      (
      [0] => Array
      (
      [0] => 3
      [1] => 2
      )
     *
     * @param array $input (исходный массив)
     * @return array $output (итоговый массив)
     */
    public static function resetKeyAssocArray($input) {

        $output = [];
        foreach ($input as $val) {
            array_push($output, array_values($val));
        }

        return $output;
    }

    /**
     * Функция удаления пустого значения из массива
     *
     * @param array $array (исходный массив)
     * @return array|false $array_return (итоговый массив)
     */
    public static function deleteEmptyInArray($array) {
        if (isset($array) && is_array($array)) {
            $result = array_filter($array);
            $array_return = array_values($result); // Сбрасываем ключи
            return $array_return;
        } else {
            return FALSE;
        }
    }

    /**
     * Функция получения случайного буквенно-цифрового токена
     *
     * @param string $length (длина токена)
     * @return string $token (токен)
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
     * Функция удаления GET-параметра
     *
     * @param string $str (строка с GET-запросом)
     * @param string $key (параметр, который необходимо удалить)
     * @return string $url (исходящая строка)
     */
    public static function deleteGet($key) {
        parse_str(\eMarket\Valid::inSERVER('QUERY_STRING'), $vars);
        $url = http_build_query(array_diff_key($vars, array($key => '')));
        return '?' . $url;
    }

}

?>
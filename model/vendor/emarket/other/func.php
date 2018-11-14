<?php

// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

namespace eMarket\Other;

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
     * $name_key = 1; - ключ  значения [1], по которому делаем фильтрацию
     * $value_key = 'Россия'; - Значение ключа (=> Россия), по которому делаем фильтрацию
     * $val = 2; - это ключ ячейки Город [2] из которого берется значение Города для нового одномерного массива
     *
     * $mass = $FUNC->filter_array_to_key($array, $value_key, $name_key, $id, $val);
     * 
     * на выходе получаем сортированный массив
     * 
     * [0] => Владивосток
     * [1] => Калининград
     * 
     * @param массив $based_array
     * @param строка $name_key
     * @param строка $value_key
     * @param строка $val
     * @return массив $arr
     */
    public function filter_array_to_key($based_array, $name_key, $value_key, $val) {

        $arr = array();
        foreach ($based_array as $value) {
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
     * Использовать так: $multiselect = $FUNC->array_explode($array, '-');
     * 
     * $array - исходный одномерный массив с разделителем
     * "-" - разделитель
     * 
     * @param массив $array
     * @param строка $delimiter
     * @return массив $array_return
     */
    public function array_explode($array, $delimiter) {
        $array_return = array();
        foreach ($array as $v) {
            $array_return = array_merge($array_return, array(explode($delimiter, $v)));
        }
        return $array_return;
    }

}

?>
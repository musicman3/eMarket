<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Other;

/**
 * Класс для отладочной информации
 *
 * @package Debug
 * @author eMarket
 * 
 */
class Debug {

    /**
     * Удобное отображение массива при отладке
     *
     * @param array $var (массив для отображения)
     */
    public function trace($var) {
        static $int = 0;
        echo '<pre><b>' . $int . '</b> ';
        print_r($var);
        echo '</pre>';
        $int++;
    }

    /**
     * Отображение отладочной информации
     *
     * @param string $time_start (начальное время)
     */
    public function info($time_start) {
        $PDO = new \eMarket\Core\Pdo;
        
        $val = $PDO->getCell("SELECT debug FROM " . TABLE_BASIC_SETTINGS . "", []);
        if ($val == 1) {
            $tend = microtime(1); // Засекаем конечное время
            // Округляем до двух знаков после запятой
            $totaltime = round(($tend - $time_start), 2);
            // Результат на экран
            echo lang('debug_page_generation_time') . " " . $totaltime . " " . lang('debug_sec') . "<br>";
            echo lang('debug_db_queries') . " " . $PDO::$query_count . " " . lang('debug_pcs') . "<br><br>";
        }
    }

}

?>
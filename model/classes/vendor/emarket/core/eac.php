<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

class Eac {

    /**
     * Движок EAC (Engine Ajax Catalog) v.1.0
     * @param строка $TABLE_CATEGORIES (название таблицы категорий)
     * @return массив
     */
    public function start($TABLE_CATEGORIES, $TOKEN) {

        // Устанавливаем parent_id родительской категории
        $parent_id = self::parentIdStart($TABLE_CATEGORIES);

        // Если нажали на кнопку Добавить
        self::addCategory($TABLE_CATEGORIES, $parent_id);

        // Если нажали на кнопку Редактировать
        self::editCategory($TABLE_CATEGORIES);

        $idsx_real_parent_id = $parent_id; //для отправки в JS
        // Если нажали на кнопку Удалить
        $parent_id_delete = self::deleteCategory($TABLE_CATEGORIES, $parent_id);

        // Если нажали на кнопку Вырезать
        $parent_id_cut = self::cutCategory($TABLE_CATEGORIES, $parent_id);

        // Если нажали на кнопку Вставить
        $parent_id_paste = self::pasteCategory($TABLE_CATEGORIES, $parent_id);

        // Если нажали на кнопку Скрыть/Отобразить
        $parent_id_status = self::statusCategory($TABLE_CATEGORIES, $parent_id);

        // Сортировка мышкой EAC
        self::sortList(TABLE_CATEGORIES, $TOKEN);

        if ($parent_id_delete != $parent_id) {
            $parent_id = $parent_id_delete;
        }

        if ($parent_id_cut != $parent_id) {
            $parent_id = $parent_id_cut;
        }

        if ($parent_id_paste != $parent_id) {
            $parent_id = $parent_id_paste;
        }

        if ($parent_id_status != $parent_id) {
            $parent_id = $parent_id_status;
        }

        return array($idsx_real_parent_id, $parent_id);
    }

    /**
     * Установить parent_id родительской категории
     * @param строка $TABLE_CATEGORIES (название таблицы категорий)
     * @return строка $parent_id
     */
    private function parentIdStart($TABLE_CATEGORIES) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;

        // Устанавливаем родительскую категорию
        $parent_id = $VALID->inGET('parent_id');
        if ($parent_id == FALSE) {
            $parent_id = 0;
        }

        // Устанавливаем родительскую категорию при переходе на уровень выше
        if ($VALID->inGET('parent_up')) {
            $parent_id = $PDO->selectPrepare("SELECT parent_id FROM " . $TABLE_CATEGORIES . " WHERE id=?", [$VALID->inGET('parent_up')]);
        }

        // Устанавливаем родительскую категорию при переходе на уровень ниже
        if ($VALID->inGET('parent_down')) {
            $parent_id = $VALID->inGET('parent_down');
        }
        return $parent_id;
    }

    /**
     * Сортировка мышкой в EAC
     * @param строка $TABLE_CATEGORIES (название таблицы категорий)
     * @param строка $TOKEN (токен)
     * @param строка $TOKEN
     */
    public function sortList($TABLE_CATEGORIES, $TOKEN) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;

        // если сортируем категории мышкой
        if ($VALID->inGET('token_ajax') == $TOKEN && $VALID->inGET('ids')) {
            $sort_array_id_ajax = explode(',', $VALID->inGET('ids')); // Массив со списком id под сортировку
            // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
            $sort_array_id = array_values(array_filter($sort_array_id_ajax));

            $sort_array_category = array(); // Массив со списком sort_category под сортировку

            $count_sort_array_id = count($sort_array_id); // Получаем количество значений в массиве

            for ($i = 0; $i < $count_sort_array_id; $i++) {
                $sort_category = $PDO->selectPrepare("SELECT sort_category FROM " . $TABLE_CATEGORIES . " WHERE id=? AND language=? ORDER BY id ASC", [$sort_array_id[$i], lang('#lang_all')[0]]);
                array_push($sort_array_category, $sort_category); // Добавляем данные в массив sort_category
                arsort($sort_array_category); // Сортируем массив со списком sort_category
            }
            // Создаем финальный массив из двух массивов
            $sort_array_final = array_combine($sort_array_id, $sort_array_category);

            for ($i = 0; $i < $count_sort_array_id; $i++) {

                $PDO->inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET sort_category=? WHERE id=?", [(int) $sort_array_final[$sort_array_id[$i]], (int) $sort_array_id[$i]]);
            }
        }
    }

    /**
     * Добавить категорию в EAC
     * @param строка $TABLE_CATEGORIES (название таблицы категорий)
     * @param строка $parent_id
     */
    private function addCategory($TABLE_CATEGORIES, $parent_id) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;

        if ($VALID->inGET('add') == 'ok' && $VALID->inGET(lang('#lang_all')[0])) {

            if ($VALID->inGET('view_cat')) {
                $view_cat = 1;
            } else {
                $view_cat = 0;
            }

            // Получаем последний sort_category в текущем parent_id и увеличиваем его на 1
            $sort_max = $PDO->selectPrepare("SELECT sort_category FROM " . $TABLE_CATEGORIES . " WHERE language=? AND parent_id=? ORDER BY sort_category DESC", [lang('#lang_all')[0], $parent_id]);
            $sort_category = intval($sort_max) + 1;

            // Получаем последний id и увеличиваем его на 1
            $id_max = $PDO->selectPrepare("SELECT id FROM " . $TABLE_CATEGORIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            // добавляем запись для всех вкладок
            for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
                $PDO->inPrepare("INSERT INTO " . $TABLE_CATEGORIES . " SET id=?, name=?, sort_category=?, language=?, parent_id=?, date_added=?, status=?", [$id, $VALID->inGET(lang('#lang_all')[$xl]), $sort_category, lang('#lang_all')[$xl], $parent_id, date("Y-m-d H:i:s"), $view_cat]);
            }
        }
    }

    /**
     * Редактировать категорию в EAC
     * @param строка $TABLE_CATEGORIES (название таблицы категорий)
     */
    private function editCategory($TABLE_CATEGORIES) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;

        if ($VALID->inGET('edit') && $VALID->inGET('name_edit' . lang('#lang_all')[0])) {


            for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
                // обновляем запись
                $PDO->inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET name=?, last_modified=? WHERE id=? AND language=?", [$VALID->inGET('name_edit' . lang('#lang_all')[$xl]), date("Y-m-d H:i:s"), $VALID->inGET('edit'), lang('#lang_all')[$xl]]);
            }
        }
    }

    /**
     * Удаляем категорию в EAC
     * @param строка $TABLE_CATEGORIES (название таблицы категорий)
     * @param строка $parent_id
     * @return строка
     */
    private function deleteCategory($TABLE_CATEGORIES, $parent_id) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;

        if (($VALID->inGET('idsx_delete_key') == 'delete')) {

            $idx = $VALID->inGET('idsx_delete_id');

            $parent_id = self::dataParentIdCategory($TABLE_CATEGORIES, $idx);
            $keys = self::dataKeysCategory($TABLE_CATEGORIES, $idx);

            $count_keys = count($keys); // Получаем количество значений в массиве
            for ($x = 0; $x < $count_keys; $x++) {
                //Удаляем подкатегории
                if ($VALID->inGET('idsx_delete_key') == 'delete') {
                    $PDO->inPrepare("DELETE FROM " . $TABLE_CATEGORIES . " WHERE id=?", [$keys[$x]]);
                }
            }

            //Удаляем основную категорию    
            if ($VALID->inGET('idsx_delete_key') == 'delete') {
                $PDO->inPrepare("DELETE FROM " . $TABLE_CATEGORIES . " WHERE id=?", [$idx]);
            }
        }

        // Если parrent_id является массивом, то
        if (is_array($parent_id) == TRUE) {
            $parent_id = 0;
        }

        return $parent_id;
    }

    /**
     * Вырезаем категорию в EAC
     * @param строка $TABLE_CATEGORIES (название таблицы категорий)
     * @param строка $parent_id
     * @return строка
     */
    private function cutCategory($TABLE_CATEGORIES, $parent_id) {

        $VALID = new \eMarket\Core\Valid;

        if ($VALID->inGET('idsx_cut_marker') == 'cut') { // очищаем буфер обмена, если он был заполнен, при нажатии Вырезать
            unset($_SESSION['buffer']);
        }

        if (($VALID->inGET('idsx_cut_key') == 'cut')) {

            $idx = $VALID->inGET('idsx_cut_id');
            $parent_id_real = (int) $VALID->inGET('idsx_real_parent_id'); // получить значение из JS
            //
            $parent_id = self::dataParentIdCategory($TABLE_CATEGORIES, $idx);

            //Вырезаем основную родительскую категорию    
            if ($VALID->inGET('idsx_cut_key') == 'cut') {
                if (!isset($_SESSION['buffer'])) {
                    $_SESSION['buffer'] = array();
                }
                array_push($_SESSION['buffer'], $idx);
                if ($parent_id_real > 0) {
                    $parent_id = $parent_id_real; // Возвращаемся в свою директорию после обновления
                }
            }
        }

        // Если parrent_id является массивом, то
        if (is_array($parent_id) == TRUE) {
            $parent_id = 0;
        }

        return $parent_id;
    }

    /**
     * Вставляем категорию в EAC
     * @param строка $TABLE_CATEGORIES (название таблицы категорий)
     * @param строка $parent_id
     * @return строка
     */
    private function pasteCategory($TABLE_CATEGORIES, $parent_id) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;

        if (($VALID->inGET('idsx_paste_key') == 'paste')) {
            $parent_id_real = (int) $VALID->inGET('idsx_real_parent_id'); // получить значение из JS
        }

        //Вставляем вырезанные категории    
        if ($VALID->inGET('idsx_paste_key') == 'paste' && isset($_SESSION['buffer']) == TRUE) {
            $count_session_buffer = count($_SESSION['buffer']); // Получаем количество значений в массиве
            for ($buf = 0; $buf < $count_session_buffer; $buf++) {
                // Получаем последний sort_category в текущем parent_id и увеличиваем его на 1
                $sort_max = $PDO->selectPrepare("SELECT sort_category FROM " . $TABLE_CATEGORIES . " WHERE language=? AND parent_id=? ORDER BY sort_category DESC", [lang('#lang_all')[0], $parent_id]);
                $sort_category = intval($sort_max) + 1;
                $PDO->inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET parent_id=?, sort_category=? WHERE id=?", [$parent_id_real, $sort_category, $_SESSION['buffer'][$buf]]);
            }
            unset($_SESSION['buffer']); // очищаем буфер обмена
            if ($parent_id_real > 0) {
                $parent_id = $parent_id_real; // Возвращаемся в свою директорию после вставки
            }
        }
        // Если parrent_id является массивом, то
        if (is_array($parent_id) == TRUE) {
            $parent_id = 0;
        }

        return $parent_id;
    }

    /**
     * Статус категорий в EAC
     * @param строка $TABLE_CATEGORIES (название таблицы категорий)
     * @param строка $parent_id
     * @return строка
     */
    private function statusCategory($TABLE_CATEGORIES, $parent_id) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;

        if (($VALID->inGET('idsx_statusOn_key') == 'statusOn')
                or ( $VALID->inGET('idsx_statusOff_key') == 'statusOff')) {

            $parent_id_real = (int) $VALID->inGET('idsx_real_parent_id'); // получить значение из JS

            if ($VALID->inGET('idsx_statusOn_key') == 'statusOn') {
                $idx = $VALID->inGET('idsx_statusOn_id');
                $status = 1;
            }

            if ($VALID->inGET('idsx_statusOff_key') == 'statusOff') {
                $idx = $VALID->inGET('idsx_statusOff_id');
                $status = 0;
            }

            $parent_id = self::dataParentIdCategory($TABLE_CATEGORIES, $idx);
            $keys = self::dataKeysCategory($TABLE_CATEGORIES, $idx);

            $count_keys = count($keys); // Получаем количество значений в массиве
            for ($x = 0; $x < $count_keys; $x++) {

                //Обновляем статус подкатегорий
                if (($VALID->inGET('idsx_statusOn_key') == 'statusOn')
                        or ( $VALID->inGET('idsx_statusOff_key') == 'statusOff')) {
                    $PDO->inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET status=? WHERE id=?", [$status, $keys[$x]]);
                    if ($parent_id_real > 0) {
                        $parent_id = $parent_id_real; // Возвращаемся в свою директорию после "Вырезать"
                    }
                }
            }

            //Обновляем статус основной категории
            if (($VALID->inGET('idsx_statusOn_key') == 'statusOn')
                    or ( $VALID->inGET('idsx_statusOff_key') == 'statusOff')) {
                $PDO->inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET status=? WHERE id=?", [$status, $idx]);
            }
        }

        // Если parrent_id является массивом, то
        if (is_array($parent_id) == TRUE) {
            $parent_id = 0;
        }

        return $parent_id;
    }

    /**
     * Статус категорий в EAC
     * @param строка $TABLE_CATEGORIES (название таблицы категорий)
     * @param строка $idx
     * @return строка
     */
    private function dataParentIdCategory($TABLE_CATEGORIES, $idx) {

        $PDO = new \eMarket\Core\Pdo;

        // Устанавливаем родительскую категорию
        $parent_id = $PDO->selectPrepare("SELECT parent_id FROM " . $TABLE_CATEGORIES . " WHERE id=?", [$idx]);
        // Устанавливаем родительскую категорию родительской категории
        $parent_id_up = $PDO->selectPrepare("SELECT parent_id FROM " . $TABLE_CATEGORIES . " WHERE id=?", [$parent_id]);
        // считаем одинаковые parent_id
        $parent_id_num = $PDO->getColRow("SELECT id FROM " . $TABLE_CATEGORIES . " WHERE parent_id=?", [$parent_id]);
        // если меньше 2-х значений, то устанавливаем parent_id как родительский родительского
        if (count($parent_id_num) < 2) {
            $parent_id = $parent_id_up;
        }

        return $parent_id;
    }

    /**
     * Статус категорий в EAC
     * @param строка $TABLE_CATEGORIES (название таблицы категорий)
     * @param строка $idx
     * @return строка
     */
    private function dataKeysCategory($TABLE_CATEGORIES, $idx) {

        $PDO = new \eMarket\Core\Pdo;

        //Выбираем данные из БД
        $data_cat = $PDO->inPrepare("SELECT id, parent_id FROM " . $TABLE_CATEGORIES);

        $category = $idx; // id родителя
        $categories = array();
        $keys = array(); // массив ключей
        $keys[] = $category; // добавляем первый ключ в массив
        // В цикле формируем ассоциативный массив разделов
        while ($category = $data_cat->fetch(\PDO::FETCH_ASSOC)) {
            // Проверяем наличие id категории в массиве ключей
            if (in_array($category['parent_id'], $keys)) {
                $categories[$category['parent_id']][] = $category['id'];
                $keys[] = $category['id']; // расширяем массив
            }
        }

        return $keys;
    }

}

?>
<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Движок EAC (Engine Ajax Catalog) v.1.0
 *
 * @package Eac
 * @author eMarket
 * 
 */
class Eac {

    /**
     * Инициализация EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $TOKEN (токен)
     * @param array $resize_param (параметры ресайза)
     * @return array array($idsx_real_parent_id, $parent_id)
     */
    public function start($TABLE_CATEGORIES, $TABLE_PRODUCTS, $TOKEN, $resize_param) {

        $FILES = new \eMarket\Other\Files;

        // Устанавливаем parent_id родительской категории
        $parent_id = self::parentIdStart($TABLE_CATEGORIES);

        // Если нажали на кнопку Добавить
        self::addCategory($TABLE_CATEGORIES, $parent_id);

        // Если нажали на кнопку Редактировать
        self::editCategory($TABLE_CATEGORIES);

        // Загручик изображений (ВСТАВЛЯТЬ ПЕРЕД УДАЛЕНИЕМ)
        $FILES->imgUpload($TABLE_CATEGORIES, 'categories', $resize_param);

        $idsx_real_parent_id = $parent_id; //для отправки в JS
        // Если нажали на кнопку Удалить
        $parent_id_delete = self::deleteCategory($TABLE_CATEGORIES, $TABLE_PRODUCTS, $parent_id);

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

        // Если нажали на кнопку Добавить
        self::addProduct($TABLE_PRODUCTS, $parent_id);

        return array($idsx_real_parent_id, $parent_id);
    }

    /**
     * Первоначальная установка parent_id родительской категории
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @return string $parent_id (идентификатор родительской категории)
     */
    private function parentIdStart($TABLE_CATEGORIES) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;

        // Устанавливаем родительскую категорию
        $parent_id = $VALID->inPOST('parent_id');
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
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $TOKEN (токен)
     */
    public function sortList($TABLE_CATEGORIES, $TOKEN) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;

        // если сортируем категории мышкой
        if ($VALID->inPOST('token_ajax') == $TOKEN && $VALID->inPOST('ids')) {
            $sort_array_id_ajax = explode(',', $VALID->inPOST('ids')); // Массив со списком id под сортировку
            // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
            $sort_array_id = array_values(array_filter($sort_array_id_ajax));

            $sort_array_category = []; // Массив со списком sort_category под сортировку

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
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $parent_id (идентификатор родительской категории)
     */
    private function addCategory($TABLE_CATEGORIES, $parent_id) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;
        $LANG_COUNT = count(lang('#lang_all'));

        if ($VALID->inPOST('add')) {

            if ($VALID->inPOST('view_cat')) {
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
            for ($x = 0; $x < $LANG_COUNT; $x++) {
                $PDO->inPrepare("INSERT INTO " . $TABLE_CATEGORIES . " SET id=?, name=?, sort_category=?, language=?, parent_id=?, date_added=?, status=?", [$id, $VALID->inPOST(lang('#lang_all')[$x]), $sort_category, lang('#lang_all')[$x], $parent_id, date("Y-m-d H:i:s"), $view_cat]);
            }
            // Выводим сообщение об успехе
            $_SESSION['message'] = ['success', lang('action_completed_successfully')];
        }
    }

    /**
     * Редактировать категорию в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     */
    private function editCategory($TABLE_CATEGORIES) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;
        $LANG_COUNT = count(lang('#lang_all'));

        if ($VALID->inPOST('edit')) {

            for ($x = 0; $x < $LANG_COUNT; $x++) {
                // обновляем запись
                $PDO->inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET name=?, last_modified=? WHERE id=? AND language=?", [$VALID->inPOST('name_edit' . lang('#lang_all')[$x]), date("Y-m-d H:i:s"), $VALID->inPOST('edit'), lang('#lang_all')[$x]]);
            }
            // Выводим сообщение об успехе
            $_SESSION['message'] = ['success', lang('action_completed_successfully')];
        }
    }

    /**
     * Удаляем категорию в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $parent_id (идентификатор родительской категории)
     * @return string $parent_id (идентификатор родительской категории)
     */
    private function deleteCategory($TABLE_CATEGORIES, $TABLE_PRODUCTS, $parent_id) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;
        $FUNC = new \eMarket\Other\Func;

        if ($VALID->inPOST('delete')) {

            $idx = $VALID->inPOST('delete');

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'product') {
                    // Это категория
                    $parent_id = self::dataParentIdCategory($TABLE_CATEGORIES, $idx[$i]);
                    $keys = self::dataKeysCategory($TABLE_CATEGORIES, $idx[$i]);

                    $count_keys = count($keys); // Получаем количество значений в массиве
                    for ($x = 0; $x < $count_keys; $x++) {

                        //Удаляем товар  
                        $PDO->inPrepare("DELETE FROM " . $TABLE_PRODUCTS . " WHERE parent_id=?", [$keys[$x]]);

                        //Удаляем подкатегории
                        $PDO->inPrepare("DELETE FROM " . $TABLE_CATEGORIES . " WHERE id=?", [$keys[$x]]);

                        //Удаляем из буффера, если есть
                        if (isset($_SESSION['buffer']) && $_SESSION['buffer'] != FALSE) {
                            $_SESSION['buffer'] = $FUNC->deleteValInArray($_SESSION['buffer'], [$keys[$x]]);
                        }
                    }

                    //Удаляем товар  
                    $PDO->inPrepare("DELETE FROM " . $TABLE_PRODUCTS . " WHERE parent_id=?", [$idx[$i]]);

                    //Удаляем основную категорию    
                    $PDO->inPrepare("DELETE FROM " . $TABLE_CATEGORIES . " WHERE id=?", [$idx[$i]]);

                    //Удаляем из буффера, если есть
                    if (isset($_SESSION['buffer']) && $_SESSION['buffer'] != FALSE) {
                        $_SESSION['buffer'] = $FUNC->deleteValInArray($_SESSION['buffer'], [$idx[$i]]);
                    }

                    // Выводим сообщение об успехе
                    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
                } else {
                    // Это товар
                    //Удаляем товар
                    $id_prod = explode('product_', $idx[$i]);
                    $PDO->inPrepare("DELETE FROM " . $TABLE_PRODUCTS . " WHERE id=?", [$id_prod[1]]);
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
     * Вырезаем категорию в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $parent_id (идентификатор родительской категории)
     * @return string $parent_id (идентификатор родительской категории)
     */
    private function cutCategory($TABLE_CATEGORIES, $parent_id) {

        $VALID = new \eMarket\Core\Valid;

        if ($VALID->inPOST('idsx_cut_marker') == 'cut') { // очищаем буфер обмена, если он был заполнен, при нажатии Вырезать
            unset($_SESSION['buffer']);
        }

        if (($VALID->inPOST('idsx_cut_key') == 'cut')) {

            $idx = $VALID->inPOST('idsx_cut_id');
            for ($i = 0; $i < count($idx); $i++) {
                $parent_id_real = (int) $VALID->inPOST('idsx_real_parent_id'); // получить значение из JS
                //
                $parent_id = self::dataParentIdCategory($TABLE_CATEGORIES, $idx[$i]);

                //Вырезаем основную родительскую категорию    
                if ($VALID->inPOST('idsx_cut_key') == 'cut') {
                    if (!isset($_SESSION['buffer'])) {
                        $_SESSION['buffer'] = [];
                    }
                    array_push($_SESSION['buffer'], $idx[$i]);
                    if ($parent_id_real > 0) {
                        $parent_id = $parent_id_real; // Возвращаемся в свою директорию после обновления
                    }
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
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $parent_id (идентификатор родительской категории)
     * @return string $parent_id (идентификатор родительской категории)
     */
    private function pasteCategory($TABLE_CATEGORIES, $parent_id) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;

        //Вставляем вырезанные категории    
        if ($VALID->inPOST('idsx_paste_key') == 'paste' && isset($_SESSION['buffer']) == TRUE) {

            $parent_id_real = (int) $VALID->inPOST('idsx_real_parent_id'); // получить значение из JS
            $count_session_buffer = count($_SESSION['buffer']); // Получаем количество значений в массиве

            for ($buf = 0; $buf < $count_session_buffer; $buf++) {
                // Получаем последний sort_category в текущем parent_id и увеличиваем его на 1
                $sort_max = $PDO->selectPrepare("SELECT sort_category FROM " . $TABLE_CATEGORIES . " WHERE language=? AND parent_id=? ORDER BY sort_category DESC", [lang('#lang_all')[0], $parent_id_real]);
                $sort_category = intval($sort_max) + 1;
                // Обновляем данные
                $PDO->inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET parent_id=?, sort_category=? WHERE id=?", [$parent_id_real, $sort_category, $_SESSION['buffer'][$buf]]);
            }
            unset($_SESSION['buffer']); // очищаем буфер обмена
            if ($parent_id_real > 0) {
                $parent_id = $parent_id_real; // Возвращаемся в свою директорию после вставки
            }
            // Выводим сообщение об успехе
            $_SESSION['message'] = ['success', lang('action_completed_successfully')];
        }
        // Если parrent_id является массивом, то
        if (is_array($parent_id) == TRUE) {
            $parent_id = 0;
        }

        return $parent_id;
    }

    /**
     * Статус категорий в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $parent_id (идентификатор родительской категории)
     * @return string $parent_id (идентификатор родительской категории)
     */
    private function statusCategory($TABLE_CATEGORIES, $parent_id) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;

        if (($VALID->inPOST('idsx_statusOn_key') == 'statusOn')
                or ( $VALID->inPOST('idsx_statusOff_key') == 'statusOff')) {

            $parent_id_real = (int) $VALID->inPOST('idsx_real_parent_id'); // получить значение из JS

            if ($VALID->inPOST('idsx_statusOn_key') == 'statusOn') {
                $idx = $VALID->inPOST('idsx_statusOn_id');
                $status = 1;
            }

            if ($VALID->inPOST('idsx_statusOff_key') == 'statusOff') {
                $idx = $VALID->inPOST('idsx_statusOff_id');
                $status = 0;
            }
            for ($i = 0; $i < count($idx); $i++) {
                $parent_id = self::dataParentIdCategory($TABLE_CATEGORIES, $idx[$i]);
                $keys = self::dataKeysCategory($TABLE_CATEGORIES, $idx[$i]);

                $count_keys = count($keys); // Получаем количество значений в массиве
                for ($x = 0; $x < $count_keys; $x++) {

                    //Обновляем статус подкатегорий
                    if (($VALID->inPOST('idsx_statusOn_key') == 'statusOn')
                            or ( $VALID->inPOST('idsx_statusOff_key') == 'statusOff')) {
                        $PDO->inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET status=? WHERE id=?", [$status, $keys[$x]]);
                        if ($parent_id_real > 0) {
                            $parent_id = $parent_id_real; // Возвращаемся в свою директорию после "Вырезать"
                        }
                    }
                }

                //Обновляем статус основной категории
                if (($VALID->inPOST('idsx_statusOn_key') == 'statusOn')
                        or ( $VALID->inPOST('idsx_statusOff_key') == 'statusOff')) {
                    $PDO->inPrepare("UPDATE " . $TABLE_CATEGORIES . " SET status=? WHERE id=?", [$status, $idx[$i]]);
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
     * Установка parent_id при навигации в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $idx (идентификатор)
     * @return string $parent_id (идентификатор родительской категории)
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
     * Ключ категорий в EAC
     * @param string $TABLE_CATEGORIES (название таблицы категорий)
     * @param string $idx (идентификатор)
     * @return array $keys
     */
    private function dataKeysCategory($TABLE_CATEGORIES, $idx) {

        $PDO = new \eMarket\Core\Pdo;

        //Выбираем данные из БД
        $data_cat = $PDO->inPrepare("SELECT id, parent_id FROM " . $TABLE_CATEGORIES);

        $category = $idx; // id родителя
        $categories = [];
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

    /**
     * Добавить товар в EAC
     * @param string $TABLE_PRODUCTS (название таблицы товаров)
     * @param string $parent_id (идентификатор родительской категории)
     */
    private function addProduct($TABLE_PRODUCTS, $parent_id) {

        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;
        $LANG_COUNT = count(lang('#lang_all'));

        // Если нажали на кнопку Добавить товар
        if ($VALID->inPOST('product_name_' . lang('#lang_all')[0])) {

            // Формат даты после Datepicker
            if ($VALID->inPOST('date_available')) {
                $date_available = date('Y-m-d', strtotime($VALID->inPOST('date_available')));
            } else {

                $date_available = NULL;
            }

            if ($VALID->inPOST('view_product')) {
                $view_product = 1;
            } else {
                $view_product = 0;
            }

            // Получаем последний id и увеличиваем его на 1
            $id_max = $PDO->selectPrepare("SELECT id FROM " . $TABLE_PRODUCTS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            // добавляем запись для всех вкладок
            for ($x = 0; $x < $LANG_COUNT; $x++) {
                $PDO->inPrepare("INSERT INTO " . $TABLE_PRODUCTS .
                        " SET id=?, name=?, language=?, parent_id=?, date_added=?, date_available=?, model=?, price=?, quantity=?, keyword=?, tags=?, description=?", [$id, $VALID->inPOST('product_name_' . lang('#lang_all')[$x]), lang('#lang_all')[$x], $parent_id, date("Y-m-d H:i:s"), $date_available, $VALID->inPOST('model'), $VALID->inPOST('price'),
                    $VALID->inPOST('quantity'), $VALID->inPOST('keyword_' . lang('#lang_all')[$x]), $VALID->inPOST('tags_' . lang('#lang_all')[$x]), $VALID->inPOST('description_' . lang('#lang_all')[$x])]);
            }
            // Выводим сообщение об успехе
            $_SESSION['message'] = ['success', lang('action_completed_successfully')];
        }
    }

}

?>
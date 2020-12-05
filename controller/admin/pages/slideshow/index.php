<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$settings = json_encode(\eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_SLIDESHOW_PREF . "", [])[0]);

if (\eMarket\Valid::inPOST('slideshow_pref')) {

    if (\eMarket\Valid::inPOST('mouse_stop')) {
        $mouse_stop = 1;
    } else {
        $mouse_stop = 0;
    }
    if (\eMarket\Valid::inPOST('autostart')) {
        $autostart = 1;
    } else {
        $autostart = 0;
    }
    if (\eMarket\Valid::inPOST('cicles')) {
        $cicles = 1;
    } else {
        $cicles = 0;
    }
    if (\eMarket\Valid::inPOST('indicators')) {
        $indicators = 1;
    } else {
        $indicators = 0;
    }
    if (\eMarket\Valid::inPOST('navigation')) {
        $navigation = 1;
    } else {
        $navigation = 0;
    }

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_SLIDESHOW_PREF . " SET show_interval=?, mouse_stop=?, autostart=?, cicles=?, indicators=?, navigation=? WHERE id=?", [\eMarket\Valid::inPOST('show_interval'), $mouse_stop, $autostart, $cicles, $indicators, $navigation, 1]);
    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

// Если нажали на кнопку Добавить
if (\eMarket\Valid::inPOST('add')) {

    // Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('view_slideshow')) {
        $view_slideshow = 1;
    } else {
        $view_slideshow = 0;
    }

    if (\eMarket\Valid::inPOST('start_date')) {
        $start_date = date('Y-m-d', strtotime(\eMarket\Valid::inPOST('start_date')));
    } else {
        $start_date = NULL;
    }
    // Формат даты после Datepicker
    if (\eMarket\Valid::inPOST('end_date')) {
        $end_date = date('Y-m-d', strtotime(\eMarket\Valid::inPOST('end_date')));
    } else {
        $end_date = NULL;
    }

    \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_SLIDESHOW . " SET language=?, url=?, name=?, heading=?, logo=?, date_start=?, date_finish=?, status=?", [\eMarket\Valid::inPOST('set_language'), \eMarket\Valid::inPOST('url'), \eMarket\Valid::inPOST('name'), \eMarket\Valid::inPOST('heading'), json_encode([]), $start_date, $end_date, $view_slideshow]);
    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

// Если нажали на кнопку Редактировать
if (\eMarket\Valid::inPOST('edit')) {

    // Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('view_slideshow')) {
        $view_slideshow = 1;
    } else {
        $view_slideshow = 0;
    }

    if (\eMarket\Valid::inPOST('start_date')) {
        $start_date = date('Y-m-d', strtotime(\eMarket\Valid::inPOST('start_date')));
    } else {
        $start_date = NULL;
    }
    // Формат даты после Datepicker
    if (\eMarket\Valid::inPOST('end_date')) {
        $end_date = date('Y-m-d', strtotime(\eMarket\Valid::inPOST('end_date')));
    } else {
        $end_date = NULL;
    }

    // обновляем запись
    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_SLIDESHOW . " SET url=?, name=?, heading=?, date_start=?, date_finish=?, status=? WHERE id=?", [\eMarket\Valid::inPOST('url'), \eMarket\Valid::inPOST('name'), \eMarket\Valid::inPOST('heading'), $start_date, $end_date, $view_slideshow, \eMarket\Valid::inPOST('edit')]);

    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

// Загручик изображений (ВСТАВЛЯТЬ ПЕРЕД УДАЛЕНИЕМ)
$resize_param = [];
array_push($resize_param, ['125', '94']); // ширина, высота
array_push($resize_param, ['570', '570']);
array_push($resize_param, ['762','762']);
array_push($resize_param, ['986','986']);
array_push($resize_param, ['1194','1194']);

\eMarket\Files::imgUpload(TABLE_SLIDESHOW, 'slideshow', $resize_param);

// Если нажали на кнопку Удалить
if (\eMarket\Valid::inPOST('delete')) {

    // Удаляем
    \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_SLIDESHOW . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);
    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

if (\eMarket\Valid::inGET('slide_lang')) {
    $set_language = \eMarket\Valid::inGET('slide_lang');
} else {
    $set_language = lang('#lang_all')[0];
}

$this_time = time();

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = \eMarket\Pdo::getColRow("SELECT * FROM " . TABLE_SLIDESHOW . " WHERE language=? ORDER BY id DESC", [$set_language]);
$lines_on_page = \eMarket\Set::linesOnPage();
$count_lines = count($lines);
$navigate = \eMarket\Navigation::getLink($count_lines, $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

// Модальное окно
require_once('modal/index.php');
// Модальное окно
require_once('modal/settings.php');

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>
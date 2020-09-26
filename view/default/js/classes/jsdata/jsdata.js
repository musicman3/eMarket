/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Работа с массивами по uid
 *
 * @package JsData
 * @author eMarket
 * 
 */
class JsData {

    /**
     * Добавление данных в массив
     * 
     * @param data {Array} (Данные)
     * @param array {Array} (Входной массив)
     * @param parent {String} (родительский uid)
     * @returns {Array}
     *
     */
    add(data, array, parent = null) {

        if (array.length === 0) {
            var sort_number = 0;
        } else {
            var sort_number = array.length;
        }

        var randomizer = new Randomizer();
        if (parent === null) {
            data.push({uid: randomizer.uid(24), sort: sort_number, parent: 'false'});
        } else {
            data.push({uid: randomizer.uid(24), sort: sort_number, parent: parent});
        }
        array.push(data);

        return array;
    }

    /**
     * Сортировка массива по полю sort
     * 
     * @param input {Array} (Входящий массив)
     * @returns {Array}
     *
     */
    sort(input) {

        var sort_helper = [];
        var output = [];

        for (var x = 0; x < input.length; x++) {
            var sort_id = input[x].length - 1;
            sort_helper.push({id: x, sort: Number(input[x][sort_id]['sort'])});
        }

        sort_helper.sort(function (a, b) {
            return a.sort - b.sort;
        });

        for (var x = 0; x < input.length; x++) {
            var sort_id = input[x].length - 1;
            input[sort_helper[x]['id']][sort_id]['sort'] = x;
            output.push(input[sort_helper[x]['id']]);
        }

        return output;
    }

    /**
     * Удаление данных из массива
     * 
     * @param uid {String} (uid для удаления)
     * @param array {Array} (Входной массив)
     * @returns {Array}
     *
     */
    deleteUid(uid, array) {
        var jsdata = new JsData();

        for (var x = 0; x < array.length; x++) {
            var sort_id = array[x].length - 1;
            if (array[x][sort_id]['uid'] === uid) {
                array.splice(x, 1);
            }
        }
        return jsdata.sort(array);
    }

    /**
     * Редактирование данных в массиве по uid
     * 
     * @param uid {String} (uid для удаления)
     * @param array {Array} (Входной массив)
     * @param data {Array} (Новые данные)
     * @returns {Array}
     *
     */
    editUid(uid, array, data) {

        for (var x = 0; x < array.length; x++) {
            var sort_id = array[x].length - 1;
            if (array[x][sort_id]['uid'] === uid) {
                var temp_data = array[x][sort_id];
                data.push(temp_data);
                array[x] = data;
            }
        }
        return array;
    }

    /**
     * Выбор строки из массива по uid
     * 
     * @param uid {String} (uid для выбора)
     * @param array {Array} (Входной массив)
     * @param flag {String} (флаг для возврата id в массиве)
     * @returns {Array}
     *
     */
    selectUid(uid, array, flag = null) {

        for (var x = 0; x < array.length; x++) {
            var sort_id = array[x].length - 1;
            if (array[x][sort_id]['uid'] === uid) {
                if (flag === null) {
                    return array[x];
                } else {
                    return x;
                }
            }
        }
        return null;
    }

    /**
     * Выбор строки из массива по uid
     * 
     * @param uids {Array} (uids для выбора)
     * @param array {Array} (Входной массив)
     * @returns {Array}
     *
     */
    sortToListUid(uids, array) {

        var jsdata = new JsData();
        var output = array;
        for (var x = 0; x < uids.length; x++) {
            var sort_id = array[x].length - 1;
            var id = jsdata.selectUid(uids[x].split('_')[1], array, 'true');
            output[id][sort_id]['sort'] = x;
        }
        return output;
    }

}
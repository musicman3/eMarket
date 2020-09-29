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
        var jsdata = new JsData();

        if (parent === null) {
            parent = 'false';
        }

        var array_length = jsdata.selectParentUids(parent, array).length;

        if (array_length === 0) {
            var sort_number = 0;
        } else {
            var sort_number = array_length;
        }

        var randomizer = new Randomizer();
        data.push({uid: randomizer.uid(24), sort: sort_number, parent: parent});
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

        input.forEach((string, index) => {
            var sort_id = string.length - 1;
            sort_helper.push({id: index, sort: string[sort_id].sort});
        });

        sort_helper.sort(function (a, b) {
            return a.sort - b.sort;
        });

        input.forEach((string, index) => {
            var sort_id = string.length - 1;
            input[sort_helper[index].id][sort_id].sort = index;
            output.push(input[sort_helper[index].id]);
        });

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

        array.forEach((string, index) => {
            var data = string.length - 1;
            if (string[data].uid === uid) {
                array.splice(index, 1);
                var parent_uids = jsdata.selectParentUids(string[data].parent, array);
                var parent_uids_sort = jsdata.sort(parent_uids);
                array = jsdata.replaceUids(parent_uids_sort, array);
                parent_uids = jsdata.buildTree(array, uid);

                parent_uids.forEach((item) => {
                    array.forEach((item_parent, index) => {
                        var data = item_parent.length - 1;
                        if (item_parent[data].uid === item) {
                            array.splice(index, 1);
                        }
                    });
                });
            }
        });
        return array;
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

        array.forEach((string, index) => {
            var sort_id = string.length - 1;
            if (string[sort_id].uid === uid) {
                var temp_data = string[sort_id];
                data.push(temp_data);
                array[index] = data;
            }
        });
        return array;
    }

    /**
     * Выбор строки из массива по uid
     * 
     * @param uid {String} (uid для выбора)
     * @param array {Array} (Входной массив)
     * @param flag {String} (флаг)
     * @returns {Array}
     *
     */
    selectUid(uid, array, flag = null) {
        var string = null;

        array.forEach((item, index) => {
            var sort_id = item.length - 1;
            if (item[sort_id].uid === uid) {
                string = item;
                if (flag !== null) {
                    string = index;
                }
            }
        });
        return string;
    }

    /**
     * Выбор строк из массива по parent
     * 
     * @param parent {String} (parent для выбора)
     * @param array {Array} (Входной массив)
     * @returns {Array}
     *
     */
    selectParentUids(parent, array) {
        var output = [];

        array.forEach((string) => {
            var sort_id = string.length - 1;
            if (string[sort_id].parent === parent) {
                output.push(string);
            }
        });
        return output;
    }

    /**
     * Замена строк из массива по uids
     * 
     * @param uids_array {String} (Новый массив для замены)
     * @param array {Array} (Входной массив)
     * @returns {Array}
     *
     */
    replaceUids(uids_array, array) {

        array.forEach((string, index) => {
            var sort_id = string.length - 1;
            uids_array.forEach((item) => {
                if (string[sort_id].uid === item[sort_id].uid) {
                    array[index] = item;
                }
            });
        });
        return array;
    }

    /**
     * Сортировка по указанному списку uids
     * 
     * @param uids {Array} (uids для выбора)
     * @param array {Array} (Входной массив)
     * @returns {Array}
     *
     */
    sortToListUid(uids, array) {
        var jsdata = new JsData();
        var output = array;

        uids.forEach((item, index) => {
            var sort_id = array[index].length - 1;
            var id = jsdata.selectUid(item.split('_')[1], array, 'true');
            output[id][sort_id].sort = index;
        });
        return output;
    }

    /**
     * Построение дерева по parent
     * 
     * @param array {Array} (Входной массив)
     * @param uid {String} (uid)
     * @returns {Array}
     *
     */
    buildTree(array, uid) {
        uid = uid || null;
        let result = [];
        var jsdata = new JsData();

        array.forEach((item) => {
            var sort_id = item.length - 1;
            if (item[sort_id].parent === uid) {
                result.push(item[sort_id].uid);
                var recursive = jsdata.buildTree(array, item[sort_id].uid);
                recursive.forEach((rec) => {
                    result.push(rec);
                });
            }
        });
       
        return result;
    }

}
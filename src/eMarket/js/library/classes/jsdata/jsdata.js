/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Working with arrays by uid
 *
 * @package JsData
 * @author eMarket
 * 
 */
class JsData {

    /**
     * Adding data to an array
     * 
     * @param data {Array} (data)
     * @param array {Array} (input)
     * @param parent {String} (parent uid)
     * @returns {Array}
     *
     */
    add(data, array, parent) {
        var jsdata = new JsData();

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
     * Sorting an array by sort field
     * 
     * @param input {Array} (input)
     * @returns {Array}
     *
     */
    sort(input) {
        var sort_helper = [];
        var output = [];

        input.forEach((string, index) => {
            var data_id = string.length - 1;
            sort_helper.push({id: index, sort: string[data_id].sort});
        });

        sort_helper.sort(function (a, b) {
            return a.sort - b.sort;
        });

        input.forEach((string, index) => {
            var data_id = string.length - 1;
            input[sort_helper[index].id][data_id].sort = index;
            output.push(input[sort_helper[index].id]);
        });

        return output;
    }

    /**
     * Removing data from an array
     * 
     * @param uid {String} (uid)
     * @param array {Array} (input)
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
     * Editing data in an array by uid
     * 
     * @param uid {String} (uid)
     * @param array {Array} (input)
     * @param data {Array} (new data)
     * @returns {Array}
     *
     */
    editUid(uid, array, data) {

        array.forEach((string, index) => {
            var data_id = string.length - 1;
            if (string[data_id].uid === uid) {
                var temp_data = string[data_id];
                data.push(temp_data);
                array[index] = data;
            }
        });
        return array;
    }

    /**
     * Selecting a string from an array by uid
     * 
     * @param uid {String} (uid)
     * @param array {Array} (input)
     * @param flag {String} (flag)
     * @returns {Array}
     *
     */
    selectUid(uid, array, flag = null) {
        var string = null;

        array.forEach((item, index) => {
            var data_id = item.length - 1;
            if (item[data_id].uid === uid) {
                string = item;
                if (flag !== null) {
                    string = index;
                }
            }
        });
        return string;
    }

    /**
     * Selecting rows from an array by parent
     * 
     * @param parent {String} (parent)
     * @param array {Array} (input)
     * @returns {Array}
     *
     */
    selectParentUids(parent, array) {
        var output = [];

        array.forEach((string) => {
            var data_id = string.length - 1;
            if (string[data_id].parent === parent) {
                output.push(string);
            }
        });
        return output;
    }

    /**
     * Replacing strings from an array by uids
     * 
     * @param uids_array {String} (new array)
     * @param array {Array} (input)
     * @returns {Array}
     *
     */
    replaceUids(uids_array, array) {

        array.forEach((string, index) => {
            var data_id = string.length - 1;
            uids_array.forEach((item) => {
                if (string[data_id].uid === item[data_id].uid) {
                    array[index] = item;
                }
            });
        });
        return array;
    }

    /**
     * Sort by the specified list of uids
     * 
     * @param uids {Array} (uids)
     * @param array {Array} (input)
     * @returns {Array}
     *
     */
    sortToListUid(uids, array) {
        var jsdata = new JsData();
        var output = array;

        uids.forEach((item, index) => {
            var data_id = array[index].length - 1;
            var id = jsdata.selectUid(item.split('_')[1], array, 'true');
            output[id][data_id].sort = index;
        });
        return output;
    }

    /**
     * Building a tree using parent
     * 
     * @param array {Array} (input)
     * @param uid {String} (uid)
     * @returns {Array}
     *
     */
    buildTree(array, uid) {
        uid = uid || null;
        let result = [];
        var jsdata = new JsData();

        array.forEach((item) => {
            var data_id = item.length - 1;
            if (item[data_id].parent === uid) {
                result.push(item[data_id].uid);
                var recursive = jsdata.buildTree(array, item[data_id].uid);
                recursive.forEach((rec) => {
                    result.push(rec);
                });
            }
        });
       
        return result;
    }

}
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

document.addEventListener("DOMContentLoaded", function () {

    let params = (new URL(document.location)).searchParams;
    var route = params.get('route');

    if (params.get('category_id') !== null && route === 'listing') {
        var cat_id = params.get('category_id');
        document.querySelector('#cat_' + cat_id).closest('ul').setAttribute('aria-expand', 'true');
        if (document.querySelector('#cat_' + cat_id).getElementsByTagName('ul')[0] !== undefined) {
            document.querySelector('#cat_' + cat_id).getElementsByTagName('ul')[0].setAttribute('aria-expand', 'true');
        }
        document.querySelector('#namecat_' + cat_id).classList.add('menu-bold');
        var json_data = JSON.parse(document.querySelector('#data_breadcrumb').dataset.breadcrumbid);
        json_data.forEach(e => document.querySelector('#cat_' + e).closest('ul').setAttribute('aria-expand', 'true'));
    }

    if (route === 'products') {
        var cat_id = JSON.parse(document.querySelector('#data_breadcrumb').dataset.parentid);
        if (cat_id !== '') {
            document.querySelector('#cat_' + cat_id).closest('ul').setAttribute('aria-expand', 'true');
            if (document.querySelector('#cat_' + cat_id).getElementsByTagName('ul')[0] !== undefined) {
                document.querySelector('#cat_' + cat_id).getElementsByTagName('ul')[0].setAttribute('aria-expand', 'true');
            }
            document.querySelector('#namecat_' + cat_id).classList.add('menu-bold');
            var json_data = JSON.parse(document.querySelector('#data_breadcrumb').dataset.breadcrumbid);
            json_data.forEach(e => document.querySelector('#cat_' + e).closest('ul').setAttribute('aria-expand', 'true'));
        }
    }

    var toggle = new Toggle({
        buttonClassExpanded: 'menu-btn-active',
        buttonSelector: 'span',
        parentClassExpanded: 'h6',
        parentClass: 'menu-parent',
        targetClassExpanded: 'small',
        //singleSibling: true,
        targetSelector: '.menu ul ul'
    });

});

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/**
 * Листинг товаров в каталоге
 *
 * @package ProductsListing
 * @author eMarket
 * 
 */
class ProductsListing {
    /**
     * Конструктор
     *
     */
    constructor() {
        ProductsListing.init();
    }
    /**
     * Инициализация
     *
     */
    static init() {
        // При загрузке страницы
        $(document).ready(function () {
            if ($('div#nav_data').data('sortflag') === 'on') {
                sessionStorage.removeItem('sort_id');
            }
            ProductsListing.initGrid();

            $('#list').click(function () {
                ProductsListing.setList();
                sessionStorage.setItem('grid_list', 'list');
            });
            $('#grid').click(function () {
                ProductsListing.setGrid();
                sessionStorage.setItem('grid_list', 'grid');
            });
        });

        // Обработка списка сортировки
        $('.sorting').click(function (event) {
            if (document.getElementById('show_in_stock').checked) {
                var change = 'on';
            } else {
                var change = 'off';
            }
            sessionStorage.setItem('sort_id', event.target.id);
            ProductsListing.getData(event.target.id, change);
        });

        // Обработка кнопки наличия товара
        $('#show_in_stock').on('switchChange.bootstrapSwitch', function (event, state) {
            if (document.getElementById('show_in_stock').checked) {
                var change = 'on';
            } else {
                var change = 'off';
            }
            if (sessionStorage.getItem('sort_id') === null) {
                sort_id = 'default';
            } else {
                var sort_id = sessionStorage.getItem('sort_id');
            }

            ProductsListing.getData(sort_id, change);
        });

        // Обработка навигационных кнопок
        $('.navigation').click(function (event) {
            if (document.getElementById('show_in_stock').checked) {
                var change = 'on';
            } else {
                var change = 'off';
            }
            if (sessionStorage.getItem('sort_id') === null) {
                sort_id = 'default';
            } else {
                var sort_id = sessionStorage.getItem('sort_id');
            }
            var prev = $('div#nav_data').data('prev');
            var next = $('div#nav_data').data('next');

            if (event.target.id === 'prev') {
                ProductsListing.getData(sort_id, change, null, null, prev, next);
            }
            if (event.target.id === 'next') {
                ProductsListing.getData(sort_id, change, prev, next);
            }
        });
    }

    /**
     * Инициализация отображения списка
     *
     */
    static initGrid() {
        if (sessionStorage.getItem('grid_list') === 'list') {
            ProductsListing.setList();
        }
        if (sessionStorage.getItem('grid_list') === 'grid' || sessionStorage.getItem('grid_list') === null) {
            ProductsListing.setGrid();
        }
    }

    /**
     * Отправка данных на сервер
     * @param sort_id {String} (значение sort)
     * @param change {String} (Значение change)
     * @param start {String} (Значение start)
     * @param finish {String} (Значение finish)
     * @param backstart {String} (Значение backstart)
     * @param backfinish {String} (Значение backfinish)
     *
     */
    static getData(sort_id, change, start = null, finish = null, backstart = null, backfinish = null) {
        jQuery.get(window.location.href,
                {sort: sort_id,
                    change: change,
                    start: start,
                    finish: finish,
                    backstart: backstart,
                    backfinish: backfinish},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            $('#listing').replaceWith($(data).find('#listing'));
            $('#show_in_stock').bootstrapSwitch();
            new ProductsListing();
    }
    }

    /**
     * Отображение строками
     *
     */
    static setList() {
        $('#listing .item').removeClass('col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item');
        $('#listing .item').addClass('col-xs-12 list-group-item');
        $('#listing .item-grid').removeClass('active');
        $('#listing .item-list').addClass('active');
    }

    /**
     * Отображение сеткой
     *
     */
    static setGrid() {
        $('#listing .item').removeClass('col-xs-12 list-group-item');
        $('#listing .item').addClass('col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item');
        $('#listing .item-list').removeClass('active');
        $('#listing .item-grid').addClass('active');
    }

    /**
     * Добавить товар в корзину
     * @param id {String} (id товара)
     * @param pcs {String} (количество)
     *
     */
    static addToCart(id, pcs) {
        // Установка синхронного запроса для jQuery.ajax
        jQuery.ajaxSetup({async: false});
        jQuery.get(window.location.href,
                {add_to_cart: id,
                    quantity_product_id: id,
                    pcs_product: pcs},
                AjaxSuccess);
        // Обновление страницы
        function AjaxSuccess(data) {
            $('#cart_bar').replaceWith($(data).find('#cart_bar'));
            $('#message_cart').modal('show');
            $('#show_in_stock').bootstrapSwitch();

            new ProductsListing();
        }
    }

}
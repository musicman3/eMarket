/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global echarts, Ajax */

/**
 * Dashboard
 *
 * @package Dashboard
 * @author eMarket
 * 
 */
class Dashboard {
    /**
     * Constructor
     *
     */
    constructor() {
        Dashboard.json_data = JSON.parse(document.querySelector('#ajax_data').dataset.jsondata);
        this.init();
        this.cardWeekDays();
        this.cardOrdersQuantity();
        this.cardNewOldOrders();
        this.cardProceeds();
    }

    /**
     * Init
     * 
     */
    init() {
        document.querySelector('#years').addEventListener('change', (e) => {
            Ajax.postData(window.location.href, {
                year: document.querySelector('#years').value
            }, true, null, Dashboard.AjaxSuccess).then((data) => {
            });
        });
    }

    /**
     * Ajax Success
     *
     *@param data {Object} (ajax data)
     */
    static AjaxSuccess(data) {
        setTimeout(function () {
            var ajax_data = document.createElement('div');
            ajax_data.innerHTML = data;
            document.querySelector('#dashboard').replaceWith(ajax_data.querySelector('#dashboard'));
            new Dashboard();
        }, 100);
    }

    /**
     * Colors
     * 
     * @return {Object} Colors
     */
    colors() {
        var style = getComputedStyle(document.body);
        var colors = {};
        colors.primary = style.getPropertyValue('--bs-primary');
        colors.secondary = style.getPropertyValue('--bs-secondary');
        colors.success = style.getPropertyValue('--bs-success');
        colors.info = style.getPropertyValue('--bs-info');
        colors.warning = style.getPropertyValue('--bs-warning');
        colors.danger = style.getPropertyValue('--bs-danger');
        colors.light = style.getPropertyValue('--bs-light');
        colors.dark = style.getPropertyValue('--bs-dark');

        return colors;
    }

    /**
     * Orders by days of weeks
     * 
     */
    cardWeekDays() {
        var colors = this.colors();
        var json_data = Dashboard.json_data;

        var myChart = echarts.init(document.querySelector('#week_days'), null,
                {
                    renderer: 'svg',
                    height: '250%'
                });

        var option = {
            color: [colors.primary],
            title: {
                text: json_data.cardWeekDays.titleText,
                textStyle: {
                    fontSize: 15
                },
                left: 'center',
                top: '4%'
            },
            tooltip: {},
            grid: {
                left: '2%',
                right: '4%',
                containLabel: true
            },
            legend: {
                data: json_data.cardWeekDays.legendData,
                left: 'center',
                bottom: '4%'
            },
            xAxis: {
                type: 'category',
                data: json_data.cardWeekDays.xAxisData
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                    name: json_data.cardWeekDays.seriesName,
                    data: json_data.cardWeekDays.seriesData,
                    type: 'line',
                    areaStyle: {}
                }]
        };

        myChart.setOption(option);

        window.addEventListener('resize', function () {
            myChart.resize();
        });
    }

    /**
     * Orders quantity
     * 
     */
    cardOrdersQuantity() {
        var colors = this.colors();
        var json_data = Dashboard.json_data;

        var myChart = echarts.init(document.querySelector('#orders_quantity'), null,
                {
                    renderer: 'svg',
                    height: '250%'
                });

        var option = {
            color: [colors.warning, colors.success, colors.danger, colors.primary, colors.info],
            title: {
                text: json_data.cardOrdersQuantity.titleText,
                textStyle: {
                    fontSize: 15
                },
                left: 'center',
                top: '4%'
            },
            tooltip: {},
            grid: {
                left: '3%',
                right: '4%',
                containLabel: true
            },
            legend: {
                data: json_data.cardOrdersQuantity.legendData,
                left: 'center',
                bottom: '4%'
            },
            xAxis: {
                data: json_data.cardOrdersQuantity.xAxisData
            },
            yAxis: {},
            series: [{
                    name: json_data.cardOrdersQuantity.seriesName,
                    type: 'bar',
                    data: json_data.cardOrdersQuantity.seriesData
                }]
        };

        myChart.setOption(option);

        window.addEventListener('resize', function () {
            myChart.resize();
        });
    }

    /**
     * Proceeds
     * 
     */
    cardProceeds() {
        var colors = this.colors();
        var json_data = Dashboard.json_data;

        var myChart = echarts.init(document.querySelector('#proceeds'), null,
                {
                    renderer: 'svg',
                    height: '250%'
                });

        var option = {
            color: [colors.danger, colors.warning, colors.success, colors.primary, colors.info],
            title: {
                text: json_data.cardAmountOfOrders.titleText,
                textStyle: {
                    fontSize: 15
                },
                left: 'center',
                top: '4%'
            },
            tooltip: {},
            grid: {
                left: '3%',
                right: '4%',
                containLabel: true
            },
            legend: {
                data: json_data.cardAmountOfOrders.legendData,
                left: 'center',
                bottom: '4%'
            },
            xAxis: {
                data: json_data.cardAmountOfOrders.xAxisData
            },
            yAxis: {},
            series: [{
                    name: json_data.cardAmountOfOrders.seriesName,
                    type: 'bar',
                    data: json_data.cardAmountOfOrders.seriesData
                }]
        };

        myChart.setOption(option);

        window.addEventListener('resize', function () {
            myChart.resize();
        });
    }

    /**
     * New and old orders
     * 
     */
    cardNewOldOrders() {
        var colors = this.colors();
        var json_data = Dashboard.json_data;

        var myChart = echarts.init(document.getElementById('new_old_orders'), null,
                {
                    renderer: 'svg',
                    height: '70%'
                });
        var option = {
            color: [colors.success, colors.warning],
            tooltip: {
                trigger: 'item'
            },

            series: [
                {
                    name: json_data.cardNewOldOrders.seriesName,
                    type: 'pie',
                    avoidLabelOverlap: false,

                    label: {
                        show: false,
                        position: 'center'
                    },
                    labelLine: {
                        show: false
                    },
                    data: json_data.cardNewOldOrders.seriesData
                }
            ]
        };

        myChart.setOption(option);

        window.addEventListener('resize', function () {
            myChart.resize();
        });

    }
}
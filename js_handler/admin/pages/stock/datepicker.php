<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!-- Datepicker -->
<script src="/ext/moment/moment.min.js"></script>
<script src="/ext/pikaday/pikaday.js"></script>
<link rel="stylesheet" type="text/css" href="/ext/pikaday/pikaday.css">

<?php if (lang('meta-language') != 'en') { ?>
    <script type="text/javascript" src="/ext/moment/locale/<?php echo lang('meta-language') ?>.js"></script>
<?php } ?>

<script type="text/javascript">
    var picker = new Pikaday({
        field: document.querySelector('#date_available_product_stock'),
        position: 'top left',
        minDate: new Date(),
        toString(date, format) {
            moment.locale(document.documentElement.lang);
            return moment(date).format('L');
        },
        i18n: {
            months: [moment.months()[0], moment.months()[1], moment.months()[2], moment.months()[3], moment.months()[4], moment.months()[5], moment.months()[6], moment.months()[7], moment.months()[8], moment.months()[9], moment.months()[10], moment.months()[11]],
            weekdays: [moment.weekdays()[0], moment.weekdays()[1], moment.weekdays()[2], moment.weekdays()[3], moment.weekdays()[4], moment.weekdays()[5], moment.weekdays()[6]],
            weekdaysShort: [moment.weekdaysMin()[0], moment.weekdaysMin()[1], moment.weekdaysMin()[2], moment.weekdaysMin()[3], moment.weekdaysMin()[4], moment.weekdaysMin()[5], moment.weekdaysMin()[6]]
        }
    });
</script>
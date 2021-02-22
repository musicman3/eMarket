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
    moment.locale(document.documentElement.lang);
    var months = moment.months();
    var weekdays = moment.weekdays();
    var weekdays_min = moment.weekdaysMin();
    var picker = new Pikaday({
        field: document.querySelector('#date_available_product_stock'),
        position: 'top left',
        minDate: new Date(),
        toString(date, format) {
            return moment(date).format('L');
        },
        i18n: {
            months: [months[0], months[1], months[2], months[3], months[4], months[5], months[6], months[7], months[8], months[9], months[10], months[11]],
            weekdays: [weekdays[0], weekdays[1], weekdays[2], weekdays[3], weekdays[4], weekdays[5], weekdays[6]],
            weekdaysShort: [weekdays_min[0], weekdays_min[1], weekdays_min[2], weekdays_min[3], weekdays_min[4], weekdays_min[5], weekdays_min[6]]
        }
    });
</script>
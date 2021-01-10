<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript" src="/model/js/classes/attributes/group_attributes.js"></script>
<script type="text/javascript" src="/model/js/classes/attributes/attributes.js"></script>
<script type="text/javascript" src="/model/js/classes/attributes/values_attribute.js"></script>
<script type="text/javascript" src="/model/js/classes/attributes/attributes_processing.js"></script>
<script type="text/javascript" src="/model/js/classes/jsdata/jsdata.js"></script>

<script type="text/javascript">
    var lang = JSON.parse('<?php echo $lang_attributes ?>');
    new GroupAttributes(lang);
    new Attributes(lang);
    new ValuesAttribute(lang);
</script>
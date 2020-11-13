<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<script type="text/javascript" language="javascript">
$(document).ready(function () {
if ($(document).height() <= $(window).height())
  $(".footerwrap").addClass("navbar-fixed-bottom");
});
</script>

<div class="container-fluid footerwrap">
    <hr>
    <p class="footer text-center">Copyright © 2018-<?php echo date('Y') ?>, <a target=_blank href="https://github.com/musicman3/eMarket">eMarket Team</a>. All rights reserved.</p>
</div>

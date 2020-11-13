<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<?php if (isset($_SESSION['login']) && isset($_SESSION['pass'])) { // Выводим если авторизованы    ?>

    <div id="footerwrap">
        <footer class="clearfix"></footer>

        <div class="container-fluid">
            <div class="row">
                    <p><img src="/view/<?php echo \eMarket\Set::template() ?>/admin/images/emarket.png" width="57" alt="" class="img-responsive center-block"></p>

                    <p>Copyright © 2018-<?php echo date('Y') ?>, <a target=_blank href="https://github.com/musicman3/eMarket">eMarket Team</a>. All rights reserved.</p>
            </div>
        </div>
    </div>

<script type="text/javascript">
$(document).ready(function() {
    $('.navbar a.dropdown-toggle').on('click', function(e) {
        var $el = $(this);
        var $parent = $(this).offsetParent(".dropdown-menu");
        $(this).parent("li").toggleClass('open');

        if(!$parent.parent().hasClass('nav')) {
            $el.next().css({"top": $el[0].offsetTop - 9, "left": $parent.outerWidth() - 2});
        }

        $('.nav li.open').not($(this).parents("li")).removeClass("open");

        return false;
    });
});

$(function() {
  var changeHeightNavbarCollapse = function() {
    $('.navbar-collapse').css({
      maxHeight: $(window).height() - $('.navbar-header').height() + 'px'
    });
  };

  changeHeightNavbarCollapse();

  $(window).resize(function() {
    if (window.innerWidth <= 767) {
      changeHeightNavbarCollapse();
    }
  });

});
</script>

<?php } ?>
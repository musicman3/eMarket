<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="header" class="container-fluid mt-3 mb-3">
    <div class="row align-items-center">
        <div class="col-4">
            <a href="/"><img src="/view/<?php echo \eMarket\Core\Settings::template() ?>/catalog/images/emarket.png" alt="" class="logo img-fluid float-start"></a>
        </div>
        <div class="col-8">
            <form>
                <input hidden name="route" value="listing">
                <div class="input-group">
                    <input type="search" id="search" name="search" placeholder="<?php echo lang('search_name') ?>" class="form-control" required>
                    <button type="submit" class="btn btn-primary bi-search"></button>
                </div>
            </form>
        </div>
    </div>
</div>
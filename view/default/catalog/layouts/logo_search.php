<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="header" class="container-fluid">
    <div class="row">
        <div class="col-sm-4">
            <a href="/"><img src="/view/<?php echo \eMarket\Set::template() ?>/catalog/images/emarket.png" alt="" class="logo img-responsive pull-left"></a>
        </div>
        <div class="col-sm-8">
            <div class="searchbox-margin">
                <form>
                    <div class="input-group">
                        <input hidden name="route" value="listing">
                        <input type="search" id="search" name="search" placeholder="<?php echo lang('search_name') ?>" class="form-control">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
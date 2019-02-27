<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<div id="header" class="container-fluid">
    <div class="row">
	<div class="col-sm-4">
	    <a href="/"><img class="logo img-responsive pull-left" src="/view/<?php echo $SET->template() ?>/catalog/images/emarket.png"></a>
	</div>
	<div class="col-sm-8">
	    <div class="searchbox-margin">
		<form name="quick_find" action="#" method="get" class="form-horizontal">
		    <div class="input-group">
			<input type="search" name="keywords" required="" placeholder="Search" class="form-control">
			<span class="input-group-btn">
			    <button type="submit" class="btn btn-primary">
				    <i class="glyphicon glyphicon-search"></i>
			    </button>
			</span>
		    </div>
		</form>
	    </div>
	</div>
    </div>
</div>
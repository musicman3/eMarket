<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>

</head>
<body>
<br><br><br><br><br>
  <form>
   <input hidden name="i" value="<?php echo $i ?>">
   <input hidden name="lines_p" value="<?php echo $lines_p ?>">
   <p><input type="submit" value=">" action="/controller/admin/pages/error_log/error_log_index.php" formmethod="post"></p>
  </form>
  <form>
   <input hidden name="i2" value="<?php echo $i ?>">
   <input hidden name="lines_p2" value="<?php echo $lines_p ?>">
   <p><input type="submit" value="<" action="/controller/admin/pages/error_log/error_log_index.php" formmethod="post"></p>
  </form>
<table  align="center" width="85%">

<?php	for ($i; $i < $lines_p; $i++) { 

		if (strrpos ($lines[$i], 'PHP Notice:') == true ){ ?><tr><font color="green""><?php echo $lines[$i].'<br>'; ?></font><?php }elseif

		(strrpos ($lines[$i], 'PHP Warning:') == true ){ ?><tr><font color="red""><?php echo $lines[$i].'<br>'; ?></font><?php }elseif

		(strrpos ($lines[$i], 'PHP Warning2:') == true ){ ?><tr><font color="yellow""><?php echo $lines[$i].'<br>'; ?></font><?php }elseif
			
			(strrpos ($lines[$i], 'PHP Parse error:') == true ){ ?><tr><font color="blue""><?php echo $lines[$i].'<br>'; ?></font><?php }else

				echo $lines[$i].'<br>';
			?>

		</tr><?php } ?>
	
</table>
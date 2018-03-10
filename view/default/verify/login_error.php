<?php
/*******************************
	Copyright © 2018 eMarket    
GNU GENERAL PUBLIC LICENSE v.3.0
********************************/
?>

<title><?php echo $lang['title_index'] ?></title>
</head>
<body>

<table cellspacing="0" style="width: 99%; height: 99%">
	<tr align="center">
		<td align="center">
			<form action='login.php' method='post' accept-charset='utf-8' style='display: inline;'>
				<table cellspacing="0" style="border: 1px solid #62AC04; border-radius: 3px; width: 25%">
					<tr align="center">
						<td align="center">
							<br />
							<h3><?php echo $lang['login_error'] ?></h3>
							<input class="button" type="submit" name="button_go_login" value="<?php echo $lang['button_go_login'] ?>" />
							<br />
							<br />
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>

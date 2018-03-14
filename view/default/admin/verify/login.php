<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>

</head>
<body>

<table cellspacing="0" style="margin-top:50px; width: 99%; height: 99%">
	<tr align="center">
		<td align="center">
			<table cellspacing="0" style="border: 1px solid #257DB3; border-radius: 3px; width:25%;">
				<tr align="center">
					<td align="center">
						<form  action='verify_autorize.php' method='post'>
							<table cellspacing="0" style="width: 100%; height: 100%">
								<tr align="center">
									<td align="center" style="border: 1px solid #257DB3; background: #257DB3; color:#ffffff; padding: 4px;"><b><?php echo $lang['login_name'] ?></b><br /></td>
								</tr>
							</table>
							<table>
								<tr>
									<td style="padding-top: 5px;"><input type='text' style='border-radius: 3px;' name='login' size='15' 
										value="<?php echo $lang['email'] ?>" 
										onblur="if(this.value=='') this.value='<?php echo $lang['email'] ?>';" 
										onfocus="if(this.value=='<?php echo $lang['email'] ?>') this.value='';" />
									</td>
								</tr>
								<tr>
									<td style="padding-top: 5px;">
										<input type='password' style='border-radius: 3px;' name='pass' size='15' 
										value="<?php echo $lang['password'] ?>" 
										onblur="if(this.value=='') this.value='<?php echo $lang['password'] ?>';" 
										onfocus="if(this.value=='<?php echo $lang['password'] ?>') this.value='';" />
									</td>
								</tr>
							</table>
							<table>
								<tr>
									<td align="center" style="padding-bottom: 5px;">
										<input class='loginbutton' type='submit' name='ok' value='<?php echo $lang['entrance'] ?>' />
									</td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<?php					
			error_reporting(-1);

			//LOAD LANGUAGES LISTING
			require_once 'includes/languages_listing.php';

			//CHECK FORM
			require_once 'includes/check_form.js.php';

		?>

		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" content="<?php echo $lang['meta-language'] ?>" />
		<meta name="robots" content="noindex,nofollow" />
		<meta name="generator" content="HippoEDIT, Notepad++" />
		<meta name="classification" content="software" />
		<meta name="author" content="eMarket" />
		<meta name="owner" content="eMarket" />
		<meta name="copyright" content="Copyright©2011 by eMarket Team. All right reserved." />

		<link rel="stylesheet" type="text/css" href="../view/default/style.css" media="screen" />
		<title><?php echo $lang['title_login'] ?></title>
	</head>
	<body>
		<table cellspacing="0" style="border: 1px solid #ffffff; border-collapse: collapse; width: 100%; height: 100%">
			<tr align="center">
				<td align="center">
					<table cellspacing="0" style="border: 1px solid #62AC04; border-collapse: collapse; width:33%;">
						<tr align="center">
							<td align="center">
								<form action="install.php" method="post" accept-charset="utf-8" style="display: inline;" onsubmit="return check(this.email.value);">
									<table cellspacing="0" style="border: 1px solid #ffffff; border-collapse: collapse; width: 100%; height: 100%">
										<tr>
											<td align="center" style="border: 1px solid #62AC04; background: #62AC04; color:#ffffff; padding: 8px;">
												<b><?php echo $lang['install_panel'] ?></b>
											</td>
										</tr>
									</table>
									<table>

										<tr>
											<td align="right" style="padding-top: 15px;"><?php echo $lang['server_db'] ?>:</td>
											<td align="left" style="padding-top: 15px;">
												<input type='text' name='server_db' size='15' />
											</td>
										</tr>
										<tr>
											<td align="right"><?php echo $lang['login_db'] ?>:</td>
											<td align="left">
												<input type='text' name='login_db' size='15' />
											</td>
										</tr>
										<tr>
											<td align="right"><?php echo $lang['password_db'] ?>:</td>
											<td align="left">
												<input type='password' name='password_db' size='15' />
											</td>
										</tr>
										<tr>
											<td align="right"><?php echo $lang['database_name'] ?>:</td>
											<td align="left">
												<input type='text' name='database_name' size='15' />
											</td>
										</tr>
										<tr>
											<td align="right"><?php echo $lang['database_prefix'] ?>:</td>
											<td align="left">
												<input type='text' name='database_prefix' size='2' value='emkt_' />
											</td>
										</tr>
										<tr>
											<td align="right"><?php echo $lang['database_port'] ?>:</td>
											<td align="left">
												<input type='text' name='database_port' size='2' value='3306' />
											</td>
										</tr>
										<tr>
											<td align="right"><?php echo $lang['database_type'] ?>:</td>
											<td align="left" style="width: 50%">
												<select name='database_type'>
													<option value='mysql'><?php echo $lang['database_family_mysql'] ?></option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="right"><?php echo $lang['database_family'] ?>:</td>
											<td align="left" style="width: 50%">
												<select name='database_family'>
													<option value='innodb'><?php echo $lang['database_innodb'] ?></option>
													<option value='myisam'><?php echo $lang['database_myisam'] ?></option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="right"><?php echo $lang['hash_method'] ?>:</td>
											<td align="left" style="width: 50%">
												<select name='hash_method'>
													<option value='gost'><?php echo $lang['hash_gost'] ?></option>
													<option value='sha256'><?php echo $lang['hash_sha256'] ?></option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="right"><?php echo $lang['crypt_method'] ?>:</td>
											<td align="left" style="width: 50%">
												<select name='crypt_method'>
													<option value='gost'><?php echo $lang['crypt_gost'] ?></option>
													<option value='blowfish'><?php echo $lang['crypt_blowfish'] ?></option>
													<option value='rijndael-256'><?php echo $lang['crypt_rijndael-256'] ?></option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="right"><?php echo $lang['login_admin'] ?>:</td>
											<td align="left">
												<input id="email" type='text' name='login_admin' size='15' />
											</td>
										</tr>
										<tr>
											<td align="right"><?php echo $lang['password_admin'] ?>:</td>
											<td align="left">
												<input id="password_admin" type='password' name='password_admin' size='15' />
											</td>
										</tr>
										<tr>
											<td align="right"><?php echo $lang['password_admin_confirm'] ?>:</td>
											<td align="left">
												<input id="password_admin_confirm" type='password' name='password_admin_confirm' size='15' />
											</td>
										</tr>

									</table>
									<table>
										<tr>
											<td align="center" style="padding-bottom: 5px; padding-top: 10px;">
												<input type='hidden' name='language' value='<?php echo $deflang ?>' />
												<input class="button" type="submit" name="install_button" value="<?php echo $lang['install_button'] ?>" onclick="return pass_check();" />
											</td>
										</tr>
									</table>
								</form>
								<form action="index.php" method="post" accept-charset="utf-8">
									<table>
										<tr>
											<td align="center" style="padding-bottom: 5px;">
												<select name='language' style="border: 1px solid #ffffff; background: #62AC04; color:#ffffff;" onchange="submit();">
													<option value='<?php echo $dirlist[0] ?>'><?php echo $lang['select_language'] ?></option>
														<?php foreach ($dirlist as $keys => $vol){ ?>
															<option value='<?php echo $vol ?>'><?php echo ucfirst($vol) ?></option>
														<?php } ?>
												</select>
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
	</body>
</html>
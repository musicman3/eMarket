<?php
/*******************************
    Copyright © 2018 eMarket    
GNU GENERAL PUBLIC LICENSE v.3.0
********************************/
?>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="content-language" content="ru" />
<meta name="robots" content="index,follow" />
<meta name="generator" content="Notepad++" />
<meta name="classification" content="magazines" />
<link rel="stylesheet" type="text/css" href="view/default/style/style.css" media="screen" />

<?php

	//CONNECT DB
	require_once('includes/connect.php');

	//AUTORIZATION
	require_once('includes/session_autorize.php');

	//LOGIN END

	//REQUIRE_ONCE PUNYCODE CLASS
	require_once_once('classes/idna_convert.class.php');
	$IDN = new idna_convert();

	//ID MODULE
	$module = $_POST['module'];

	//LICENSE PATCH
	require_once('includes/license_patch.php');

	//ARRAY LICENSE FILES
	$dir_list = array ();
	$dir='../box/'.$directory.'/';

	$Open = opendir ($dir);
	while ($file = readdir ($Open)) {
		$filename = $dir . $file;
		if (is_file ($filename)) {
			$dir_list[$file] = filemtime($filename);
		}
	}
	closedir ($Open);

	arsort ( $dir_list, SORT_NUMERIC );
?>

<head>
	<title><?php echo $lang['create_license'] ?></title>
</head>

<script type="text/javascript">
	function submiter(frm){
		if(confirm("<?php echo $lang['delete_license_quest'] ?>")) document.forms[frm].submit();
		return false;
	}
</script>

<table cellspacing="0" style="border-collapse: collapse; width: 100%">
	<td align="center">
		<table cellspacing="0" style="border-collapse: collapse; width: 75%">
			<tr>
				<td style="border-collapse: collapse;"><a href='index.php'><b><?php echo $lang['back_to_license_listing'] ?></b></a><br /><br /></td>
				<td align="right" style="border-collapse: collapse;"><a href='logout.php'><b><?php echo $lang['exit'] ?></b></a><br /><br /></td>
			</tr>
			<td></td>
			<td align="right" style="border-collapse: collapse;">

				<form style="display: inline;" action="core/new_license.php" method="POST" accept-charset="utf-8">
					<?php echo $lang['input_site'] ?>
					<input type="text" name="site" value="" />
					<input type="hidden" name="module" value='<?php echo $module ?>' />
					<br /><br />
					<?php echo $lang['punycode'] ?>: <input type="checkbox" name="punycode" value="1" />
					<br /><br />
					<input class="button" type="submit" value="<?php echo $lang['create_license_button'] ?>" />
				</form>
				<br /><br /><br />
			</td>

			<table cellspacing="0" style="border: 1px solid #62AC04; border-collapse: collapse; width: 75%">
				<tbody>
					<b><?php echo $lang['license_key_listing'].' "'.$name.'"' ?></b><br /><br />
					<tr style="border: 1px solid #62AC04">
						<td align="center" style="border: 1px solid #62AC04; background: #62AC04; color:#ffffff; padding: 2px"><b><?php echo $lang['number'] ?></b></td>
						<td align="center" style="border: 1px solid #62AC04; background: #62AC04; color:#ffffff; padding: 2px"><b><?php echo $lang['license'] ?></b></td>
						<td align="center" style="border: 1px solid #62AC04; background: #62AC04; color:#ffffff; padding: 2px"><b><?php echo $lang['domen'] ?></b></td>
						<td align="center" style="border: 1px solid #62AC04; background: #62AC04; color:#ffffff; padding: 2px"><b><?php echo $lang['date_create_license'] ?></b></td>
						<td align="center" style="border: 1px solid #62AC04; background: #62AC04; color:#ffffff; padding: 2px"><b><?php echo $lang['action'] ?></b></td>
					</tr>

					<?php
						$number = 1;
						foreach ($dir_list as $file => $mtime) {
							$file_1 = base64_decode (basename ($file, '.dat'));
							$date = date('d.m.Y G:i:s', $mtime);
							if (substr($file_1, 0, 11) != 'http://www.') {
								$filewww=substr($file_1, 7);
								$filewww = base64_encode('http://www.'.$filewww).'.dat';
							?>

							<form style="display: inline;" action="core/delete.php" method="POST" accept-charset="utf-8">
								<tr style="border: 1px solid #62AC04">
									<td align="center" style="border: 1px solid #62AC04; padding: 2px"><?php echo $number ?></td>
									<td style="border: 1px solid #62AC04; padding: 2px"><?php echo substr($IDN->decode($file_1), 7) ?></td>
									<td style="border: 1px solid #62AC04; padding: 2px"><?php echo $file_1 ?></td>
									<td align="center" style="border: 1px solid #62AC04; padding: 2px"><?php echo $date ?></td>
									<td align="center" style="border: 1px solid #62AC04; padding: 2px"><b>
										<input type="hidden" name="license" value="<?php echo $file ?>" />
										<input type="hidden" name="licensewww" value="<?php echo $filewww ?>" />
										<input type="hidden" name="modules" value="<?php echo $module ?>" />
									<input class="button" type="submit" value="<?php echo $lang['delete_license'] ?>" onclick="return submiter('form');" /></b>
									</td>
								</tr>
							</form>

							<?php
								$number=$number+1;
							}
							}
							?>

				</tbody>
			</table>
			<br /><a href='index.php'><b><?php echo $lang['back_to_license_listing'] ?></b></a><br /><br />
		</table>
	</td>
</table>

<?php
	//END CONNECT DATABASE
	require_once('includes/connect_end.php');
?>
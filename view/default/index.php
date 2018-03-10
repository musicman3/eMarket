<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>

<title><?php echo $lang['title_index'] ?></title>

</head>
<body>
<table cellspacing="0" style="width: 99%; height: 99%">
	<tbody>
		<tr align="center">
			<td align="center">
				<form action="pages/new_project.php" method="post" accept-charset="utf-8" style="display: inline;">
					<table cellspacing="0" style="border: 1px solid #FFFFFF; border-collapse: collapse; width: 90%">
						<tbody>
							<tr>
								<td align="left">
									<div style="border: 3px solid #62AC04; background: #62AC04; border-radius: 3px; color:#ffffff; display: inline-block;">
										<?php echo $lang['hash_method'] ?>: <b><?php echo $hash ?></b>
										<br />
										<?php echo $lang['crypt_method'] ?>: <b><?php echo $crypt ?></b>
									</div>
								</td>
								<td align="right">
									<input class="button" id="ButtonAdd" type="submit" value="<?php echo $lang['add_project_button'] ?>" onclick="return pass_check();" />
								</td>
							</tr>
						</tbody>
					</table>
				</form>

				<table cellspacing="0" style="border: 1px solid #62AC04; border-collapse: collapse; width: 90%">
					<tbody>
						<tr align="center" style="border: 1px solid #62AC04; background: #62AC04; color:#ffffff">
							<td style="padding: 4px;"><b><?php echo $lang['number'] ?></b></td>
							<td><b><?php echo $lang['project_name'] ?></b></td>
							<td><b><?php echo $lang['date_create'] ?></b></td>
							<td><b><?php echo $lang['status'] ?></b></td>
							<td><b><?php echo $lang['action'] ?></b></td>
							<td><b><?php echo $lang['action'] ?></b></td>
						</tr>
						<?php $i=0; 
							foreach ($table as $key => $vol){
 								$i=$i+1;
							?>
							<tr align="center" style="border: 1px solid #62AC04;">
								<td style="padding: 4px; border-right: 1px solid #62AC04;"><?php echo $i ?></td>
								<td><?php echo $vol[1] ?></td>
								<td><?php echo date_format(date_create($vol[2]), 'd.m.Y H:i:s') ?></td>

								<?php //CHECK STATUS
									$status = $vol[3];
									if ($status == 'on'){
										$status = 'ON';
									}else{
										$status = 'OFF';
									}
								?>

								<td style="padding: 4px; border-right: 1px solid #62AC04;"><?php echo $status ?></td>
								<td style="width: 134px">
									<form action="/controller/pages/edit_project.php" method="post" accept-charset="utf-8" style="display: inline;">
										<div><input type="hidden" name="edit_id" value="<?php echo $vol[0] ?>" /></div>
										<div><input type="hidden" name="project_name" value="<?php echo $vol[1] ?>" /></div>
										<div><input class="button" type="submit" name="edit_button" value="<?php echo $lang['edit'] ?>" /></div>
									</form>
								</td>
								<td style="width: 134px">
									<div><input class="button" type="submit" name="browse_button" value="<?php echo $lang['browse_project_button'] ?>" /></div>
								</td>
							</tr>
							<?php } ?>
					</tbody>
				</table>

				<br /><br /><a href='/controller/verify/logout.php'><b><?php echo $lang['exit'] ?></b></a>
			</td>
		</tr>
	</tbody>
</table>
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
				<form action="/controller/process/edit_project_complete.php" method="post" accept-charset="utf-8">
					<table cellspacing="0" style="border: 1px solid #62AC04; border-collapse: collapse;">
						<tr>
							<td align="right" style="background: #62AC04; border: 1px solid #62AC04; border-bottom: 1px solid #ffffff; color:#ffffff; padding: 4px;">
								<b><?php echo "Название проекта:" ?></b>
							</td>
							<td align="left" style="border: 1px solid #62AC04; padding: 4px;">
								<input type='text' name='project_name' size='25' value='<?php echo $_POST['project_name'] ?>' style='border-radius: 3px;' />
							</td>
						</tr>
						<tr>
							<td align="right" style="background: #62AC04; border: 1px solid #62AC04; border-bottom: 1px solid #ffffff; color:#ffffff; padding: 4px;">
								<b><?php echo "Статус:" ?></b>
							</td>
							<td align="left" style="border: 1px solid #62AC04; padding: 4px;">
								<select name='project_status' style='border-radius: 3px;'>
									<option value='on'><?php echo "-- ON --" ?></option>
									<option value='off'><?php echo "-- OFF --" ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="right" style="background: #62AC04; border: 1px solid #62AC04; color:#ffffff; padding: 4px;">
								<b><?php echo "Удалить проект?" ?></b>
							</td>
							<td align="left" style="border: 1px solid #62AC04; padding: 4px;">
								<input type='checkbox' name='project_delete' size='25' />
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center" style="border: 1px solid #62AC04; padding: 4px;">
								<div><input type="hidden" name="edit_id" value="<?php echo $_POST['edit_id'] ?>" /></div>
								<div><input class="button" type="submit" name="add_project" value="<?php echo $lang['button_edit'] ?>" /></div>
							</td>
						</tr>
					</table>
				</form>
				<br />
				<br />
				<a href='/controller/index.php'><b><?php echo $lang['back'] ?></b></a>
				<br />
				<br />
				<a href='/controller/verify/logout.php'><b><?php echo $lang['exit'] ?></b></a>
			</td>
		</tr>
	</tbody>
</table>
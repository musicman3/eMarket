<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>

</head>
<body>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td style="padding: 0 5px 0 5px;"><img src="/view/default/admin/images/img.png"></td>
		<td width="330" align="right" style="padding-right: 5px;" >
			<span style="color: #000000;"><b>SSL</b></span>
		</td>
	</tr>
</table>

<div id="administrationMenu" class="ThemeOfficeMainItem">
	
	<ul style="visibility: hidden">
			<?php	for ($i = 0; $i < count($level); $i++) { ?>
			<li>
				<?php echo $level[$i]; ?>
				<ul>
						<?php	for ($x = 0; $x < count($menu[$i]); $x++) { ?>
						<li>
							<?php echo $menu[$i][$x]; ?>
							<ul>
									<?php	for ($y = 0; $y < count($submenu[$i][$x]); $y++) { ?>
									<li>
										<?php echo $submenu[$i][$x][$y]; ?>
									</li>
							<?php } ?>
							</ul>
						</li>
				<?php } ?>
				</ul>
			</li>
	<?php } ?>
	</ul>
	
</div>

<script type="text/javascript"><!--
	cmDrawFromText('administrationMenu', 'hbr', cmThemeOffice, 'ThemeOffice');
//--></script>

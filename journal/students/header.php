<html>
  <head>
    <title><?php echo $lang['electron_jernal'];?> <?=NAME_SCHOOL;?></title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/thickbox.js"></script>
   	<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
   	<script type="text/javascript" src="js/jquery.validate.js"></script>
   	<script type="text/javascript" src="js/messages_ru.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/thickbox.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css" media="screen" />
     <script type="text/javascript" src="highslide/highslide-full.js"></script>
    <link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
    <script type="text/javascript">
	hs.graphicsDir = 'highslide/graphics/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.dimmingOpacity = 0.75;

	// define the restraining box
	hs.useBox = true;
	hs.width = 640;
	hs.height = 480;

	// Add the controlbar
	hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: 1,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
   </script>
  </head>
  <body>
<?php if (isset($_SESSION['student_id']))  { ?>
<script type="text/javascript" src="js/wz_tooltip.js"></script>
<br />
<div align="center">
 <table border="0" cellspacing="0" cellpadding="0" class="table_menu" style="width:200px">
  <tr>
    <td><img src="images/circle_left_top.gif" alt="" width="6" height="6"></td>
    <td valign="top" class="border_top"><img src="images/border.gif" alt="" width="1" height="1"></td>
    <td><img src="images/circle_right_top.gif" alt="" width="6" height="6"></td>
  </tr>
  <tr>
    <td class="border_left">&nbsp;</td>
    <td class="padding"><table>
   <tr>
        <td nowrap="nowrap">&nbsp;<a href="index.php"><?php echo $lang['prosmotr_ocenok'];?></a>&nbsp;</td>
          <td align="center"><img src="images/dec.png" alt="" width="1" height="51"></td>
        <td>&nbsp;<a href="information.php"><?php echo $lang['header_info'];?></a>&nbsp;</td>
        <td align="center"><img src="images/dec.png" alt="" width="1" height="51"></td>
        <td>&nbsp;<a href="index.php?action=logout"><?php echo $lang['header_exit'];?></a>&nbsp;</td>
      </tr>
    </table></td>
    <td class="border_right">&nbsp;</td>
  </tr>
  <tr>
    <td><img src="images/circle_left_bottom.gif" alt="" width="6" height="6"></td>
    <td width="99%" valign="bottom" class="border_bottom"><img src="images/border.gif" alt="" width="1" height="1"></td>
    <td><img src="images/circle_right_bottom.gif" alt="" width="6" height="6"></td>
  </tr>
</table>
</div>
<?php } ?>
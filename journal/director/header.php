<html>
 <head>
    <title>Школьный журнал <?=NAME_SCHOOL;?></title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <link type="text/css" href="../css/jquery-ui.css" rel="stylesheet" />
    <script type="text/javascript" src="../js/jquery.js"></script>
   	<script type="text/javascript" src="../js/jquery-ui.js"></script>
   	<script type="text/javascript" src="../js/ui.datepicker-ru.js"></script>
    <script type="text/javascript" src="../js/thickbox.js"></script>
    <script type="text/javascript" src="../js/ajaxform.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link rel="stylesheet" type="text/css" href="../css/thickbox.css" media="screen" />
 </head>
 
 <script type="text/javascript">
$(document).ready(function(){
    $('.topmenu ul li').hover(
        function() {
            $(this).addClass("active");
            $(this).find('ul').stop(true, true);
            $(this).find('ul').slideDown();
        },
        function() {
            $(this).removeClass("active");
            $(this).find('ul').slideUp('slow');
        }
    );
});

$(document).ready(function(){

	$("ul.subnav").parent().append("<span></span>"); //Only shows drop down trigger when js is enabled - Adds empty span tag after ul.subnav
	
	$("ul.topnav li span").click(function() { //When trigger is clicked...
		
		//Following events are applied to the subnav itself (moving subnav up and down)
		$(this).parent().find("ul.subnav").slideDown('fast').show(); //Drop down the subnav on click

		$(this).parent().hover(function() {
		}, function(){	
			$(this).parent().find("ul.subnav").slideUp('slow'); //When the mouse hovers out of the subnav, move it back up
		});

		//Following events are applied to the trigger (Hover events for the trigger)
		}).hover(function() { 
			$(this).addClass("subhover"); //On hover over, add class "subhover"
		}, function(){	//On Hover Out
			$(this).removeClass("subhover"); //On hover out, remove class "subhover"
	});

});
</script>

 
 <style type="text/css">

a:focus {
	outline: none;
}
.topmenu {
	
	
	position:relative;	
	
}
.topmenu ul, .topmenu ul li{
	margin: 0;	
	padding: 0;	
	display: inline;
	margin-right:1px;
}
.topmenu ul li {
	float: left;
	position:relative;	
	
}
.topmenu ul li span a{
	display: block;
	padding: 2px 10px 18px 1px;
	vertical-align: inherit;
    margin:1px 0px;
	color: #0000000;
	
	border:0px solid #999;
	background: url('images/window.gif') no-repeat 10px center;	
   
}


.topmenu ul li  a{
	display: block;
	padding: 2px 10px 2px 1px;
	vertical-align: inherit;
    margin:1px 0px;
	color: #0000000;
	
	border:0px solid #999;
	background: url('images/window.gif') no-repeat 10px center;	
   
}





.topmenu ul li a:HOVER{
	color: #0000CC;
}

.topmenu ul li ul {
	background-color: #e8efd4;
background: #F8F8FF;
    display: none;
    position:absolute;
    top:40px;
	width:350px;
}

.topmenu ul li ul li {
    display:block;    
    border-top:0px;

}
.active {
    background-color:#eee;
}
</style>



<body>

<?php

if (isset($_SESSION['director_id'])) {

?>

<br />

<div align="center">

 <table border="0" cellspacing="0" cellpadding="0" class="table_menu" style="width:250px">

  <tr>

    <td><img src="../images/circle_left_top.gif" alt="" width="6" height="6"></td>

    <td valign="top" class="border_top"><img src="../images/border.gif" alt="" width="1" height="1"></td>

    <td><img src="../images/circle_right_top.gif" alt="" width="6" height="6"></td>

  </tr>

  <tr>

    <td class="border_left">&nbsp;</td>

    <td class="padding"><table>

      <tr>

       <td>&nbsp;<a href="information.php">Сообщения</a>&nbsp;</td>

        <td align="center"><img src="../images/dec.png" alt="" width="1" height="51"></td>

        <td nowrap="nowrap">&nbsp; 
        
      
     <div class="topmenu"> <ul> 
     <li> <span><a href="#" >Отчеты</a></span>
       <table><tr><td>
            <ul>
             <li><a href="srv.php">Успеваемость по классам</a></li>
			
           </ul> 
        </li></table>
    </ul>
</div>
       </td>   

        <td align="center"><img src="../images/dec.png" alt="" width="1" height="51"></td>

        

      

        <td>&nbsp;<a href="login.php?action=logout">Выход</a>&nbsp;</td>

      </tr>

    </table></td>

    <td class="border_right">&nbsp;</td>

  </tr>

  <tr>

    <td><img src="../images/circle_left_bottom.gif" alt="" width="6" height="6"></td>

    <td width="99%" valign="bottom" class="border_bottom"><img src="../images/border.gif" alt="" width="1" height="1"></td>

    <td><img src="../images/circle_right_bottom.gif" alt="" width="6" height="6"></td>

  </tr>

</table>

</div>

<?php

}

?>


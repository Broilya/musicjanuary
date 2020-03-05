
<div id="rc"><!-- ПРАВАЯ КОЛОНКА!!! -->
	  <span class="right_col">


	  </span></div>
	<div id="lc"><!-- ЛЕВАЯ КОЛОНКА!!! -->
	  <span class="right_left">
      <div class="body_d">
          <center>
<form action="login.php" method="post"  target="_parent">

<input type="hidden" name="action" value="login" />
<input type="hidden" name="action2" value="login" />
<div class="input login">
<label for="inputLogin">Логин:</label><br>
<input name="name" type="text" class="new_mail" value="<?php echo $lang['i_login']?>" onclick='if(this.value=="<?php echo $lang['i_login'];?>"){this.value="";}' onblur='if(this.value==""){this.value="<?php $lang['i_login'];?>";}' /></div><br>
<div class="input passwd"><label for="inputPassword">Пароль:</label><br><input name="pass" type="password" class="new_mail" value="<?php echo $lang['pass'];?>" onclick='if(this.value=="<?php echo $lang['pass']?>"){this.value="";}' onblur='if(this.value==""){this.value="<?php echo $lang['pass']?>";}' /><br>
</div><br>
<div class="input login">
<select name="type" class="new_mail">
<option value="student">Ученик</option>
<option value="parent">Родитель</option>        
<option value="teacher" >Учитель</option>
<option value="director">Директор</option>        
<option value="admin" >Администратор</option>
</select>

</div>

<div><font size=10px></font> </div>

<?php if ($_REQUEST['error'] == "wrong_pincod") { 

?>

<div class="error" id="loginform_error" ><?php echo $lang['wrond_login'];?></div>
<?php 

} 
elseif ($_REQUEST['error'] == "blocked"){
	echo "<div class='error' id='loginform_error' >Учетная запись заблокирована</div>";
}
?>
<div><input type="submit" value="Вход" class="hugeBtn"  tabindex="4">
<span class="input login">
<label for="twoweeks">
<input type="checkbox" id="twoweeks" name="twoweeks" value="yes" autocomplete="no" tabindex="3" style="vertical-align: middle;">
Запомнить</label>
</span></div><p class="forgotten-link"><br><br>
</p></form>             




          
          </center> 

</div></span></div>


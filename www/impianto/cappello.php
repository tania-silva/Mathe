<? include('./impianto/LLP.php'); //TOP ENGINE?>
<div id="cpp">
	<div id="cppBlk">
		<div id="cppLang">
			<p id="selengtxt">Select language</p>
			<ul id="seleng">
				<li><a href="./impianto/lang_change.php?lng=IT" title="Italian">IT</a></li>
				<li><a href="./impianto/lang_change.php?lng=SE" title="Swedish">SE</a></li>
				<li><a href="./impianto/lang_change.php?lng=EN" title="English">EN</a></li>
			</ul>
		</div>
		<div id="cppLogin">
			<? if ($_SESSION["usr_level"] && $_SESSION["usr_level"]!=-1) {  ?>
				<p>
					You are logged in. &nbsp;&nbsp;&nbsp; 
					<?if ($_SESSION["usr_level"]>=2) {?><a href="./reserved.php" id="rsv_area">Reserved Area</a><?}?> 
					<a href="./impianto/inc/logout.php" id="logout">Logout</a>
				</p>
			<?} else {?>
				<form method="post" action="./impianto/inc/check.php">
					<p class="<?=$inp03class?>"><?=$inp03msg?></p>
					<input type="text" id="usr" name="usr" value="username" onBlur="restore(this,'username');" onFocus="modify(this,'username');" />
					<input type="password" id="psw" name="psw" value="password" onBlur="restore(this,'password');" onFocus="modify(this,'password');" />
					<input type="submit" class="submit" value="" />
				</form>
			<?}?>
		</div>
		<div class="clear"></div>
	</div>
</div>

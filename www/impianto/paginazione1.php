<style>


/* PAGINAZIONE NEW */
div.pageNav1 {
	display: block;
	margin: 20px 0 20px 100px;
	font-size: 1.2em;
	font-weight: 400;
}
div.pageNav1 a {
	display: block;
	float: left;
	margin: 0 3px;
	padding: 5px 0;
	width: 40px;
	text-align: center;
	color: #66cdff;
	border: solid 1px #006697;
}
div.pageNav1 a:hover {
	color: #006697;
	background-color: #66cdff;
}
div.pageNav1 a.sel {
	color: #990000;
}
div.pageNav1 a.arrows {
	margin-top: -7px;
	border: none;
	font-size: 1.4em;
	color: #444;
}

</style>
<div class="pageNav1">
	<?php
	$pageDecinaMax=floor($pagine/10)*10;
	
	$pageDecina=floor($page/10)*10;
	if (($page%10)) $pageDecina+=10;
	
	$pageStart=$pageDecina-9;
	$pageStop=$pageDecina;
	
	$pageNext=$pageDecina+10;
	$pagePrev=$pageDecina-10;

	if ($pageDecina>10) {
		$str_pas=basename($_SERVER['PHP_SELF'])."?page=".($pagePrev).$str_query;
		echo "<a href='./".$str_pas."' class='arrows'>&lt;&lt;</a> ";
	}


	for ($i=$pageStart;($i<=$pagine AND $i<=$pageStop);$i++) {
		$str_query="&assId=".$assId."&qstNb=".$qstNb."&srcLevel=".$srcLevel."&srcTopic=".$srcTopic."&srcSubTopic=".$srcSubTopic."&srcValidation=".$srcValidation;
		$str_pas=basename($_SERVER['PHP_SELF'])."?page=".$i.$str_query;
		if ($i==$page) {
			echo "<a class='sel' href='./".$str_pas."'>".$i."</a> ";
		} else {
			echo "<a href='./".$str_pas."'>".$i."</a> ";
		}
	}

	if ($pageNext AND $pageDecina<=$pageDecinaMax) {
		$str_pas=basename($_SERVER['PHP_SELF'])."?page=".($pageNext-9).$str_query;
		echo "<a href='./".$str_pas."' class='arrows'>&gt;&gt;</a> ";
	}
	?>
	<div class="clear"></div>
</div>

<?php include('../inc/function.php'); //FUNZIONI PHP


if(isset($_GET["rqst"])) $rqst=$_GET["rqst"];
if(isset($_GET["idTop"])) $idTop=$_GET["idTop"];
if(isset($_GET["idSub"])) $idSub=$_GET["idSub"];

$sql = "
	SELECT * 
	FROM platform__subtopic 
	WHERE (id_top=$idTop AND hidden=0) 
	ORDER BY name ASC";
$result=mysqli_query($conn,$sql);
$totaleSubtopic=mysqli_num_rows($result);


if ($rqst==1) {

	if ($totaleSubtopic>0) {
		?>
		SubTopic:<br />
		<select name="SubTopic" style="width: 250px;" onchange="keywords1(this.options[this.selectedIndex].value, '<?=$idTop?>');">
			<option value="">All SubTopics</option>
			<?php
			while ($row=mysqli_fetch_array($result)) { 
				$subtopicId=($row["id"]);
				$subtopicName=($row["name"]);
				?><option value="<?=$subtopicId?>"><?=$subtopicName?></option><?php
			}?>
		</select><?php
	} else echo "&nbsp;";

} elseif ($rqst==2) {
									
	if ($totaleSubtopic==0) {
		?>
		Keywords<br />
		<div>
			<?php
			$sql1 = "
				SELECT *  
				FROM platform__keywords 
				WHERE (id_top=$idTop AND id_sub=0) 
				ORDER BY name ASC";
			$result1=mysqli_query($conn,$sql1);

			while ($row1=mysqli_fetch_array($result1)) { 
				$keyId=($row1["id"]);
				$keyName=($row1["name"]);
				?><div style="float: left;width: 300px;margin: 2px 5px 0 0;"><input type="checkbox" name="key<?=$keyId?>" value="<?=$keyId?>" /> <label style="font-size: 1.0em;font-weight: 300;"><?=$keyName?></label></div><?php
			}
			?>
			<div class="clear"></div>
		</div>
		<p style="width: auto;margin: 20px auto;"><input type="submit" value="Find Resources" class="filter" id="filter" style="display: block;padding: 5px 15px;" /></p>
		<?php
	} else echo "&nbsp;";

} elseif ($rqst==3) {
									
		?>
		Keywords<br />
		<div>
			<?php
			$sql1 = "
				SELECT *  
				FROM platform__keywords 
				WHERE (id_top=$idTop AND id_sub=$idSub) 
				ORDER BY name ASC";
			$result1=mysqli_query($conn,$sql1);

			while ($row1=mysqli_fetch_array($result1)) { 
				$keyId=($row1["id"]);
				$keyName=($row1["name"]);
				?><div style="float: left;width: 300px;margin: 2px 5px 0 0;"><input type="checkbox" name="key<?=$keyId?>" value="<?=$keyId?>" /> <label style="font-size: 1.0em;font-weight: 300;"><?=$keyName?></label></div><?php
			}
			?>
			<div class="clear"></div>
		</div>
		<p style="width: auto;margin: 20px auto;"><input type="submit" value="Find Resources" class="filter" id="filter" style="display: block;padding: 5px 15px;" /></p>
		<?php

}elseif($rqst==4){
	if ($totaleSubtopic>0) {
		?>
		<select name="subtopic" style="width: 250px;" onchange="keywords2(this.options[this.selectedIndex].value, '<?=$idTop?>');">
			<option value="">All SubTopics</option>
			<?php
			while ($row=mysqli_fetch_array($result)) { 
				$subtopicId=($row["id"]);
				$subtopicName=($row["name"]);
				?><option value="<?=$subtopicId?>"><?=$subtopicName?></option><?php
			}?>
		</select><?php
	} else echo "&nbsp;";

}elseif($rqst==5){
	if ($totaleSubtopic==0) {
		?>
		<div>
			<?php
			$sql1 = "
				SELECT *  
				FROM platform__keywords 
				WHERE (id_top=$idTop AND id_sub=0) 
				ORDER BY name ASC";
			$result1=mysqli_query($conn,$sql1);

			while ($row1=mysqli_fetch_array($result1)) { 
				$keyId=($row1["id"]);
				$keyName=($row1["name"]);
				?><div style="float: left;width: 300px;margin: 2px 5px 0 0;"><input type="checkbox" name="key<?=$keyId?>" value="<?=$keyId?>" /> <label style="font-size: 1.0em;font-weight: 300;"><?=$keyName?></label></div><?php
			}
			?>
			<div class="clear"></div>
		</div>
		<?php
	} else echo "&nbsp;";

}elseif($rqst==6){
	?>
		<div>
			<?php
			$sql1 = "
				SELECT *  
				FROM platform__keywords 
				WHERE (id_top=$idTop AND id_sub=$idSub) 
				ORDER BY name ASC";
			$result1=mysqli_query($conn,$sql1);

			while ($row1=mysqli_fetch_array($result1)) { 
				$keyId=($row1["id"]);
				$keyName=($row1["name"]);
				?><div style="float: left;width: 300px;margin: 2px 5px 0 0;"><input type="checkbox" name="keywords[]" value="<?=$keyId?>"/> <label style="font-size: 1.0em;font-weight: 300;"><?=$keyName?></label></div><?php
			}
			?>
			<div class="clear"></div>
		</div>
		<?php
}

?>
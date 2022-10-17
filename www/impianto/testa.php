<div id="tst">
	<div id="tstBlk">
		<a href="./index.php"><img src="./impianto/img/logo.png" alt="" class="logo" /></a>
		<!-- <div style="float: left;margin: 70px 0 0 5px;width: 245px;font-size: 1.1em;font-weight: 400;color: #fff;">
			<p>Towards the Recognition of</p>
			<p>Non-discrimination Principles at School</p>
		</div> -->
		<ul id="lnkOrzz">
			<li><a href="./index.php" id="lo_home" <? if (file_name()=="index") echo "class=\"active\"";?> onmouseover="morizzshow('');"><?=$lnk01?></a></li>
			<li><a href="javascript:void(0);" id="lo_mn01" <? if (file_name()=="xxx") echo "class=\"active\"";?> onmouseover="morizzshow('mn01');"><?=$lnk02?></a></li>
			<li><a href="javascript:void(0);" id="lo_mn02" <? if (file_name()=="xxx") echo "class=\"active\"";?> onmouseover="morizzshow('mn02');"><?=$lnk03?></a></li>
			<!-- <li><a href="./CM_community.php" id="lo_video" <? if (file_name()=="community") echo "class=\"active\"";?> onmouseover="morizzshow('');"><?=$lnk04?></a></li> -->

			<li><a href="javascript:void(0);" id="lo_partnership" <? if (file_name()=="schools" OR file_name()=="schools_scheda" OR file_name()=="partnership-ass" OR file_name()=="partnership-ass_scheda" OR file_name()=="contacts" OR file_name()=="contractual_partners") echo "class=\"active\"";?> onmouseover="morizzshow('partnership');"><?=$lnk05?></a></li>
			<li style="width: 110px;"><a href="javascript:void(0);" id="lo_info" <? if (file_name()=="brochure" OR file_name()=="press_review" OR file_name()=="news" OR file_name()=="conferences") echo "class=\"active\"";?> onmouseover="morizzshow('info');"><?=$lnk06?></a></li>
			<li style="width: 110px;"><a href="javascript:void(0);" id="lo_pm" <? if (file_name()=="MNG-wip" OR file_name()=="MNG-wip_report" OR file_name()=="MNG-download" OR file_name()=="MNG-prjdescription" OR file_name()=="MNG-prjresult" OR file_name()=="MNG-prjpartnership" OR file_name()=="MNG-prjmeeting" OR file_name()=="MNG-diss" OR file_name()=="MNG-exploitation") echo "class=\"active\"";?> onmouseover="morizzshow('pm');"><?=$lnk07?></a></li>
		</ul>
		<div id="slo_mn01" class="stlor" onmouseover="morizzshow('mn01');" onmouseout="morizzhidd('mn01');" onmouseleave="morizzhidd('mn01');">
			<div class="s01">
				<p class="intro"><?=$lnk02a?></p>
				<ul>
					<li>
						<a href="./GL_Literature.php"><img src="./impianto/img/slo_01.jpg" width="60" height="40" alt="" />
						<strong><?=$lnk02b?></strong>
						<em><?=$lnk02c?></em></a>
						<div class="clear"></div>
					</li>
					<li>
						<a href="./GL_Teachers.php"><img src="./impianto/img/slo_02.jpg" width="60" height="40" alt="" />
						<strong><?=$lnk02d?></strong>
						<em><?=$lnk02e?></em></a>
						<div class="clear"></div>
					</li>
					<li>
						<a href="./GL_Directors.php"><img src="./impianto/img/slo_02a.jpg" width="60" height="40" alt="" />
						<strong><?=$lnk02f?></strong>
						<em><?=$lnk02g?></em></a>
						<div class="clear"></div>
					</li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
		<div id="slo_mn02" class="stlor" onmouseover="morizzshow('mn02');" onmouseout="morizzhidd('mn02');" onmouseleave="morizzhidd('mn02');">
			<div class="s01">
				<p class="intro"><?=$lnk03a?></p>
				<ul>
					<li>
						<a href="./TK_CAT.php"><img src="./impianto/img/slo_03.jpg" width="60" height="40" alt="" />
						<strong><?=$lnk03b?></strong>
						<em><?=$lnk03c?></em></a>
						<div class="clear"></div>
					</li>
					<li>
						<a href="./TK_DR.php"><img src="./impianto/img/slo_04.jpg" width="60" height="40" alt="" />
						<strong><?=$lnk03d?></strong>
						<em><?=$lnk03e?></em></a>
						<div class="clear"></div>
					</li>
					<li>
						<a href="./TK_ICTLO.php"><img src="./impianto/img/slo_05.jpg" width="60" height="40" alt="" />
						<strong><?=$lnk03f?></strong>
						<em><?=$lnk03g?></em></a>
						<div class="clear"></div>
					</li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
		<div id="slo_partnership" class="stlor" onmouseover="morizzshow('partnership');" onmouseout="morizzhidd('partnership');" onmouseleave="morizzhidd('partnership');">
			<div class="s01">
				<p class="intro"><?=$lnk05a?></p>
				<ul>
					<li>
						<a href="./PRTN_contractual_partners.php"><img src="./impianto/img/slo_10.jpg" width="60" height="40" alt="" />
						<strong><?=$lnk05b?></strong>
						<em><?=$lnk05c?></em></a>
						<div class="clear"></div>
					</li>
					<li>
						<a href="./PRTN_schools.php"><img src="./impianto/img/slo_06.jpg" width="60" height="40" alt="" />
						<strong><?=$lnk05d?></strong>
						<em><?=$lnk05e?></em></a>
						<div class="clear"></div>
					</li>
					<li>
						<a href="./partnership-ass.php"><img src="./impianto/img/slo_12.jpg" width="60" height="40" alt="" />
						<strong><?=$lnk05h?></strong>
						<em><?=$lnk05i?></em></a>
						<div class="clear"></div>
					</li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
		<div id="slo_info" class="stlor" onmouseover="morizzshow('info');" onmouseout="morizzhidd('info');" onmouseleave="morizzhidd('info');">
			<div class="s01">
				<div class="sx">
					<p class="tit"><?=$lnk06?></p>
					<ul class="dot01">
						<li><a href="./brochure.php"><?=$lnk06a?></a></li>
						<li><a href="./contacts.php"><?=$lnk06b?></a></li>
					</ul>
					<p class="tit" style="padding-top: 20px;"><?=$lnk06c?></p>
					<a href="./news.php">
						<?
							$sql = "
								SELECT * 
								FROM news 
								ORDER BY date DESC
								LIMIT 1";
							$result=mysql_query($sql,$conn);

							while ($row=mysql_fetch_array($result)) { 
								$ant_pict_id=$row["id"];
								$ant_title=stripslashes($row["title"]);
								$ant_text=stripslashes($row["text"]);
								$ant_date=$row["date"];
							}
							$ant_pict_path="./data/news/".$ant_pict_id."_ico.jpg";
							$ant_text_short=substr($ant_text,0,110);
							if (strlen($ant_text)>110) $ant_text_short.="...";
						?>
						<strong class="news" style="background-image: url('<?=$ant_pict_path?>?rnd=<?=$rand_n?>');"></strong>
						<em class="news"><?=strip_tags($ant_text_short)?></em>
					</a>
				</div>
				<div class="dx">
					<p class="tit"><?=$lnk06d?></p>
					<p class="intro"><?=$lnk06e?></p>
					<ul>
						<li>
							<a href="./conferences.php">
							<img src="./impianto/img/slo_08.jpg" width="60" height="40" alt="" />
							<strong><?=$lnk06f?></strong>
							<em><?=$lnk06g?></em></a>
							<div class="clear"></div>
						</li>
						<li>
							<a href="./press_review.php"><img src="./impianto/img/slo_09.jpg" width="60" height="40" alt="" />
							<strong><?=$lnk06h?></strong>
							<em><?=$lnk06i?></em></a>
							<div class="clear"></div>
						</li>
					</ul>
				</div>
				<!-- <div class="dx">
					<p class="tit"><?=$lnk06j?></p>
					<ul>
						<li>
							<img src="./impianto/img/slo_10.jpg" width="60" height="40" alt="" />
							<a href="./contractual_partners.php">
							<strong><?=$lnk06k?></strong>
							<em><?=$lnk06l?></em></a>
							<div class="clear"></div>
						</li>
						<li>
							<a href="./schools.php"><img src="./impianto/img/slo_11.jpg" width="60" height="40" alt="" />
							<strong><?=$lnk06m?></strong>
							<em><?=$lnk06n?></em></a>
							<div class="clear"></div>
						</li>
						<li>
							<a href="./partnership-ass.php"><img src="./impianto/img/slo_12.jpg" width="60" height="40" alt="" />
							<strong><?=$lnk06o?></strong>
							<em><?=$lnk06p?></em></a>
							<div class="clear"></div>
						</li>
					</ul>
				</div> -->
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
		<div id="slo_pm" class="stlor" onmouseover="morizzshow('pm');" onmouseout="morizzhidd('pm');" onmouseleave="morizzhidd('pm');">
			<div class="s01">
				<p class="intro"><?=$lnk07a?></p>
				<ul>
					<li><a href="./MNG-prjdescription.php" class="pde"><?=$lnk07b?></a></li>
					<li><a href="./MNG-prjpartnership.php" class="ppa"><?=$lnk07d?></a></li>
					<li><a href="MNG-prjresult.php" class="pre"><?=$lnk07c?></a></li>
					<li><a href="MNG-prjmeeting.php" class="pme"><?=$lnk07e?></a></li>
					<li><a href="https://forum.pixel-online.org/fiction/forums/" class="forum" target="_blank"><?=$lnk08i?></a></li>
				</ul>
				<ul style="float: right;">
					<li><a href="./MNG-wip.php" class="wip"><?=$lnk07f?></a></li>
					<li><a href="./MNG-diss.php" class="dis"><?=$lnk07g?></a></li>
					<li><a href="./MNG-exploitation.php" class="exp"><?=$lnk07i?></a></li>
					<li><a href="./MNG-download.php" class="dar"><?=$lnk07h?></a></li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>

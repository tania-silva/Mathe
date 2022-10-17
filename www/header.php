

	<div class="nascondi">
	<?php include("erasmus_alto.php") ?>
	</div>
	
	<div class="solomobile">
	<?php include("erasmus_mobile.php") ?>
	</div>


    <!-- Header page -->
    <header class="header">
        
		<div class="header-top hidden-tablet-landscape">
            <div class="container">
		
                <div class="header-top-content display-flex col-md-12">
                    <div class="header-top-info">
                        <div class="header-socials">
                            <ul>
                                <li><a href="https://www.facebook.com/MathE-343525106233888/" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://www.youtube.com/channel/UCGKINlc7YgMrHzTIPp2rYcg" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                        <!-- Select language &nbsp;&nbsp;>&nbsp;&nbsp;
						<a href="impianto/lang_change.php?lng=IT" title="Italian">IT</a>
						<a href="impianto/lang_change.php?lng=LT" title="Lithuan">LT</a>
						<a href="impianto/lang_change.php?lng=PT" title="Portuguese">PT</a>
						<a href="impianto/lang_change.php?lng=RO" title="Romanian">RO</a>
						<a href="impianto/lang_change.php?lng=EN" title="English">EN</a> -->
                    </div>
		    
					<div class="header-top-account">
						<div class="container  header-top-info">			    
							<?php if ($_SESSION["guest"] OR !$_SESSION["usr_level"] OR ($_SESSION["usr_level"] && $_SESSION["usr_level"]>0)) {  ?>

								<?php if ($_SESSION["usr_level"] && $_SESSION["usr_level"]!=-1) { ?>
										<div style="float: left"><span>You are logged in.</span></div>
										<?php if ($_SESSION["usr_level"]>=2) {?><div style="float: left;margin-left: 20px;"><a href="./reserved.php" id="rsv_area">Reserved Area</a></div><?php }?> 
										<div style="float: left;margin-left: 20px;"><a href="./impianto/inc/logout.php" id="logout">Logout</a></div>
									</p>
								<?php } elseif ($_SESSION["guest"]) {
									if ($usrTypology=="student") {
										if ($usr_completeProfile==1) $rsvArea="./MP_STUD_welcome.php";
										else $rsvArea="./MP_STUD_completeProfile.php?userId=".$usrId;
									}
									if ($usrTypology=="lecturer") {
										if ($usr_completeProfile==1) $rsvArea="./MP_LECT_welcome.php";
										else $rsvArea="./MP_LECT_completeProfile.php?userId=".$usrId;
									}
									?>
									<div style="float: left"><span>You are logged in.</span></div>
									<div style="float: left;margin-left: 20px;"><a href="<?=$rsvArea?>" id="rsv_area">Reserved Area</a></div> 
									<div style="float: left;margin-left: 20px;"><a href="./impianto/inc/logout.php" id="logout">Logout</a></div>

								<?php } else { ?>
					
									<form method="post"  action="./impianto/inc/check_mathePlatform.php">
										<!-- <i class="fas fa-edit"></i> -->Login
										<span style="margin-right: 15px" class="<?php isset($inp03class) ? $inp03class : '' ?>"><?php isset($inp03msg) ? $inp03msg : '' ?></span>
										<input style="margin-right: 15px" type="text" id="usr" name="usr" value="" placeholder="username"/>
										<input style="margin-right: 15px" type="password" id="psw" name="psw" value="" placeholder="password"/>
										<button type="submit" class="mb-sm-0 " value="" >GO</button>
									</form>
									<i class="fas fa-edit" style="margin-left: 15px;padding-left: 10px;border-left: solid 1px #ccc;"></i><a href="./MP_signIn.php">Register</a>
							
								<?php } ?>
							<?php } ?>
						</div> <!-- container -->
					</div> <!-- header-top-account -->
                </div> <!-- header-top-content -->

            </div> <!-- container -->
        </div> <!-- header-top -->

        <div class="header-bottom hidden-tablet-landscape" id="js-navbar-fixed">
            <div class="container">
                <div class="header-bottom">
                    <div class="header-bottom-content display-flex">
                        <div class="logo nascondi">
                            <a href="index.php">
                                <img src="impianto/img/logo.png" alt="Mathe" style="width: 70%; padding-bottom: 5%; padding-top: 5%; padding-left: 10%">
                            </a>
                        </div>
                        <div class="menu-search display-flex">
                            <nav class="menu">
                                <div>
                                    <ul class="menu-primary">
                                        <li class="menu-item curent-menu-item">
                                            <a href="index.php"><i class="la la-home"></i> Home</a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="#"><i class="la la-archive"></i> Student's Assessment</a>
                                            <ul class="sub-menu">
                                                <li class="menu-item"><a href="./STAS_SNA.php">Self Need Assessment</a></li>
                                                <li class="menu-item"><a href="./STAS_FA.php">Final Assessment</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-item">
                                            <a href="#"><i class="la la-bank"></i> MathE Library</a>
												 <ul class="sub-menu">
                                                <li class="menu-item"><a href="./MALI_VC.php">Video Collection</a></li>
                                                <!-- <li class="menu-item"><a href="./MALI_VL.php">Video Lessons</a></li> -->
												<li class="menu-item"><a href="./MALI_TM.php">Teaching material</a></li>
                                            </ul>
                                        </li>
										<li class="menu-item">
                                            <!-- <a href="./CM_community.php"><i class="la la-thumbs-o-up"></i> Community of Practice</a> -->
                                            <a href="#"><i class="la la-thumbs-o-up"></i> Community of Practice</a>
											<ul class="sub-menu">
												<!-- <?php if ($usr_typology=="lecturer" AND $usr_completeProfile==1) {?><li class="menu-item"><a href="http://localhost/mathe/student-forum/public" target="_blank">Students' Community</a></li><?php }?>
												<?php if ($usr_typology=="lecturer" AND $usr_completeProfile==1) {?><li class="menu-item"><a href="http://localhost/mathe/teacher-forum/public" target="_blank">Lecturers' Community</a></li><?php }?> -->
												<li class="menu-item"><a href="http://localhost/mathe/student-forum/public" target="_blank">Students' Community</a></li>
												<li class="menu-item"><a href="http://localhost/mathe/teacher-forum/public" target="_blank">Lecturers' Community</a></li>
												<li class="menu-item"><a href="./CM_community.php">MathE Around the World</a></li>
                                            </ul>
                                        </li>
										<li class="menu-item">
                                            <a href="#"><i class="la la-info-circle"></i> Information</a>
                                            <ul class="sub-menu" style="left: -70px !important;">
												<li class="menu-item"><a href="./MNG-prjdescription.php">Project Description</a></li>
												<li class="menu-item"><a href="./MNG-tutorials.php">Tutorials</a></li>
                                                <li class="menu-item">
                                                    <a href="#">Partnership</a>
                                                    <ul class="sub-menu" style="left: -200px !important;">
                                                        <li class="menu-item"><a href="PRTN_contractual_partners.php">Contractual Partners</a></li>
														<li class="menu-item"><a href="PRTN_lecturers.php">Lecturers</a></li>
                                                        <li class="menu-item"><a href="partnership-ass.php">Associated Partners</a></li>
                                                    </ul>
                                                </li>
                                                  
                                                <li class="menu-item">
                                                    <a href="#">Info & Contacts</a>
                                                    <ul class="sub-menu" style="left: -200px !important;">
                                                        <li class="menu-item"><a href="brochure.php">Brochure</a></li>
														<li class="menu-item"><a href="contacts.php">Contacts</a></li>
                                                    </ul>
                                                </li>
												<li class="menu-item">
                                                    <a href="#">Events</a>
                                                    <ul class="sub-menu" style="left: -200px !important;">
                                                        <li class="menu-item"><a href="conferences.php">Conferences</a></li>
														<li class="menu-item"><a href="press_review.php">Press Review</a></li>
                                                    </ul>
                                                </li>
                                                <li class="menu-item"><a href="news.php">Latest News</a></li>
												<li class="menu-item"><a href="testimonials.php">Testimonials</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden-tablet-landscape-up header-mobile">
            <div class="header-top-mobile">
                <div class="container-fluid">
                    <div class="logo">
                            <a href="index.php">
                                <img src="impianto/img/logo.png" alt="Mathe" style="width: 60%; padding-bottom: 3%; padding-top: 3%; padding-left: 9%">
                            </a>
                        </div>
						<div style="float: right;">
							<?php if (!$_SESSION["guest"]) {?>
								<a href="./USER-prtLogin.php">
									<img src="images/login_icona.png" alt="" style="margin-left: 18%; width: 30%" />
								</a>
								<button class="hamburger hamburger--spin hidden-tablet-landscape-up" id="toggle-icon">
									<span class="hamburger-box">
										<span class="hamburger-inner">+</span>
									</span>
								</button>
							<?php } else {?>
								<?php 
										if ($usrTypology=="student") {
											if ($usr_completeProfile==1) $rsvArea="./MP_STUD_welcome.php";
											else $rsvArea="./MP_STUD_completeProfile.php?userId=".$usrId;
										}
										if ($usrTypology=="lecturer") {
											if ($usr_completeProfile==1) $rsvArea="./MP_LECT_welcome.php";
											else $rsvArea="./MP_LECT_completeProfile.php?userId=".$usrId;
										}

								?>
								<?php if(substr(file_name(), 0, 7)!="MP_STUD" AND substr(file_name(), 0, 7)!="MP_LECT") {?>
									<a href="<?=$rsvArea?>" id="rsv_area"><img src="images/login_icona.png" alt="" style="margin-left: 18%; width: 30%" /></a>
									<button class="hamburger hamburger--spin hidden-tablet-landscape-up" id="toggle-icon">
										<span class="hamburger-box">
											<span class="hamburger-inner">+</span>
										</span>
									</button>
								<?php }?>
							<?php }?>
						</div>
                </div>
            </div>
            <div class="au-nav-mobile">
                <nav class="menu-mobile">
                    <div>
                        <ul class="au-navbar-menu">
							<li class="menu-item curent-menu-item">
								<a href="index.php"><i class="la la-home"></i> Home</a>
							</li>
							<li class="menu-item">
								<a href="#" class="sub-menu-mobile"><i class="la la-archive"></i> Student's Assessment  ></a>
								<ul class="sub-menu">
									<li class="menu-item"><a href="./STAS_SNA.php">Self Need Assessment</a></li>
									<li class="menu-item"><a href="./STAS_FA.php">Final Assessment</a></li>
								</ul>
							</li>
							<li class="menu-item">
								<a href="#" class="sub-menu-mobile"><i class="la la-bank"></i> MathE Library  ></a>
									<ul class="sub-menu">
									<li class="menu-item"><a href="./MALI_VC.php">Video Collection</a></li>
									<!-- <li class="menu-item"><a href="./MALI_VL.php">Video Lessons</a></li> -->
									<li class="menu-item"><a href="./MALI_TM.php">Teaching material</a></li>
								</ul>
							</li>
							<li class="menu-item">
								<!-- <a href="./CM_community.php"><i class="la la-thumbs-o-up"></i> Community of Practice</a> -->
								<a href="#" class="sub-menu-mobile"><i class="la la-thumbs-o-up"></i> Community of Practice</a>
								<ul class="sub-menu">
									<!-- <?php if ($usr_typology=="lecturer" AND $usr_completeProfile==1) {?><li class="menu-item"><a href="http://localhost/mathe/student-forum/public" target="_blank">Students Community</a></li><?php }?>
									<?php if ($usr_typology=="lecturer" AND $usr_completeProfile==1) {?><li class="menu-item"><a href="http://localhost/mathe/teacher-forum/public" target="_blank">Lecturers Community</a></li><?php }?> -->
									<!--<li class="menu-item"><a href="http://localhost/mathe/teacher-forum/public/">Lecturers' Community</a></li>
                  <li class="menu-item"><a href="http://localhost/mathe/student-forum/public/">Students' Community</a></li>-->
									<li class="menu-item"><a href="http://localhost/mathe/student-forum/public" target="_blank">Students' Community</a></li>
									<li class="menu-item"><a href="http://localhost/mathe/teacher-forum/public" target="_blank">Lecturers' Community</a></li>
									<li class="menu-item"><a href="./CM_community.php">MathE Around the World</a></li>
								</ul>
							</li>
							<!-- <li class="menu-item">
								<a href="#" class="sub-menu-mobile"><i class="la la-thumbs-o-up"></i> Partnership  ></a>
								<ul class="sub-menu">
									<li class="menu-item"><a href="./PRTN_contractual_partners.php">Contractual Partners</a></li>
									<li class="menu-item"><a href="./PRTN_lecturers.php">Lecturers</a></li>
									<li class="menu-item"><a href="./PRTN_students.php">Students</a></li>
									<li class="menu-item"><a href="./partnership-ass.php">Associated Partners</a></li>
								</ul>
							</li> -->
		
							<li class="menu-item">
								<a href="#"class="sub-menu-mobile"><i class="la la-info-circle"></i> Information  ></a>
								<ul class="sub-menu">
									<li class="menu-item"><a href="./MNG-prjdescription.php">Project Description</a></li>
									<li class="menu-item"><a href="./MNG-tutorials.php">Tutorials</a></li>
									<li class="menu-item">
										<a href="#" class="sub-menu-mobile">Partnership</a>
										<ul class="sub-menu" style="margin-left: 50px;">
											<li class="menu-item"><a href="PRTN_contractual_partners.php">Contractual Partners</a></li>
											<li class="menu-item"><a href="PRTN_lecturers.php">Lecturers</a></li>
											<li class="menu-item"><a href="partnership-ass.php">Associated Partners</a></li>
										</ul>
									</li>
									  
									<li class="menu-item">
										<a href="#" class="sub-menu-mobile">Info & Contacts</a>
										<ul class="sub-menu" style="margin-left: 50px;">
											<li class="menu-item"><a href="brochure.php">Brochure</a></li>
											<li class="menu-item"><a href="contacts.php">Contacts</a></li>
										</ul>
									</li>
									<li class="menu-item">
										<a href="#" class="sub-menu-mobile">Events</a>
										<ul class="sub-menu" style="margin-left: 50px;">
											<li class="menu-item"><a href="conferences.php">Conferences</a></li>
											<li class="menu-item"><a href="press_review.php">Press Review</a></li>
										</ul>
									</li>
									<li class="menu-item"><a href="news.php">Latest News</a></li>
									<li class="menu-item"><a href="testimonials.php">Testimonials</a></li>
								</ul>
								<!-- <ul class="sub-menu">
									<li class="menu-item">
										<a href="#" class="sub-menu-mobile">Info & Contacts  ></a>
										<ul class="sub-menu">
											<li class="menu-item"><a href="brochure.php">Brochure</a></li>
											<li class="menu-item"><a href="contacts.php">Contacts</a></li>
										</ul>
									</li>
									<li class="menu-item">
										<a href="#" class="sub-menu-mobile">Events  ></a>
										<ul class="sub-menu">
											<li class="menu-item"><a href="conferences.php">Conferences</a></li>
											<li class="menu-item"><a href="press_review.php">Press Review</a></li>
										</ul>
									</li>
									<li class="menu-item"><a href="news.php">Latest News</a></li>
									<li class="menu-item"><a href="testimonials.php">Testimonials</a></li>
								</ul> -->
							</li>
		
							<!-- <li class="menu-item">
								<a href="#" class="sub-menu-mobile"><i class="la la-list-alt"></i> Project Management  ></a>
								<ul class="sub-menu">
									<li class="menu-item"><a href="./MNG-prjdescription.php">Project Description</a></li>
									<li class="menu-item"><a href="./MNG-prjpartnership.php">Project Partnership</a></li>
									<li class="menu-item"><a href="./MNG-prjresult.php">Project Results</a></li>
									<li class="menu-item"><a href="./MNG-prjmeeting.php">Project Meetings</a></li>
									<li class="menu-item"><a href="./MNG-wip.php">Work in progress</a></li>
									<li class="menu-item"><a href="./MNG-diss.php">Dissemination</a></li>
									<li class="menu-item"><a href="./MNG-exploitation.php">Exploitation</a></li>
									<li class="menu-item"><a href="./MNG-download.php">Download Area</a></li>
								</ul>
							</li> -->
						</ul>
                    </div>
                </nav>
            </div>
            <!-- <div class="clear"></div> -->
            <div class="clear"></div>
        </div>
    </header>

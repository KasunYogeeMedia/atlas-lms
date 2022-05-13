<!-- Header Start -->
	<header class="header clearfix">
		<button type="button" id="toggleMenu" class="toggle_menu"> <i class='uil uil-bars'></i> </button>
		<button id="collapse_menu" class="collapse_menu"> <i class="uil uil-bars collapse_menu--icon "></i> <span class="collapse_menu--label"></span> </button>
		<div class="main_logo" id="logo">
			<a href="<?php echo $url;?>/profile/student_profile.php"><img src="images/logo.png" alt=""></a>
			<a href="<?php echo $url;?>/profile/student_profile.php"><img class="logo-inverse" src="images/ct_logo.png" alt=""></a>
		</div>
		<div class="header_right">
			<ul>
			<?php

								$reid = $_SESSION['reid'];

								$stmt = $DB_con->prepare('SELECT * FROM lmsregister where reid="'.$reid.'"');

								$stmt->execute();

								if($stmt->rowCount() > 0)

								{

								while($row=$stmt->fetch(PDO::FETCH_ASSOC))

								{

								extract($row);

								$reg_id = $row["contactnumber"];

								?>
				<li class="ui dropdown">
					<a href="#" class="opts_account" title="Account"> 
					<?php if($row['image']==""){$pro_img="images/hd_dp.jpg";}else{$pro_img="uploadImg/".$row['image'];} ?><img src="<?php echo $pro_img; ?>" style="object-fit: cover;">
					</a>
					<div class="menu dropdown_account">
						<div class="channel_my">
							<div class="profile_link"> <?php if($row['image']==""){$pro_img="images/hd_dp.jpg";}else{$pro_img="uploadImg/".$row['image'];} ?><img src="<?php echo $pro_img; ?>" style="object-fit: cover;">
								<div class="pd_content">
									<div class="rhte85">
										<h6><?php echo $row['fullname']; ?></h6>
										<div class="mef78" title="Verify"> <i class='uil uil-check-circle'></i> </div>
									</div>
									<span><?php echo "0".(int)$row['contactnumber']; ?></span>
								</div>
							</div> <a href="../index.php" class="dp_link_12">Go Home Page</a> </div>
						<div class="night_mode_switch__btn">
							<a href="#" id="night-mode" class="btn-night-mode"> <i class="uil uil-moon"></i> Night mode <span class="btn-night-mode-switch">
							<span class="uk-switch-button"></span></span>
							</a>
						</div> <a href="bank_payment.php" class="item channel_item">Bank Payment</a> <a href="card_payment.php" class="item channel_item">Card Payment</a> <a href="manual_payment.php" class="item channel_item">Manaul Payment</a> <a href="help.php" class="item channel_item">Help</a> <a href="reviews.php" class="item channel_item">Reviews</a> <a href="../logout.php" class="item channel_item">Logout</a> </div>
				</li>
				<?php 

								} 

								}

								?>
			</ul>
		</div>
	</header>
	<!-- Header End -->
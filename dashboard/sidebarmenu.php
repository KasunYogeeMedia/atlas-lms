<ul class="metismenu" id="menu">
                    <li class="nav-label first">Main Menu</li>
                    <li><a href="home.php" aria-expanded="false">
							<i class="la la-home"></i>
							<span class="nav-text">Dashboard</span>
						</a>
                    </li>
					<li>
					<?php 
					if($admin =='True'){
					echo '<a class="ai-icon" href="admin.php" aria-expanded="false">
							<i class="la la-user-secret"></i>
							<span class="nav-text">Admin</span>
						</a>';
					}else{

					echo '';

					}
					?>
                    </li>
					<li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
							<i class="la la-th-list"></i>
							<span class="nav-text">Filters</span>
						</a>
                        <ul aria-expanded="false">
                            <li>
							<?php 
							if($class =='True'){

							echo '<a href="grade.php">Grade</a>';
			
							}else{

							echo '';

							}
							?>
							</li>
                            <li>
							<?php 
							if($subject =='True'){

							echo '<a href="subject.php">Subject</a>';
			
							}else{

							echo '';

							}
							?>
							</li>
                        </ul>
                    </li>
					<li>
					 <?php 
					 if($students =='True'){

					 echo '<a href="students.php" aria-expanded="false">
							<i class="la la-users"></i>
							<span class="nav-text">Students</span>
						</a>';
			
					}else{

					echo '';

					}
					?>
                    </li>
					<li>
					<?php 
					if($teachers =='True'){

					echo '<a href="attendence.php" aria-expanded="false">
							<i class="la la-file-text"></i>
							<span class="nav-text">Students Attendence</span>
						</a>';
			
					}else{

					echo '';

					}
					?>
                    </li>
					<li>	
					<?php 
					if($teachers =='True'){

					echo '<a href="teachers.php" aria-expanded="false">
							<i class="la la-black-tie"></i>
							<span class="nav-text">Teachers</span>
						</a>';
			
					}else{

					echo '';

					}
					?>
                    </li>
					<li>
					<?php 
					if($class_schedule =='True'){

					echo '<a href="class_schedule.php" aria-expanded="false">
							<i class="la la-slideshare"></i>
							<span class="nav-text">Class Schedule</span>
					      </a>';
					}else{

					echo '';

					}
					?>
                    </li>
					<li>
					<?php 
					if($class_schedule =='True'){

					echo '<a href="class_tute.php" aria-expanded="false">
							<i class="la la-book"></i>
							<span class="nav-text">Class Tute</span>
						  </a>';
					}else{

					echo '';

					}
					?>
                    </li>
					<li>
					<?php 
					if($class_schedule =='True'){

					echo '<a href="ebook.php" aria-expanded="false">
							<i class="la la-bold"></i>
							<span class="nav-text">Digital Books</span>
						  </a>';
					}else{

					echo '';

					}
					?>
                    </li>
					<li>
					<?php 
					if($lesson =='True'){

					echo '<a href="video_lessons.php" aria-expanded="false">
							<i class="la la-play-circle-o"></i>
							<span class="nav-text">Video Lessons</span>
						</a>';
					}else{

					echo '';

					}
					?>
                    </li>
					<li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
							<i class="la la-money"></i>
							<span class="nav-text">Payments</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="manual_payments.php">Manual Payments</a></li>
                            <li><a href="bank_payaments.php">Pending - Bank Payments</a></li>
							<li><a href="paid_bank_payaments.php">Paid - Bank Payments</a></li>
							<li><a href="reject_bank_payaments.php">Reject - Bank Payments</a></li>
                            <li><a href="online_payments.php">Online Payments</a></li>
							<li><a href="teacher_payment.php">Teacher Payment</a></li>
							<li><a href="payment_report.php">Payment Report</a></li>
                        </ul>
                    </li>
					<li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
							<i class="la la-leanpub"></i>
							<span class="nav-text">Mcq Exams</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="exam.php">Exam Details</a></li>
                            <li><a href="exam_results.php">Exam Results</a></li>
                        </ul>
                    </li>
					<li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
							<i class="la la-leanpub"></i>
							<span class="nav-text">Online Paper Exams</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="online_exams.php">Add Online Exams</a></li>
							<li><a href="submissions.php">Student Submitted</a></li>
                        </ul>
                    </li>
					<li><a href="reviews.php" aria-expanded="false">
							<i class="la la-comments-o"></i>
							<span class="nav-text">Reviews</span>
						</a>
                    </li>
					<li><a href="gallery.php" aria-expanded="false">
							<i class="la la-camera-retro"></i>
							<span class="nav-text">Gallery</span>
						</a>
                    </li>
                    <li>
					<?php 
					if($mail =='True'){

					echo '<a href="sms.php" aria-expanded="false">
							<i class="la la-envelope-o"></i>
							<span class="nav-text">SMS</span>
						 </a>';

						 
					}else{

					echo '';

					}
					?>
                    </li>
                    <li>
					<?php 
					if($mail =='True'){

					echo '<a href="getway.php" aria-expanded="false">
							<i class="la la-university"></i>
							<span class="nav-text">Payment Getway Settings</span>
						 </a>';

						 
					}else{

					echo '';

					}
					?>
                    </li>
					<li>
					<?php 
					if($mail =='True'){

				
						 
					echo '<a href="settings.php" aria-expanded="false">
						 <i class="la la-cog"></i>
						 <span class="nav-text">Settings</span>
					  </a>';	 
					}else{

					echo '';

					}
					?>
                    </li>
				</ul>
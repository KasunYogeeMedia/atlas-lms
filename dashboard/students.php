<?php

session_start();

require_once 'includes.php';

include 'conn.php';

require_once 'dbconfig4.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Students | Online Learning Platforms | Dashboard</title>
    <?php
	require_once 'headercss.php';
	?>

</head>

<body>

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="index.php" class="brand-logo">
                <img class="logo-abbr" src="images/logo-white.png" alt="">
                <img class="logo-compact" src="images/logo-text-white.png" alt="">
                <img class="brand-title" src="images/logo-text-white.png" alt="">
                <!--2021.11.11 kasun-->
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            
                        </div>

                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <img src="images/profile/pic1.jpg" width="20" alt=""/>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="admin.php" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2"><?php echo $user_name;?></span>
                                    </a>
                                    <a href="logout.php" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
<?php

require_once 'sidebarmenu.php';

?>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
		
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
				    
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>All Students</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Students</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">All Students</a></li>
                        </ol>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-lg-12">
						<ul class="nav nav-pills mb-3">
							<li class="nav-item"><a href="#list-view" data-toggle="tab" class="nav-link btn-primary mr-1 show active">List View</a></li>
							<li class="nav-item"><a href="#grid-view" data-toggle="tab" class="nav-link btn-primary">Grid View</a></li>
						</ul>
					</div>
					<div class="col-lg-12">
						<div class="row tab-content">
							<div id="list-view" class="tab-pane fade active show col-lg-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">All Students </h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example3" class="table table-bordered">
												<thead>
													<tr>
														<th>ID</th>						
														<th>Action</th>
														<th>Status</th>
														<th>Student</th>
														<th>Grade</th>
														<th>Subject</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
								<?php

								$stmt = $DB_con->prepare('SELECT * FROM lmsregister ORDER BY reid');

								$stmt->execute();

								if($stmt->rowCount() > 0)

								{

								while($row=$stmt->fetch(PDO::FETCH_ASSOC))

								{

								extract($row);

								?>
													<tr>
														<td><?php echo $row['reid']; ?></td>
														<td>
						<a class="btn btn-sm btn-danger" href="delete_students.php?stid=<?php echo $row["reid"]; ?>" onClick="return confirm('Are youe sure remove this student');"><i class="la la-trash-o"></i></a>
						</td>
														<td>
						<?php 
						
							if($row['status'] == "0"){

								echo '<button class="btn btn-primary btn-sm">Pending</button>';

							}else if($row['status'] == "1"){

								echo '<button class="btn btn-success btn-sm">Success</button>';

							}
						
						?>
						</td>
						<td>
														<p><?php if($row['image']==""){$pro_img="../profile/images/hd_dp.jpg";}else{$pro_img="../profile/uploadImg/".$row['image'];} ?><img src="<?php echo $pro_img; ?>" class="pro_pick">
														<strong><?php echo $row['fullname']; ?></strong></p>
														<p><strong>Student Number : <?php echo $row['stnumber']; ?></strong></p>
														<p><strong>Birth Day : <?php echo $row['dob']; ?></strong></p>
														<p><strong>Email : <?php echo $row['email']; ?></strong></p>
														<p><strong>Gender : <?php echo $row['gender']; ?></strong></p>
														<p><strong>School: <?php echo $row['school']; ?></strong></p>
														<p><strong>District : <?php echo $row['district']; ?></strong></p>
														<p><strong>Town/City : <?php echo $row['town']; ?></strong></p>
														<p><strong>Parent Contct No : <?php echo "0".(int)$row['pcontactnumber']; ?></strong></p>
														<p><strong>Contct No/Username : <?php echo "0".(int)$row['contactnumber']; ?></strong></p>
														<p>Address : <?php echo $row['address']; ?></p>
														</td>
														<td><a href="javascript:void(0);"><strong><?php

						$id = $row['level']; 

						$query = $DB_con->prepare('SELECT name FROM lmsclass WHERE cid='.$id);

						$query->execute();

						$result = $query->fetch();

						echo $result['name'];

						 ?></strong></a></td>
														<td><strong><?php
$sub_qury=mysqli_query($conn,"SELECT * FROM lmsreq_subject INNER JOIN lmssubject ON lmsreq_subject.sub_req_sub_id=lmssubject.sid WHERE sub_req_reg_no='$row[contactnumber]'");
while($sub_resalt=mysqli_fetch_array($sub_qury)){
?><?php echo $sub_resalt['name'],"<br>"; ?><?php } ?></strong></td>
														<td><?php echo $row['add_date']; ?></td>											
													</tr>
								<?php } 

								}
								?>
												</tbody>
											</table>
										</div>
									</div>
                                </div>
                            </div>
							<div id="grid-view" class="tab-pane fade col-lg-12">
								<div class="row">
												<tbody>
								<?php

								$stmt = $DB_con->prepare('SELECT * FROM lmsregister ORDER BY reid');

								$stmt->execute();

								if($stmt->rowCount() > 0)

								{

								while($row=$stmt->fetch(PDO::FETCH_ASSOC))

								{

								extract($row);

								?>
									<div class="col-lg-4 col-md-6 col-sm-6 col-12">
										<div class="card">
											<div class="card-body">
												<div class="text-center">
													<div class="profile-photo">
													<?php if($row['image']==""){$pro_img="../profile/images/hd_dp.jpg";}else{$pro_img="../profile/uploadImg/".$row['image'];} ?><img src="<?php echo $pro_img; ?>" class="pro_pick">
													</div>
													<h3 class="mt-4 mb-1"><strong><?php echo $row['fullname']; ?></strong></h3>
													<p class="text-muted"><strong>Classes :- <?php
$sub_qury=mysqli_query($conn,"SELECT * FROM lmsreq_subject INNER JOIN lmssubject ON lmsreq_subject.sub_req_sub_id=lmssubject.sid WHERE sub_req_reg_no='$row[contactnumber]'");
while($sub_resalt=mysqli_fetch_array($sub_qury)){
?><?php echo $sub_resalt['name'],"<br>"; ?><?php } ?></strong></p>
													<ul class="list-group mb-3 list-group-flush">
													    <li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Student Number. :</span><strong><?php echo $row['stnumber']; ?></strong></li>
															 <li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Birth day. :</span><strong><?php echo $row['dob']; ?></strong></li>
															 <li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Email. :</span><strong><?php echo $row['email']; ?></strong></li>
															 <li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Gender. :</span><strong><?php echo $row['gender']; ?></strong></li>
															 <li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">School. :</span><strong><?php echo $row['school']; ?></strong></li>
															 <li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">District. :</span><strong><?php echo $row['district']; ?></strong></li>
															 <li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Town/City. :</span><strong><?php echo $row['town']; ?></strong></li>
																<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Parent Contact No. :</span><strong><?php echo "0".(int)$row['pcontactnumber']; ?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Contact No. :</span><strong><?php echo "0".(int)$row['contactnumber']; ?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Grade :</span><strong><?php

						$id = $row['level']; 

						$query = $DB_con->prepare('SELECT name FROM lmsclass WHERE cid='.$id);

						$query->execute();

						$result = $query->fetch();

						echo $result['name'];

						 ?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Added Date. :</span><strong><?php echo $row['add_date']; ?></strong></li>
													</ul>
													<a class="btn btn-sm btn-danger btn-rounded mt-3 px-4" href="delete_students.php?stid=<?php echo $row["reid"]; ?>" onClick="return confirm('Are youe sure remove this student');"><i class="la la-trash-o"></i></a>
												</div>
											</div>
										</div>
									</div>
<?php } 

								}
								?>
								</div>
							</div>
						</div>
					</div>
				</div>
				
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

		<?php
		require_once 'footer.php';
		?>

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <?php
	require_once 'footerjs.php';
	?>
    
	
	<script>

function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script>

<script>

$(document).ready(function(){

    loadGallery(true, 'a.thumbnail');

    //This function disables buttons when needed
    function disableButtons(counter_max, counter_current){
        $('#lmsow-previous-image, #lmsow-next-image').lmsow();
        if(counter_max == counter_current){
            $('#lmsow-next-image').hide();
        } else if (counter_current == 1){
            $('#lmsow-previous-image').hide();
        }
    }

    /**
     *
     * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
     * @param setClickAttr  Sets the attribute for the click handler.
     */

    function loadGallery(setIDs, setClickAttr){
        var current_image,
            selector,
            counter = 0;

        $('#lmsow-next-image, #lmsow-previous-image').click(function(){
            if($(this).attr('id') == 'lmsow-previous-image'){
                current_image--;
            } else {
                current_image++;
            }

            selector = $('[data-image-id="' + current_image + '"]');
            updateGallery(selector);
        });

        function updateGallery(selector) {
            var $sel = selector;
            current_image = $sel.data('image-id');
            $('#image-gallery-caption').text($sel.data('caption'));
            $('#image-gallery-title').text($sel.data('title'));
            $('#image-gallery-image').attr('src', $sel.data('image'));
            disableButtons(counter, $sel.data('image-id'));
        }

        if(setIDs == true){
            $('[data-image-id]').each(function(){
                counter++;
                $(this).attr('data-image-id',counter);
            });
        }
        $(setClickAttr).on('click',function(){
            updateGallery($(this));
        });
    }
});
</script>

<script>

		function Publilmsed_tealmsrs(id){
			
			$.ajax({
				url:'publilmsed_tealmsrs.php',
				method:'POST',
				data:{id:id},
				success:function(data){
					location.reload();

				}
			});

		}

		function Reject_ads(id){
				alert(id);
		$.ajax({
			url:'reject_tealmsrs.php',
			method:'POST',
			data:{id:id},
			success:function(data){
				location.reload();

			}
		});

	}
</script>
	
</body>
</html>
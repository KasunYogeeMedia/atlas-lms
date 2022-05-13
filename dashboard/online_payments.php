<?php



session_start();



require_once 'includes.php';



include 'dbconfig4.php';



require_once("conn.php");



if(isset($_GET['pid'])&&isset($_GET['status'])){

	$pid=mysqli_real_escape_string($conn,$_GET['pid']);

	$status=mysqli_real_escape_string($conn,$_GET['status']);

	

	mysqli_query($conn,"UPDATE lmspayment SET status='$status' WHERE pid='$pid'");

	echo "<script>window.location='online_payments.php?pid=$pid';</script>";

}



if(isset($_POST['all_archive'])){

	mysqli_query($conn,"UPDATE lmspayment SET status='3' WHERE paymentMethod='Online'");

	echo "<script>window.location='online_payments.php';</script>";

}

?>



<!DOCTYPE html>

<html lang="en">



<head>

	

	<meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>Online Card Payments | Online Learning Platforms | Dashboard</title>

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

                            <h4>Online Card Payments</h4>

                        </div>

                    </div>

                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>

                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Online Card Payments</a></li>

                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Online Card Payments</a></li>

                        </ol>

                    </div>

                </div>

				

				<div class="row">

					<div class="col-lg-12">

						<ul class="nav nav-pills mb-3">

							<li class="nav-item">

							<form method="post">

							<button type="submit" class="nav-link btn btn-square btn-secondary mr-1 show active" name="all_archive"><i class="fa fa-archive"></i> Archive All</button>	

							</form>	

							</li>

						</ul>

					</div>

					<div class="col-lg-12">

						<div class="row tab-content">

							<div id="list-view" class="tab-pane fade active show col-lg-12">

								<div class="card">

									<div class="card-header">

										<h4 class="card-title">Online Card Payments</h4>

									</div>

									<div class="card-body">

										<div class="table-responsive">

											<table id="example3" class="table table-bordered">

												<thead>

													<tr>

<th>#</th>

<th>Action</th>

<th>Status</th>

<th>Student</th>

<th>Subject/Grade</th>

<th>Class Fee</th>

<th>Valid Date - Paid Month</th>

<th>Pay Date</th>


													</tr>

												</thead>

												<tbody>

<?php

$count=0;

$payment_qury=mysqli_query($conn,"SELECT * FROM lmspayment WHERE paymentMethod='Card' and status='1' ORDER BY created_at DESC");

while($payment_resalt=mysqli_fetch_array($payment_qury)){

$count++;

	

$user_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid='$payment_resalt[userID]'");

$user_resalt=mysqli_fetch_array($user_qury);

?>

<tr>

<td><?php echo number_format($count,0); ?></td>

<td align="center">	

<?php if($payment_resalt['status']==0){ ?>

<a href="online_payments.php?pid=<?php echo $payment_resalt['pid']; ?>&status=1" class="btn btn-success btn-sm" title="Approval Payment" onClick="JavaScript:return confirm('Are your sure change this payment status?');"><i class="fa fa-thck"></i> Approve</a>

<?php } ?>

<?php if($payment_resalt['status']==1){ ?>

<a href="online_payments.php?pid=<?php echo $payment_resalt['pid']; ?>&status=0" class="btn btn-primary btn-sm" title="Unapproval Payment" onClick="JavaScript:return confirm('Are your sure change this payment status?');"><i class="fa fa-times-circle"></i> Reject</a>

<?php } ?>

<a href="online_payments.php?pid=<?php echo $payment_resalt['pid']; ?>&status=3" class="btn btn-info btn-sm" title="Archive Record" onClick="JavaScript:return confirm('Are your sure change this payment status?');"><i class="fa fa-archive"></i> Archive</a>

<a class="btn btn-sm btn-danger" href="delete_online_payments.php?pid=<?php echo $payment_resalt['pid']; ?>" onClick="return confirm('Are youe sure remove this payment');"><i class="la la-trash-o"></i></a>
</td>

<td>

<?php if($payment_resalt['status']==0){ ?>

<span style="padding: 5px; font-size: 10px; background-color: darkred; color: #FFFFFF; border-radius: 25px;">Not Approval</span>

<?php } ?>

<?php if($payment_resalt['status']==1){ ?>

<span style="padding: 5px; font-size: 10px; background-color: darkgreen; color: #FFFFFF; border-radius: 25px;">Approval</span>

<?php } ?>	

</td>
<td><?php echo $user_resalt['fullname']; ?><br><?php echo "0".(int)$user_resalt['contactnumber']; ?></td>
<td><?php
$sub_qury=mysqli_query($conn,"SELECT * FROM lmssubject WHERE sid='$payment_resalt[pay_sub_id]'");
while($sub_resalt=mysqli_fetch_array($sub_qury)){
?> <?php echo $sub_resalt['name']; ?>

- 

<?php
$cl_qury=mysqli_query($conn,"SELECT * FROM lmsclass WHERE cid='$sub_resalt[class_id]'");
while($cl_resalt=mysqli_fetch_array($cl_qury)){
?> <?php echo $cl_resalt['name']; ?> <?php }} ?>  
</td>
<td>

<?php echo number_format($payment_resalt['amount'],2); ?>

</td>

<td><span class="badge badge-success" style="font-size:14px;color:#ffffff;">Valid Date : <i class="fa fa-check-circle"></i> <?php echo date_format(date_create($payment_resalt['expiredate']),"M d, Y"); ?> - Paid Month : <i class="fa fa-check-circle"></i> <?php echo date_format(date_create($payment_resalt['pay_month']),"F"); ?></span></td>
<td><?php echo date_format(date_create($payment_resalt['created_at']),"M d, Y - h:i:s A"); ?></td>
</tr>

<?php

}

?>

												</tbody>

											</table>

										</div>

									</div>

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

    

</body>

</html>
<?php

session_start();

require_once 'includes.php';

include 'dbconfig4.php';

require_once("conn.php");

if(isset($_POST['pay_bt'])){

    date_default_timezone_set("Asia/Colombo");

    $expiredate=mysqli_real_escape_string($conn,$_POST['expiredate']);

    $userID=mysqli_real_escape_string($conn,$_POST['userID']);

    $amount=mysqli_real_escape_string($conn,$_POST['amount']);

    $current_time   = date("Y-m-d H:i:s");
    $feeID          = $_POST['feeID'][0];    
    $pay_month      = $_POST['expiredate']."-01";

    foreach ($_POST['pay_sub_id'] as $value) {

        $pay_sub_id = $value;

        //------------------------------

        $subject_qury=mysqli_query($conn,"SELECT fees_valid_period FROM lmssubject WHERE sid='$pay_sub_id' ");

        $subject_resalt=mysqli_fetch_array($subject_qury);

        $subject_valid_days = $subject_resalt['fees_valid_period'];

        $paying_month = $_POST['expiredate'];

        if ( date("Y-m",strtotime($paying_month)) < date("Y-m") ){
            echo "Invalid month selected";
            exit;
        }else{

            if ( $subject_valid_days == 1 ){

                if ( date("Y-m-d") <= date("Y-m-t", strtotime(date($paying_month))) ){

                    //$fina_date = $this->db->query("SELECT DATE_ADD('".date('Y-m-d')."',INTERVAL + ".$subject_valid_days." DAY) as dd ")->row()->dd;

                    $Q=mysqli_query($conn,"SELECT DATE_ADD('".date('Y-m-d')."',INTERVAL + ".$subject_valid_days." DAY) as dd ");
                    $R=mysqli_fetch_array($Q);
                    $fina_date = $R['dd'];

                }

            }else if($subject_valid_days == 30){

                if ( date("Y-m-d") <= date("Y-m-t", strtotime(date($paying_month))) ) {

                    $fina_date = date("Y-m-t", strtotime(date($paying_month)));

                }else{
                    
                    //$fina_date = $this->db->query("SELECT DATE_ADD('".date('Y-m-d')."',INTERVAL + ".$subject_valid_days." DAY) as dd ")->row()->dd;
                    $Q=mysqli_query($conn,"SELECT DATE_ADD('".date('Y-m-d')."',INTERVAL + ".$subject_valid_days." DAY) as dd ");
                    $R=mysqli_fetch_array($Q);
                    $fina_date = $R['dd'];

                }

            }else if($subject_valid_days == 40){

                if ( date("Y-m-d") <= date("Y-m-t", strtotime(date($paying_month))) ){

                    //$fina_date = $this->db->query("SELECT DATE_ADD('".date("Y-m-t", strtotime(date($paying_month)))."',INTERVAL + ".($subject_valid_days-30)." DAY) as dd ")->row()->dd;
                    $Q=mysqli_query($conn,"SELECT DATE_ADD('".date("Y-m-t", strtotime(date($paying_month)))."',INTERVAL + ".($subject_valid_days-30)." DAY) as dd ");
                    $R=mysqli_fetch_array($Q);
                    $fina_date = $R['dd'];

                }

            }else if($subject_valid_days == 45){

                if ( date("Y-m-d") <= date("Y-m-t", strtotime(date($paying_month))) ){

                    //$fina_date = $this->db->query("SELECT DATE_ADD('".date("Y-m-t", strtotime(date($paying_month)))."',INTERVAL + ".($subject_valid_days-30)." DAY) as dd ")->row()->dd;
                    $Q=mysqli_query($conn,"SELECT DATE_ADD('".date("Y-m-t", strtotime(date($paying_month)))."',INTERVAL + ".($subject_valid_days-30)." DAY) as dd ");
                    $R=mysqli_fetch_array($Q);
                    $fina_date = $R['dd'];

					//echo $paying_month."=".$fina_date; exit;

                }

            }

           $exp_date = $fina_date;
        
        }

        //-----------------------

        $sql = "INSERT INTO

        lmspayment (userID, feeID, pay_sub_id, amount, bank, paymentMethod, created_at, expiredate, status, pay_month)

        VALUES ('$userID','$feeID','$pay_sub_id','$amount','Pay bank','Manual','$current_time','$exp_date','1','$pay_month')";

        if (mysqli_query($conn, $sql)){

			$successMSG = "Manual Payment added successfull.";

			header("refresh:2;manual_payments.php"); // redirects image view page after 5 seconds.
			

        }else{
				$errMSG = "error while inserting....'.$sql.'";
			}

    }

}

if(isset($_GET['remove'])){

    $pid=mysqli_real_escape_string($conn,$_GET['remove']);

    if(mysqli_query($conn,"DELETE FROM lmspayment WHERE pid='$pid'")){

    echo "<script>window.location='manual_payments.php';</script>";

    }

}

?>



<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>Manual Payments | Online Learning Platforms | Dashboard</title>

	

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



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

                            <h4>All Manual Payments</h4>

                        </div>

                    </div>

                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>

                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Manual Payments</a></li>

                            <li class="breadcrumb-item active"><a href="javascript:void(0);">All Manual Payments</a></li>

                        </ol>

                    </div>

                </div>

                

                <div class="row">

                    <div class="col-lg-12">

                        <ul class="nav nav-pills mb-3">

                            <li class="nav-item">

                            <form method="post" class="m-3" autocomplete="off">

<strong>Create New Payment</strong>
<hr>

<table>

<tbody>

<div class="form-group">

<select type="text" name="userID" id="userID" required class="form-control" placeholder="Select Student" list="stu_list" onChange="JavaScrip:dis_load(this.value);" onBlur="JavaScrip:dis_load();">

<?php

$select_stu=mysqli_query($conn,"SELECT * FROM lmsregister ORDER BY fullname");

while($stu_resalt=mysqli_fetch_array($select_stu)){

?>

<option value="<?php echo $stu_resalt['reid']; ?>"><?php echo $stu_resalt['fullname']; ?> - <?php echo "0".(int)$stu_resalt['contactnumber']; ?></option>   

<?php

}

?>






</select>

</div>

    <div class="form-group">

<select name="feeID[]" id="feeID" class="form-control" multiple="multiple">

    <?php

$tec_qury=mysqli_query($conn,"SELECT tid,fullname,contactnumber FROM lmstealmsr ORDER BY fullname");

while($tec_resalt=mysqli_fetch_array($tec_qury)){

?>

<option value="<?php echo $tec_resalt['tid']; ?>"><?php echo $tec_resalt['fullname']; ?> - <?php echo "0".(int)$tec_resalt['contactnumber']; ?></option>    

<?php

}

?>

</select>

</div>

    <div class="form-group">

    <select name="pay_sub_id[]" id="pay_sub_id" class="form-control" multiple="multiple">

<?php

$sub_qury=mysqli_query($conn,"SELECT s.sid,c.cid,c.name cname,s.name sname
FROM lmssubject s INNER JOIN lmsclass c ON s.class_id=c.cid
WHERE s.status='Publish'
ORDER BY c.name");
while($sub_resalt=mysqli_fetch_array($sub_qury)){

?>

<option value="<?php echo $sub_resalt['sid']; ?>"><?php echo $sub_resalt['cname']; ?> - <?php echo $sub_resalt['sname']; ?></option>    

<?php
}
?>

</select>

</div>



<tr>

<tr><td colspan="3">&nbsp;</td></tr>

<td><input type="tel" name="amount" pattern="[0-9]+([\.][0-9]{0,2})?" required class="form-control" placeholder="Pay amount" onKethp="JavaScrip:dis_load(this.value);" onBlur="JavaScrip:dis_load();"></td>

<td>

<input name="expiredate" type="month" class="form-control" id="expiredate" value="<?php echo date("Y-m"); ?>">  

</td>

<td><button name="pay_bt" type="submit" class="btn btn-info ml-2">Add Payment</button></td>

</tr>

</tbody>

</table>

<datalist id="stu_list">



</datalist>

   

</form>

<script>

function dis_load() {

    var userID=document.getElementById('userID').value;

  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {

    if (this.readyState == 4 && this.status == 200) {

     document.getElementById("details_dis").innerHTML = this.responseText;

    }

  };

  xhttp.open("GET", "ajax_details_dis.php?userID="+userID, true);

  xhttp.send();

}

</script>

                  

<div id="details_dis" class="m-3"></div>

                            </li>

                        </ul>

                    </div>

                    <div class="col-lg-12">

                        <div class="row tab-content">

                            <div id="list-view" class="tab-pane fade active show col-lg-12">

                                <div class="card">

                                    <div class="card-header">

                                        <h4 class="card-title">All Manual Payments</h4>

                                    </div>

                                    <div class="card-body">
									
									<?php

							if(isset($errMSG)){

							?>
			
							<div class="alert alert-danger alert-dismissible alert-alt solid fade show">
							<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
							<strong>Error!</strong> <?php echo $errMSG; ?>
							</div>

							<?php

							}
	
							else if(isset($successMSG)){

							?>
			
							<div class="alert alert-success alert-dismissible alert-alt solid fade show">
							<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
							<strong>Success!</strong> <?php echo $successMSG; ?>.
							</div>

							<?php

							}

							?>

                                        <div class="table-responsive">

                                            <table id="example3" class="table table-bordered">

                                                <thead>

                                                    <tr>

<th>#</th>

<th>Action</th>

<th>Status</th>

<th>Classes</th>

<th>Class Fee</th>

<th>Valid Date - Paid Month</th>

<th>Pay Date</th>


                                                    </tr>

                                                </thead>

                                                <tbody>

<?php

$count=0;

$payment_qury=mysqli_query($conn,"SELECT yp.pid,yp.status,yr.fullname,yp.amount,yp.created_at,yp.expiredate,yp.pay_month,yt.fullname ytfullname,ys.name

FROM lmspayment yp LEFT JOIN lmsregister yr ON yp.userID=yr.reid

INNER JOIN lmstealmsr yt ON yp.feeID=yt.tid

INNER JOIN lmssubject ys ON yp.pay_sub_id=ys.sid

WHERE yp.paymentMethod='Manual'

ORDER BY yp.pid DESC");

while($payment_resalt=mysqli_fetch_array($payment_qury)){

$count++;

?>

<tr>

<td><?php echo number_format($count,0); ?></td>

<td align="center"> 

<a href="manual_payments.php?remove=<?php echo $payment_resalt['pid']; ?>" class="btn btn-sm btn-danger" title="Remove Payment" onClick="JavaScript:return confirm('Are your sure remove this payment?');"><i class="fa fa-trash"></i></a>

</td>



<td>

<?php if($payment_resalt['status']==0){ ?>

<span style="padding: 5px; font-size: 10px; background-color: darkred; color: #FFFFFF; border-radius: 25px;">Not Approval</span>

<?php } ?>

<?php if($payment_resalt['status']==1){ ?>

<span style="padding: 5px; font-size: 10px; background-color: darkgreen; color: #FFFFFF; border-radius: 25px;">Approval</span>

<?php } ?>  

</td>

<td><?php echo $payment_resalt['fullname']; ?><br><?php echo $payment_resalt['ytfullname']; ?><br><?php echo $payment_resalt['name']; ?></td>

<td>

<span style="font-size: 12px; background-color: dodgerblue; padding: 5px; color: #FFFFFF; border-radius: 10px; white-space: nowrap">Pay <?php echo number_format((float)$payment_resalt['amount'],2); ?></span>

</td>
<td><a href="#"><span class="badge badge-success" style="font-size:14px;">Valid Date : <i class="fa fa-check-circle"></i> <?php echo date_format(date_create($payment_resalt['expiredate']),"M d, Y"); ?> - Paid Month : <i class="fa fa-check-circle"></i> <?php echo date_format(date_create($payment_resalt['pay_month']),"F"); ?></span></a></td>
<td><?php echo date_format(date_create($payment_resalt['created_at']),"M d, Y | h:i:s A"); ?></td>	
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

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">



// In your Javascript (external .js resource or <script> tag)

$(document).ready(function() {

    $('#feeID').select2({

    placeholder: "Select Teacher",

    allowClear: true

});

    $('#pay_sub_id').select2({

    placeholder: "Select Subject",

    allowClear: true

});

    $('#userID').select2({

    placeholder: "Select Student",

    allowClear: true

});


});



    </script>

    



</body>

</html>
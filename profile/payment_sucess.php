<?php  


include '../dashboard/conn.php';
$a=time()+60*60*24*30;

$exp_date=date("Y-m-d",$a);

require_once '../dashboard/dbconfig4.php';



  session_start();
  $reid = $_SESSION['reid1'];
  $select_payment0 = $_SESSION['select_payment0'];
  $select_payment1 = $_SESSION['select_payment1'];
  $select_payment2 = $_SESSION['select_payment2'];
  $order_key = $_SESSION['order_key'];
  $created_at = $_SESSION['created_at'];
  $exp_date = $_SESSION['exp_date'];
  $paying_months = $_SESSION['pay_month'];
  $pay_list_data = $_SESSION['pay_list_data'];
  $_SESSION['success'] = $success_payment;


    



	foreach($pay_list_data as $select_payment){

		

		$select_payment=explode(",",$select_payment); //teacher id,subject id, amount
        
		$subject_qury=mysqli_query($conn,"SELECT fees_valid_period FROM lmssubject WHERE sid='$select_payment[1]'");
        
		$subject_resalt=mysqli_fetch_array($subject_qury);
        
        
		if ($subject_resalt['fees_valid_period'] == "EOM"){

			$exp_date = date("Y-m-t", strtotime(date("Y-m-d")));

		}else if($subject_resalt['fees_valid_period'] == "150D"){

			$exp_date = date('Y-m-d',strtotime('+150 day'));

		}else{

			$exp_date = date('Y-m-d',strtotime('+1 month'));

		}

		$year = explode('-', $paying_months)[0];
		$month = explode('-', $paying_months)[1];
		$this_month = date('m',strtotime('now'));
		$exp_date = date("Y-m-t", strtotime($paying_months));
		
		//------------------------------

		$subject_valid_days = $subject_resalt['fees_valid_period'];

        $paying_month = $paying_months;
        
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

                }

            }else if($subject_valid_days == 90){

                if ( date("Y-m-d") <= date("Y-m-t", strtotime(date($paying_month))) ){

                    //$fina_date = $this->db->query("SELECT DATE_ADD('".date("Y-m-t", strtotime(date($paying_month)))."',INTERVAL + ".($subject_valid_days-30)." DAY) as dd ")->row()->dd;
                    $Q=mysqli_query($conn,"SELECT DATE_ADD('".date("Y-m-t", strtotime(date($paying_month)))."',INTERVAL + ".($subject_valid_days-30)." DAY) as dd ");
					$R=mysqli_fetch_array($Q);
					$fina_date = $R['dd'];


                }

            }

           $exp_date = $fina_date;
        
        }

        //-----------------------


		if(!isset($error)){

			$sql = "INSERT INTO lmspayment (`fileName`, `userID`, `feeID`, `pay_sub_id`, `amount`, `accountnumber`, `bank`, `branch`, `paymentMethod`, `created_at`, `expiredate`, `session_id`, `status`, `order_status`,`pay_month`)

				VALUES ('', '$_SESSION[reid]', '$select_payment[0]', '$select_payment[1]', '$select_payment[2]', '0', 'Pay Online', 'Online Class', 'Card', '$created_at', '$exp_date', '0', '1', '1' , '".$paying_month."-01"."')";

				//echo $sql;exit;

				mysqli_query($conn, $sql);

		}else{

       		header("location:student_profile.php?error='".$error);
       		die();

		}

	}

	echo "<script>window.location='student_profile.php?success';</script>";


             
              unset($_SESSION["reid1"]);
              unset($_SESSION['reid1']);
              unset($_SESSION['select_payment0']);
              unset($_SESSION['select_payment1']);
              unset($_SESSION['select_payment2']);
              unset($_SESSION['order_key']);
              unset($_SESSION['created_at']); 
              unset($_SESSION['exp_date']);
              unset($_SESSION['pay_month']);
              unset($_SESSION['pay_list_data']);
?>
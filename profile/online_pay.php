<?php 

session_start();

include '../dashboard/conn.php';

date_default_timezone_set("Asia/Colombo");

$created_at=date("Y-m-d H:i:s");

       function create_order_key($length = 15)
       {
       $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
       $charactersLength = strlen($characters);
       $randomString = '';
       for ($i = 0; $i < $length; $i++) {
              $randomString .= $characters[rand(0, $charactersLength - 1)];
       }
       return $randomString;
       }
$pay_list;
if (isset($_GET['select_payment'])) {
$pay_list = $_GET['select_payment']; 
$user_query=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid='$_SESSION[reid]'");

$user=mysqli_fetch_array($user_query);


       $order_key = create_order_key(15);
       $total_fee = 0;

       foreach($_GET['select_payment'] as $select_payment){

              //echo $select_payment;

              $select_payment=explode(",",$select_payment); //teacher id,subject id, amount
              
              /*function selected_data() {
                  code to be executed;
                } */
              
              $sql = "SELECT fees_valid_period, price FROM lmssubject WHERE sid='$select_payment[1]'";

              
              $subject_qury=mysqli_query($conn,$sql);

              $subject_resalt=mysqli_fetch_array($subject_qury);

              $subject_fee = $subject_resalt['price'];

              $total_fee += $subject_fee;

              if ($subject_resalt['fees_valid_period'] == "EOM"){

                     $exp_date = date("Y-m-t", strtotime(date("Y-m-d")));

              }else if($subject_resalt['fees_valid_period'] == "150D"){

                     $exp_date = date('Y-m-d',strtotime('+150 day'));

              }else{

                     $exp_date = date('Y-m-d',strtotime('+1 month'));

              }
			  
              $year = explode('-', $_GET['month'])[0];
              $month = explode('-', $_GET['month'])[1];
              $this_month = date('m',strtotime('now'));

              $exp_date = date("Y-m-t", strtotime($_GET['month']));

//------------------------------

		$subject_valid_days = $subject_resalt['fees_valid_period'];

        $paying_month = $_GET['month'];
        
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
        $sql = "SELECT * FROM lmspayment WHERE pay_month ='". $paying_month . "-01' AND userID=". $_SESSION['reid'] . " AND pay_sub_id = '". $select_payment[1] . "'";

		$query = mysqli_query($conn, $sql);

		if (mysqli_fetch_array($query)) {

			$R=mysqli_fetch_array($query);

			if ($R['status'] == 1){
				$error = "ඔබ දැනටමත් මෙම මාසය සදහා පන්ති ගාස්තු ගෙවා ඇත!!";
			}else{
				$error = "අපගේ පද්ධතියේ දත්ත අනුව ඔබ දැනටමත් මෙම මාසය සදහා පන්ති ගාස්තු ගෙවා ඇත. එය තහවුරු කල සැනින් ඔබට දැනුම් දෙනු ඇත";
			}

		}
             


if(!isset($error)){
    
                    $firstname = $application_name;
                    $lastname ='Institue' ;
                    $email = 'info@Guruniwasainstitute.lk';
                    $contact = '+94772879970';
                    $app_id = $app_id;
                    $hash_salt = $hash_salt;
                    $app_token = $a_token;
                        
                        $onepay_args = array(
                          
                          "amount" => floatval($total_fee),
                          "app_id"=> $app_id,
                          "reference" => "{$order_key}",
                          "customer_first_name" => $firstname,
                          "customer_last_name"=> $lastname,
                          "customer_phone_number" => $contact,
                          "customer_email" => $email,
                          "transaction_redirect_url" => "$url/profile/payment_sucess.php",
                        
                        );
                        
                        $data=json_encode($onepay_args,JSON_UNESCAPED_SLASHES);
                        
                        $data_json = $data."".$hash_salt;
                        
                        $hash_result = hash('sha256',$data_json);
                        
                        $curl = curl_init();
                        
                        $url = 'https://merchant-api-live-v2.onepay.lk/api/ipg/gateway/request-transaction/?hash=';
                        $url .= $hash_result;
                        
                        curl_setopt_array($curl, array(
                          CURLOPT_URL => $url,
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_ENCODING => '',
                          CURLOPT_MAXREDIRS => 10,
                          CURLOPT_TIMEOUT => 0,
                          CURLOPT_FOLLOWLOCATION => true,
                          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                          CURLOPT_CUSTOMREQUEST => 'GET',
                          CURLOPT_POSTFIELDS => $data,
                          CURLOPT_HTTPHEADER => array(
                            'Authorization:'."".$app_token,
                            'Content-Type:application/json'
                          ),
                        ));
                        
                        $response = curl_exec($curl);
                        
                        curl_close($curl);
                        
                        $result = json_decode($response, true);
                         
                        if (isset($result['data']['gateway']['redirect_url'])) {
                            $myfile = fopen("payment_logs.txt", "a") or die("Unable to open file!");
                            $txt = $result['data']["ipg_transaction_id"]."|".date("Y-m-d h:i:sa")."|".$_SESSION['reid'];
                            fwrite($myfile, "\n". $txt);
                            fclose($myfile); 
                          $re_url = $result['data']['gateway']['redirect_url'];
                          header('Location: ' . $re_url, true, $permanent ? 301 : 302);
                         session_start();
                         $_SESSION['reid1'] = $_SESSION[reid];
                         $_SESSION['select_payment0'] = $select_payment[0];
                         $_SESSION['select_payment1'] = $select_payment[1];
                         $_SESSION['select_payment2'] = $select_payment[2];
                         $_SESSION['order_key'] = $order_key;
                         $_SESSION['created_at'] = $created_at;
                         $_SESSION['exp_date'] = $exp_date;
                         $_SESSION['pay_month'] = $paying_month;
                         //selected_data();
                        
                        }

}

else{

                        $error = "ඔබ දැනටමත් මෙම මාසය සදහා පන්ති ගාස්තු ගෙවා ඇත!!";
                        header("location:student_profile.php?error=".$error);
                        die();
                       
                       
                        
                      
      
}
}
                      session_start(); 
                      $_SESSION['pay_list_data'] = $pay_list;


}


die();
?>

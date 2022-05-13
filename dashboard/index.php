<?php
include 'conn.php';
session_start();

if(isset($_SESSION['admin']))
{		
	header('location:home.php');
	die();
}

	if(isset($_POST['log'])){

		include 'dbconfig4.php';

		$username = $_POST['username'];
		$password =  $_POST['pass'];

		$sql = "SELECT * FROM lmsusers where user_name = :user";
		$query = $DB_con->prepare($sql);
		$query->bindParam('user', $username);
		$query->execute();

		if($query->rowCount() == 1){

			$row = $query->fetch();
			
			$password_halms = $row['user_pass'];
			if (password_verify($password, $password_halms)) {
				$content = array('user_id', 'user_name', 'admintype', 'admin', 'students','teachers' ,'class','subject','lesson','payments','class_schedule','mail');

				foreach ($content as $x) {
					$_SESSION[$x] = $row[$x];
				}

				//var_dump($_SESSION);
				header('location:home.php');
				die();
			}else{
				//password wrong
				$error = 'Username or password is wrong!';
			}

		}else{
			//username wrong
			$error = 'Username or password is wrong!';
		}
	}

?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login | Online Learning Platforms | Dashboard</title>
	
    <?php
	//require_once './favicon.php';
	?>
	
	<?php
	require_once 'headercss.php';
	?>

</head>

    


<body class="h-100">
    <div class="authincation h-100 dash-up">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<p><center><img src="settings/logo/<?php echo $main_logo; ?>"></center></p>
                                    <h4 class="text-center mb-4" style="font-weight:bold;color:#000000;">Login in Admin Panel</h4>
									<hr>
									<h1 style="background-color: #ff0000; color: #000000; width: 100%; font-size: 18px; text-align: center;"><?php if(isset($error)){echo $error; }?></h1>
                                    <form action="index.php" method="POST" >
                                        <div class="form-group">
                                            <label style="font-weight:bold;color:#000000;"><strong>Username</strong></label>
                                            <input type="text" name="username" id="exampleInputUsername" class="form-control" placeholder="Enter Username">
                                        </div>
                                        <div class="form-group">
                                            <label style="font-weight:bold;color:#000000;"><strong>Password</strong></label>
                                            <input type="password" name="pass" id="exampleInputPassword" class="form-control" placeholder="Enter Password">
                                        </div>
                                        <div class="text-center">
											<input type="submit" class="btn btn-primary btn-block" name="log" value="Login">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


   <?php
	require_once 'footerjs.php';
	?>

</body>

</html>
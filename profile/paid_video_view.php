<?php
session_start();
require_once '../dashboard/dbconfig4.php';
require_once("../dashboard/config.php"); 
include '../dashboard/conn.php';
if (!isset($_SESSION['reid'])) {    
    header('location:../login.php');    
    die();
    
}
$user_qury=mysqli_query($conn,"SELECT * FROM lmsregister INNER JOIN lmsclass ON lmsregister.level=lmsclass.cid WHERE reid='$_SESSION[reid]'");
$user_resalt=mysqli_fetch_array($user_qury);

$image_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid='$_SESSION[reid]'");
$image_resalt=mysqli_fetch_array($image_qury);

if($image_resalt['image']==""){
	$dis_image_path="images/hd_dp.jpg";
}
else{
	$dis_image_path="uploadImg/".$image_resalt['image'];
}
?>

<!DOCTYPE html>
<html lang="en">

	<head>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, shrink-to-fit=9">
	<meta name="description" content="https://siyosip.lk/lms/">
	<meta name="author" content="https://siyosip.lk/lms/">
	<title>Paid Video Lesson View | Online Learning Platforms | Student Panel</title>
	<?php
	require_once 'headercss.php';
	?>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<script type="text/jscript">
  function disableContextMenu()
  {
    window.frames["video"].document.oncontextmenu = function(){alert("No way!"); return false;};
    // Or use this
    // document.getElementById("video").contentWindow.document.oncontextmenu = function(){alert("No way!"); return false;};;
  }
</script>
	<script  src="https://cdn.jsdelivr.net/gh/thelevicole/youtube-to-html5-loader@4.0.1/dist/YouTubeToHtml5.js"></script>
	<style type="text/css">

.button {
  width: 48px;
  height: 48px;
  cursor: pointer;
  &:hover {
    fill: white;
  }
}

.defs {
  position: absolute;
  top: -9999px;
  left: -9999px;
}

.buttons {
  padding: 1rem;
  background: #f06d06;
  float: left;
}
	</style>
	</head>

<body>
	<?php
	require_once 'header.php';
	?>

	<?php
	require_once 'sidebarmenu.php';
	?>
	<!-- Body Start -->
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
				<div class="col-lg-12">
				<h4 class="item_title">Watch Your Video Lesson</h4>
				<a href="paid_lesson.php" class="see150">See all</a>
				</div>
					<div class="col-xl-12 col-lg-12">
						<div class="section3125">
<?php
if (isset($_GET['video']))
{
								$stmt = $DB_con->prepare("SELECT * FROM lmslesson where lid='" . $_GET['video'] . "' and type='Paid' and status='1' order by lid ASC");

								$stmt->execute();

								if($stmt->rowCount() > 0)

								{

								while($row=$stmt->fetch(PDO::FETCH_ASSOC))

								{

								extract($row);

								?>
							<div class="live1452">
							    <div style="padding:56.25% 0 0 0;position:relative;">
                                <iframe src=<?php echo $row['video']; ?>>
                                </iframe>
                                </div>
                                <script src="https://player.vimeo.com/api/player.js"></script>
							

							   
							
							</div>
							<div class="user_dt5">
								<div class="user_dt_left">
									<div class="live_user_dt">
										<div class="user_img5">
										<img src="images/hd_dp.jpg" class="pro_pick">
										</div>
										<div class="user_cntnt">
											<h4><?php

						$id = $row['tid']; 

						$query = $DB_con->prepare('SELECT fullname FROM lmstealmsr WHERE tid='.$id);

						$query->execute();

						$result = $query->fetch();

						echo $result['fullname'];

						?></h4>
											<button class="subscribe-btn"><?php

						$id = $row['tid']; 

						$query = $DB_con->prepare('SELECT subdetails FROM lmstealmsr WHERE tid='.$id);

						$query->execute();

						$result = $query->fetch();

						echo $result['subdetails'];

						?></button>
										</div>
									</div>
								</div>
							</div>
<?php
}
}
}
?>
						</div>							
					</div>				
				</div>
			</div>
		</div>
		
	<?php
	require_once 'footer.php';
	?>
	</div>
	<!-- Body End -->
	<?php
	require_once 'footerjs.php';
	?>

<!-- Demo ads. Please ignore and remove. -->
<script src="http://cdn.tutorialzine.com/misc/enhance/v3.js" async></script>
<script src="js/script.js"></script>	
<script type="text/jscript">
  function disableContextMenu()
  {
    window.frames["video"].document.oncontextmenu = function(){alert("No way!"); return false;};   
    // Or use this
    // document.getElementById("fraDisabled").contentWindow.document.oncontextmenu = function(){alert("No way!"); return false;};;    
  }  
</script>
<script type="text/javascript">
// https://developers.google.com/youtube/iframe_api_reference

// global variable for the player
var player;

// this function gets called when API is ready to use
function onYouTubePlayerAPIReady() {
  // create the global player from the specific iframe (#video)
  player = new YT.Player("video", {
    events: {
      // call this function when player is ready to use
      onReady: onPlayerReady
    }
  });
}

function onPlayerReady(event) {
  // bind events
  var playButton = document.getElementById("play-button");
  playButton.addEventListener("click", function () {
    player.playVideo();
  });

  var pauseButton = document.getElementById("pause-button");
  pauseButton.addEventListener("click", function () {
    player.pauseVideo();
  });
}

// Inject YouTube API script
var tag = document.createElement("script");
tag.src = "//www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName("script")[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
new YouTubeToHtml5();
</script>

	
</body>
</html>
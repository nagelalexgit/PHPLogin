<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}

require_once 'config.php';
$date = date('Y/m/d H:i');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>DAY WARD DEPARTMENT</title>
  <script type="text/javascript" src="js/script.js"></script>
  <script  src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <link rel="stylesheet" href="css/css.css">
  <style type="text/css">
      body{ height:100%;font-family: "Verdana", Times, serif; text-align: center;background-color:rgba(175, 184, 157, 0.57);}
      html{height:95%}
  </style>
</head>
<body onLoad="clearTimeOut()" onUnload="clearTimeOut()">
  <div class="page-header">
      <h3>DAY WARD DEPARTMENT.</h3>
      <h4 id="demo">_</h4>
  </div>
  <div class="main">
    <div class="button-container">
      <a id=bay1 href="#/Action1" class="button" onclick="alarmFunction(this.id);">Bay 1 <br> Ready</a>
      <a id=bay2 href="#/Action2" class="button" onclick="pendingFunction(this.id);">Bay 2 <br> Ready</a>
      <a id=bay3 href="#/Action3" class="button" onclick="assignFunction(this.id);">Bay 3 <br> Ready</a>
      <a id=bay4 href="#/Action4" class="button" onclick="acceptedFunction(this.id);">Bay 4 <br> Ready</a>
      <a id=bay5 href="#/Action5" class="button" onclick="getBayStatus();">Bay 5 <br> Ready</a>
      <a id=bay6 href="#/Action6" class="button">Bay 6 <br> Ready</a>
      <a id=bay7 href="#/Action4" class="button">Bay 7 <br> Ready</a>
      <a id=bay8 href="#/Action5" class="button">Bay 8 <br> Ready</a>
    </div>
  </div>
  <section class="about">
    <div>
      <p>
        You are currently loged in as <b><?php echo htmlspecialchars($_SESSION['username']); ?> </b> at <b><?php echo $date ?></b>. Only features for your deparment are enabled.
      </p>
    </div>
  </section>
  <p><a href="logout.php" class="btn btn-danger">Sign Out</a></p>
</body>
</html>

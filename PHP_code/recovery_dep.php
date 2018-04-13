<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}
// Include config file
require_once 'config.php';

// Define variables and initialize with empty values
$pname = $ptype = $bayno = "";
$pname_err = $ptype_err = $bayno_err = "";
$patient_status = "Not yet available";
$var = microtime(true);

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["pname"]))){
        $pname_err= "Please enter a patient name.";
    }
    elseif (empty(trim($_POST["ptype"]))){
      $ptype_err = "Please enter a patient type.";
    }
    elseif (empty(trim($_POST["bayno"]))){
      $bayno_err = "Please enter a Bay No.";
    } else{
        // Prepare a select statement
        $sql = "SELECT * FROM bayregister WHERE pname = ? AND ptype = ? AND bayno = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssi", $param_pname,$param_ptype,$param_bayno);

            // Set parameters
            $param_pname = trim($_POST["pname"]);
            $param_ptype = trim($_POST["ptype"]);
            $param_bayno = (int)trim($_POST["bayno"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $patient_status = "This patient is already assigned.";
                } else{
                    $pname = trim($_POST["pname"]);
                    $ptype = trim($_POST["ptype"]);
                    $bayno = trim($_POST["bayno"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        //$stmt->close();
    }
    // Check input errors before inserting in database
    if(empty($pname_err) && empty($ptype_err) && empty($bayno_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO bayregister(pname, ptype, bayno) VALUES (?, ?, ?)";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssi", $param_pname, $param_ptype, $param_bayno);

            // Set parameters
            $param_pname = trim($_POST["pname"]);
            $param_ptype = trim($_POST["ptype"]);
            $param_bayno = (int)trim($_POST["bayno"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                $patient_status = "Patient assigned successful";
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        $stmt->close();
    }
    // Close connection
    $mysqli->close();
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RECOVERY WARD DEPARTMENT</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ height:100%;font: 14px sans-serif; text-align: center;background-color:rgb(206, 206, 206);}
        html{height:100%}
.intro{
  height:75%
}
.left{
  display : flex;
  justify-content : center;
  align-items : center;
  border-right-style: dotted;
  border-right-color: rgba(65, 66, 66, 0.20);
  border-bottom-style: solid;
  border-bottom-color: rgba(65, 66, 66, 0.10);
  font: 11px sans-serif;
  background-color:rgba(4, 24, 36, 0.001);
  height : 100%;
  color : #3d231b;

}
.right{
  display : flex;
  justify-content : center;
  align-items : center;
  background-color:rgba(4, 24, 36, 0.001);
  border-bottom-style: solid;
  border-bottom-color: rgba(65, 66, 66, 0.10);
  height : 100%;
  color : #3d23;
}
/* visited link */
a:visited {
    color: #ede7e3;
}

/* mouse over link */
a:hover {
    color: rgba(2, 12, 3, 0.78);
}

/* selected link */
a:active {
    color: #ede7e3;
}
.button-container {
    width: auto;
    overflow-y: auto;
}

.button-container > a {
    float: left;
    text-decoration: none;
    border-radius: 10px;
    margin: 10px;
}
.button{
    z-index: 1;
    width: 10em;
    height: 10em;
    padding-top: 4em;
    background: rgba(32, 135, 41, 0.60);
    font-weight:  bold;
}
.buttonAssigned{
    z-index: 1;
    width: 10em;
    height: 10em;
    padding-top: 4em;
    background: rgba(59, 150, 216, 0.85);
    font-weight:  bold;
}
.buttonAccepted{
    z-index: 1;
    width: 10em;
    height: 10em;
    padding-top: 4em;
    background: rgba(205, 16, 222, 0.85);
    font-weight:  bold;
}
.buttonAlarm {
  z-index: 1;
  background-color: #FFFFFF;
  -webkit-border-radius: 10px;
  border-radius: 10px;
  border: none;
  color: #FFFFFF;
  width: 10em;
  height: 10em;
  padding-top: 2em;
  font-weight:  bold;
  cursor: pointer;
  display: inline-block;
  text-align: center;
  text-decoration: none;
  -webkit-animation: glowing 1000ms infinite;
  -moz-animation: glowing 1000ms infinite;
  -o-animation: glowing 1000ms infinite;
  animation: glowing 1000ms infinite;
}
@-webkit-keyframes glowing {
  0% { background-color: rgba(208, 22, 5, 0.72); -webkit-box-shadow: 0 0 1px rgba(208, 22, 5, 0.72); }
  50% { background-color: rgba(231, 3, 7, 0.78); -webkit-box-shadow: 0 0 5px rgba(231, 3, 7, 0.78); }
  100% { background-color: rgba(208, 22, 5, 0.72); -webkit-box-shadow: 0 0 1px rgba(208, 22, 5, 0.72); }
}

@-moz-keyframes glowing {
  0% { background-color: rgba(208, 22, 5, 0.72); -moz-box-shadow: 0 0 1px rgba(208, 22, 5, 0.72); }
  50% { background-color: rgba(231, 3, 7, 0.78); -moz-box-shadow: 0 0 5px rgba(231, 3, 7, 0.78); }
  100% { background-color: rgba(208, 22, 5, 0.72); -moz-box-shadow: 0 0 1px rgba(208, 22, 5, 0.72); }
}

@-o-keyframes glowing {
  0% { background-color: rgba(208, 22, 5, 0.72); box-shadow: 0 0 1px rgba(208, 22, 5, 0.72); }
  50% { background-color: rgba(231, 3, 7, 0.78); box-shadow: 0 0 5px rgba(231, 3, 7, 0.78); }
  100% { background-color: rgba(208, 22, 5, 0.72); box-shadow: 0 0 1px rgba(208, 22, 5, 0.72); }
}

@keyframes glowing {
  0% { background-color: rgba(208, 22, 5, 0.72); box-shadow: 0 0 1px rgba(208, 22, 5, 0.72); }
  50% { background-color: rgba(231, 3, 7, 0.78); box-shadow: 0 0 5px rgba(231, 3, 7, 0.78); }
  100% { background-color: rgba(208, 22, 5, 0.72); box-shadow: 0 0 1px rgba(208, 22, 5, 0.72); }
}
.buttonPending {
  z-index: 1;
  background-color: #FFFFFF;
  -webkit-border-radius: 10px;
  border-radius: 10px;
  border: none;
  color: #FFFFFF;
  width: 10em;
  height: 10em;
  padding-top: 4em;
  font-weight:  bold;
  cursor: pointer;
  display: inline-block;
  text-align: center;
  text-decoration: none;
  -webkit-animation: glowing1 1500ms infinite;
  -moz-animation: glowing1 1500ms infinite;
  -o-animation: glowing1 1500ms infinite;
  animation: glowing1 1500ms infinite;
}
@-webkit-keyframes glowing1 {
  0% { background-color: rgba(157, 74, 15, 0.79); -webkit-box-shadow: 0 0 1px rgba(157, 74, 15, 0.79);}
  50% { background-color: rgba(204, 85, 0, 0.85); -webkit-box-shadow: 0 0 5px rgba(204, 85, 0, 0.85); }
  100% { background-color: rgba(229, 95, 0, 0.88); -webkit-box-shadow: 0 0 1px rgba(229, 95, 0, 0.88); }
}

@-moz-keyframes glowing1 {
  0% { background-color: rgba(157, 74, 15, 0.79); -moz-box-shadow: 0 0 1px rgba(157, 74, 15, 0.79); }
  50% { background-color: rgba(204, 85, 0, 0.85); -moz-box-shadow: 0 0 5px rgba(204, 85, 0, 0.85); }
  100% { background-color: rgba(229, 95, 0, 0.88); -moz-box-shadow: 0 0 1px rgba(229, 95, 0, 0.88); }
}

@-o-keyframes glowing1 {
  0% { background-color: rgba(157, 74, 15, 0.79); box-shadow: 0 0 1px rgba(157, 74, 15, 0.79); }
  50% { background-color: rgba(204, 85, 0, 0.85); box-shadow: 0 0 5px rgba(204, 85, 0, 0.85); }
  100% { background-color: rgba(229, 95, 0, 0.88); box-shadow: 0 0 1px rgba(229, 95, 0, 0.88); }
}

@keyframes glowing1 {
  0% { background-color: rgba(157, 74, 15, 0.79); box-shadow: 0 0 1px rgba(157, 74, 15, 0.79); }
  50% { background-color: rgba(204, 85, 0, 0.85); box-shadow: 0 0 5px rgba(204, 85, 0, 0.85); }
  100% { background-color: rgba(229, 95, 0, 0.88); box-shadow: 0 0 1px rgba(229, 95, 0, 0.88); }
}

@media (max-width: 1200px) {
  .left{
    height:50%
  }
  .right{
    height:50%
  }
}
.about{
  display : flex;
  justify-content : center;
  align-items : center;
  background-color:rgb(206, 206, 206);
  color : rgb(66, 155, 2);
  height:5%
}
    </style>
</head>
<body>
  <script type="text/javascript">
  function alarmFunction() {
    element = document.getElementById("bay1Button");
    element.className = element.className.replace(/\bbutton\b/g, "buttonAlarm");
    element.innerHTML = 'Bay 1 <br> Abnormal delay <br> Request has been sent';
  }
  function pendingFunction() {
    element = document.getElementById("bay2Button");
    element.className = element.className.replace(/\bbutton\b/g, "buttonPending");
    element.innerHTML = 'Bay 2 <br> Pending transfer';
  }
  function assignFunction() {
    element = document.getElementById("bay3Button");
    element.className = element.className.replace(/\bbutton\b/g, "buttonAssigned");
    element.innerHTML = 'Bay 3 <br> Patient assigned';
  }
  function acceptedFunction() {
    element = document.getElementById("bay4Button");
    element.className = element.className.replace(/\bbutton\b/g, "buttonAccepted");
    element.innerHTML = 'Bay 3 <br> Transfer accepted';
  }
  </script>

  <div class="page-header">
      <h4>RECOVERY WARD DEPARTMENT.</h4>
  </div>
  <section class="intro">
    <row>
      <div class="col-lg-6 col-sm-12 left">
        <div class="wrapper">
            <h3>Patient assignment board</h3>
            <p>Please fill all fields to assign a patient.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Patient Name</label>
                    <input type="text" name="pname"class="form-control" value="<?php echo $pname; ?>">
                    <span class="help-block"><?php echo $pname_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($ptype_err)) ? 'has-error' : ''; ?>">
                    <label>Patient Type</label>
                    <input type="text" name="ptype"class="form-control" value="<?php echo $ptype; ?>">
                    <span class="help-block"><?php echo $ptype_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($bayno_err)) ? 'has-error' : ''; ?>">
                    <label>Bay No.</label>
                    <input type="text" name="bayno" class="form-control" value="<?php echo $bayno; ?>">
                    <span class="help-block"><?php echo $bayno_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="reset" class="btn btn-default" value="Reset">
                    <input type="submit" class="btn btn-primary" value="Assign">
                </div>
                <div class="form-group <?php echo (!empty($patient_status)) ? 'has-error' : ''; ?>">
                    <label>Patient Status</label>
                    <span class="help-block"><?php echo $patient_status; ?></span>
                </div>
            </form>
        </div>
      </div>
      <div class="col-lg-6 col-sm-12 right">
        <div class="button-container">
          <a id=bay1Button href="#/Action1" class="button" onclick="alarmFunction();">Bay 1 <br> Ready</a>
          <a id=bay2Button href="#/Action2" class="button" onclick="pendingFunction();">Bay 2 <br> Ready</a>
          <a id=bay3Button href="#/Action3" class="button" onclick="assignFunction();">Bay 3 <br> Ready</a>
          <a id=bay4Button href="#/Action4" class="button" onclick="acceptedFunction();">Bay 4 <br> Ready</a>
          <a href="#/Action5" class="button">Bay 5 <br> Ready</a>
          <a href="#/Action6" class="button">Bay 6 <br> Ready</a>
          <a href="#/Action4" class="button">Bay 7 <br> Ready</a>
          <a href="#/Action5" class="button">Bay 8 <br> Ready</a>
        </div>
      </div>
    </row>
  </section>
  <section class="about">
    <div>
      <p>
        You are currently loged in as <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. Only features for your deparment are enabled.
      </p>
    </div>
  </section>
  <p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>
  <?php echo $var ?>


</body>
</html>

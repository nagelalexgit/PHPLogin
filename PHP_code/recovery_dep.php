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
$pname = $ptype = $bayno = $sname = $title = "";
$pname_err = $ptype_err = $bayno_err = $sname_err = $title_err= "";
$patient_status = "Not yet available";
$date = date('Y/m/d H:i');
$assignStatus = 0;
$reqStatus = 0;
$transStatus = 0;
$alarmStatus = 0;

function getStatusFromServer(){
    $sql = "SELECT * FROM bayregister";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_all();
    return $row;
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["pname"]))){
        $pname_err= "Please enter a patient name.";
    }
    elseif (empty(trim($_POST["ptype"]))){
      $ptype_err = "Please enter a patient type.";
    }
    elseif (empty(trim($_POST["psname"]))){
      $sname_err = "Please enter a patient surname.";
    }
    elseif (empty(trim($_POST["ptitle"]))){
      $title_err = "Please enter a patient title.";
    }
    elseif (empty(trim($_POST["bayno"]))){
      $bayno_err = "Please enter a Bay No.";
    } else{
        // Prepare a select statement
        $sql = "SELECT * FROM bayregister WHERE id = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_bayno);

            // Set parameters
            //$param_pname = trim($_POST["pname"]);
            //$param_ptype = trim($_POST["ptype"]);
            $param_bayno = (int)trim($_POST["bayno"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $assignStatus = $row['assignStatus'];
                //echo $assignStatus;
                ///////////////////////////////////////////////
                if($stmt->num_rows == 1){
                    $patient_status = "Bay is already assigned.";
                } else{
                    $sql = "INSERT INTO patients VALUES(pname = ?, ptype = ? )";

                    $pname = trim($_POST["pname"]);
                    $ptype = trim($_POST["ptype"]);
                    //$bayno = trim($_POST["bayno"]);
                  }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
    // Check input errors before inserting in database
    if(empty($pname_err) && empty($ptype_err) && empty($bayno_err)){
        if($assignStatus == false){
          // Prepare an insert statement
          $sql = "INSERT INTO patients(pname, ptype) VALUES (?, ?)";

          if($stmt = $mysqli->prepare($sql)){
              // Bind variables to the prepared statement as parameters
              $stmt->bind_param("ss", $param_pname, $param_ptype);

              // Set parameters
              $param_pname = trim($_POST["pname"]);
              $param_ptype = trim($_POST["ptype"]);
              // Attempt to execute the prepared statement
              if($stmt->execute()){
                  // print patient status
                  $patient_status;
                  $sql = "SELECT pid FROM patients ORDER BY pid DESC LIMIT 1";
                  if($stmt = $mysqli->prepare($sql)){
                      if($stmt->execute()){
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        $pid = $row["pid"];
                        //echo $pid;
                        $sqlStr = "UPDATE bayregister SET pid = ?, assignStatus = ?, assignTime = ? WHERE id = ?";
                        //$sqlStr = "UPDATE bayregister SET pid = ? WHERE id = ?";
                        if($stmtUpdate = $mysqli->prepare($sqlStr)){
                          // Set parameters
                          $pid = $pid;
                          $param_id = $param_bayno;
                          $assignStatus = true;
                          $assignTime = date('Y-m-d H:i');
                          // Bind variables to the prepared statement as parameters
                          $stmtUpdate->bind_param("iisi", $pid, $assignStatus, $assignTime, $param_id);

                          if($stmtUpdate->execute()){
                              $patient_status = "Patient placed successful.";
                              //include 'php_scripts/getStatus.php';
                              //$temp_bayno = "bay".$param_id;
                              //echo $temp_bayno;
                              //assignFunction($temp_bayno);
                              //echo "<script>functioncall('{$_GET['id']}');</script>";
                              //echo '<script type="text/javascript"> assignFunction('$temp_bayno');</script>';
                              //$var = $(function(){echo "<script type='text/javascript'> assignFunction();</script>";});
                              //echo '<script>','callMe();','</script>';
                              //$var = "<script> callMe(); </script>";
                              //echo '<script type = "text/javascript"> callMe(); </script';
                              //echo "<script>assignFunction(".$temp_bayno.");</script>";
                              //echo '<script type="text/javascript">assignFunction(1);</script>';
                              //echo "<script>assignFunction({$param_id});</script>";
                              //echo "<a href=\"javascript:assignFunction('$temp_bayno;');\">sfsef</a>";
                              echo '<script>alert("Patient placed successful.");</script>';
                              //echo '<script>alert("ijgdhogdojgdogjdojgodjg");</script>';
                          }else{
                            echo "Execution failed!!";
                          }
                        }
                      }
                  }
              } else{
                  echo "Something went wrong. Please try again later.";
              }
          }
        }else{
          //echo "Bay is already assigned";
          echo '<script>alert("Bay is temporarily not available.");</script>';
        }
    // Close connection
    $mysqli->close();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RECOVERY WARD DEPARTMENT</title>
    <script type="text/javascript" src="js/script.js"></script>
    <script  src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <audio id="myAudio" autoplay><source src="sounds/speech.mp3" type="audio/mpeg"></audio>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/css.css">
    <style type="text/css">
        body{ height:100%;font-family: "Verdana", Times, serif; text-align: center;background-color:rgba(200, 200, 150, 0.5);}
        html{height:95%}
    </style>
</head>
<body onLoad="clearTimeOut()" onUnload="clearTimeOut()">
  <div class="page-header">
      <h3>RECOVERY WARD DEPARTMENT.</h3>
      <h4 id="demo">_</h4>
  </div>
  <section class="intro">
    <row>
      <div class="col-lg-6 col-sm-12 left">
        <div class="wrapper">
            <h3>PATIENT PARKING SYSTEM</h3>
            <p>Please fill all fields to park a patient.</p>
            <form id="myForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div class="form-group <?php echo (!empty($ptype_err)) ? 'has-error' : ''; ?>">
                  <label>Patient Title</label>
                  <select class="form-control" name="ptype" type="text" value="<?php echo $ptype; ?>">
                    <option></option>
                    <option>Dr</option>
                    <option>Mr</option>
                    <option>Mrs</option>
                    <option>Miss</option>
                    <option>Ms</option>
                  </select>
                  <span class="help-block"><?php echo $ptype_err; ?></span>
              </div>
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>First Name</label>
                    <input type="text" name="pname"class="form-control" value="<?php echo $pname; ?>">
                    <span class="help-block"><?php echo $pname_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Surname</label>
                    <input type="text" name="sname"class="form-control" value="<?php echo $pname; ?>">
                    <span class="help-block"><?php echo $pname_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($ptype_err)) ? 'has-error' : ''; ?>">
                    <label>Patient Type</label>
                    <select class="form-control" name="ptype" type="text" value="<?php echo $ptype; ?>">
                      <option></option>
                      <option>DAY CASE</option>
                      <option>INPATIENT</option>
                    </select>
                    <span class="help-block"><?php echo $ptype_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($bayno_err)) ? 'has-error' : ''; ?>">
                    <label>Bay No.</label>
                    <!--<input type="text" name="bayno" class="form-control" value="<?php echo $bayno; ?>">-->
                    <select class="form-control" name="bayno" type="text" value="<?php echo $bayno; ?>">
                      <option></option>
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                      <option>6</option>
                      <option>7</option>
                      <option>8</option>
                    </select>
                    <span class="help-block"><?php echo $bayno_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="reset" class="btn btn-default" value="Reset">
                    <input type="submit" class="btn btn-primary" value="Park Patient">
                </div>
            </form>
        </div>
      </div>
      <div class="col-lg-6 col-sm-12 right">
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
    </row>
  </section>
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

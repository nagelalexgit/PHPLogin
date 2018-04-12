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
        <p>
          right pannel
        </p>
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
</body>
</html>

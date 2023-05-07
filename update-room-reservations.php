<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values

$startdate = $enddate = $starttime=$endtime = $duration = "";
$room_err = $class_err = $classstart_err = $classend_err = $starttime_err = $endtime_err = $duration_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["reservation_id"]) && !empty($_POST["reservation_id"])){
    // Get hidden input value
    $reservation_id = $_POST["reservation_id"];
    // Validate name
    $room = trim($_POST["room"]);    
	$class = trim($_POST["class"]);
	$startdate = trim($_POST["startdate"]);
	$enddate = trim($_POST["enddate"]);
	$starttime = trim($_POST["starttime"]);
	$endtime = trim($_POST["endtime"]);
	$duration = trim($_POST["duration"]);
    
    
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepare an insert statement
        $sql = "UPDATE room_reservations SET room_id = ?,class_id= ?,class_start= ?,class_end= ?,class_start_time= ?,class_end_time= ?,class_duration= ?  WHERE reservation_id = ?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iisssssi", $param_roomid, $param_classid, $param_classstart,$param_classend,$param_starttime,$param_endtime,$param_duration,$param_reservationid);
            
            // Set parameters
            $param_roomid = $room;
            $param_classid = $class;
            $param_classstart = $startdate;
			$param_classend = $enddate;
            $param_starttime = $starttime;
            $param_endtime = $endtime;
			$param_duration = $duration;
            $param_reservationid = $reservation_id;
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: room-reservations.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["reservation_id"]) && !empty(trim($_GET["reservation_id"]))){
        // Get URL parameter
        $reservation_id =  trim($_GET["reservation_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM room_reservations WHERE reservation_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $reservation_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $startdate = $row["class_start"];
                    $enddate = $row["class_end"];
                    $starttime = $row["class_start_time"];
					$endtime = $row["class_end_time"];
					$duration = $row["class_duration"];
					
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        //mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please fill this form and submit to update class schedule record to the database.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Room</label>
                            <select name="room" id="roomid" class="form-control">								
								<?php
								// Include config file
								require_once "config.php";								
								
								// Attempt select query execution
								$sql = "select * from studio_room order by room_name ASC";
								if($result = mysqli_query($link, $sql)){
									if(mysqli_num_rows($result) > 0){                          
											
											while($row = mysqli_fetch_array($result)){
											?>	
												<option value="<?php echo $row['room_id']; ?>">
												<?php if($row['room_id']==$select){ echo "selected"; } ?>
												<?php echo $row['room_name']; ?>  
												</option>
								<?php
											}											
										// Free result set
										mysqli_free_result($result);
									} else{
										echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
									}
								} else{
									echo "Oops! Something went wrong. Please try again later.";
								}			 
								// Close connection
								//mysqli_close($link);
								?>	
							</select>		
                        </div>
                        <div class="form-group">
                            <label>Class</label>
                            <select name="class" id="classid" class="form-control">								
								<?php
								// Include config file
								require_once "config.php";								
								
								// Attempt select query execution
								$sql = "select * from dance_class order by class_name ASC";
								if($result = mysqli_query($link, $sql)){
									if(mysqli_num_rows($result) > 0){                          
											
											while($row = mysqli_fetch_array($result)){
											?>	
												<option value="<?php echo $row['class_id']; ?>">
												<?php if($row['class_id']==$select){ echo "selected"; } ?>
												<?php echo $row['class_name']; ?>  
												</option>
								<?php
											}											
										// Free result set
										mysqli_free_result($result);
									} else{
										echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
									}
								} else{
									echo "Oops! Something went wrong. Please try again later.";
								}			 
								// Close connection
								mysqli_close($link);
								?>	
							</select>		
                        </div>
                        <div class="form-group">
                            <label>Class Start Date</label>
                            <input type="text" name="startdate" class="form-control <?php echo (!empty($startdate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $startdate; ?>">
                            <span class="invalid-feedback"><?php echo $startdate_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Class End Date</label>
                            <input type="text" name="enddate" class="form-control <?php echo (!empty($enddate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $enddate; ?>">
                            <span class="invalid-feedback"><?php echo $enddate_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Class Start Time</label>
                            <textarea name="starttime" class="form-control <?php echo (!empty($starttime_err)) ? 'is-invalid' : ''; ?>"><?php echo $starttime; ?></textarea>
                            <span class="invalid-feedback"><?php echo $starttime_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Class End Time</label>
                            <input type="text" name="endtime" class="form-control <?php echo (!empty($endtime_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $endtime; ?>">
                            <span class="invalid-feedback"><?php echo $endtime_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Class Duration</label>
                            <input type="text" name="duration" class="form-control <?php echo (!empty($duration_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $duration; ?>">
                            <span class="invalid-feedback"><?php echo $duration_err;?></span>
                        </div>
						<input type="hidden" name="reservation_id" value="<?php echo $reservation_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="room-reservations.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
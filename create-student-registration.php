<?php
// Include config file
require_once "config.php";


 
// Define variables and initialize with empty values
$studentid = $instructorid = $classid = 0;
$name_err = $address_err = $salary_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $studentid = trim($_POST["selectstudent"]);
	
    // Validate address
    $instructorid = trim($_POST["selectinstuctor"]);
    
    // Validate salary
    $classid = trim($_POST["selectclass"]);
    
	echo $studentid;
	echo $instructorid;
	echo $classid;
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO class_details (instructor_id, student_id, room_reservation_id,reservation_date) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iiis", $param_instructor_id, $param_student_id, $param_reservation_id, $param_curr_date);
            
            // Set parameters
			$param_instructor_id = $instructorid;
            $param_student_id = $studentid;            
            $param_reservation_id = $classid;
			$param_curr_date = date('Y-m-d H:i:s');
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: student-registrations.php");
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
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Student Registration</title>
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
                    <h2 class="mt-5">Create Student Registration</h2>
                    <p>Please fill this form and submit to create student registration record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="form-group">
							<label>Student</label>
							<select name="selectstudent" id="studentid" class="form-control">								
								<?php
								// Include config file
								require_once "config.php";								
								
								// Attempt select query execution
								$sql = "SELECT * FROM students order by first_name ASC";
								if($result = mysqli_query($link, $sql)){
									if(mysqli_num_rows($result) > 0){                          
											
											while($row = mysqli_fetch_array($result)){
											?>	
												<option value="<?php echo $row['student_id']; ?>">
												<?php if($row['student_id']==$select){ echo "selected"; } ?>
												<?php echo $row['first_name']; ?>  <?php echo $row['last_name']; ?> 
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
							<select name="selectclass" id="classid" class="form-control">								
								<?php
								// Include config file
								require_once "config.php";								
								
								// Attempt select query execution
								$sql = "SELECT rr.reservation_id,dc.class_name FROM room_reservations rr inner join dance_class dc on rr.class_id = dc.class_id where rr.booking_status_id = 2 order by rr.class_start ASC";
								if($result = mysqli_query($link, $sql)){
									if(mysqli_num_rows($result) > 0){                          
											
											while($row = mysqli_fetch_array($result)){
											?>	
												<option value="<?php echo $row['reservation_id']; ?>">
												<?php if($row['reservation_id']==$select){ echo "selected"; } ?>
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
								//mysqli_close($link);
								?>	
							</select>		
						</div>
						
						<div class="form-group">
							<label>Instructor</label>
							<select name="selectinstuctor" id="instructorid" class="form-control">								
								<?php
								// Include config file
								require_once "config.php";								
								
								// Attempt select query execution
								$sql = "select * from employees order by name ASC";
								if($result = mysqli_query($link, $sql)){
									if(mysqli_num_rows($result) > 0){                          
											
											while($row = mysqli_fetch_array($result)){
											?>	
												<option value="<?php echo $row['id']; ?>">
												<?php if($row['id']==$select){ echo "selected"; } ?>
												<?php echo $row['name']; ?>  
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
					
                        
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="student-registrations.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
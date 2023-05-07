<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $capacity = "";
$name_err = $capacity_err  = "";
 
// Processing form data when form is submitted
if(isset($_POST["room_id"]) && !empty($_POST["room_id"])){
    // Get hidden input value
    $room_id = $_POST["room_id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";    
    } else{
        $name = $input_name;
    }
    
    // Validate address address
    $input_address = trim($_POST["capacity"]);
    if(empty($input_address)){
        $capacity_err = "Please enter an address.";     
    } else{
        $capacity = $input_address;
    }
    
    
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($capacity_err)){
        // Prepare an update statement
        $sql = "UPDATE studio_room SET room_name=?, max_capacity=? WHERE room_id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $param_name, $param_address, $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_address = $capacity;           
            $param_id = $room_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: room.php");
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
    if(isset($_GET["room_id"]) && !empty(trim($_GET["room_id"]))){
        // Get URL parameter
        $room_id =  trim($_GET["room_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM studio_room WHERE room_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $room_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["room_name"];
                    $capacity = $row["max_capacity"];
                    
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
        mysqli_close($link);
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
    <title>Update Record</title>
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
                    <p>Please edit the input values and submit to update the Dance Room record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Room Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Max Capacity</label>
                            <textarea name="capacity" class="form-control <?php echo (!empty($capacity_err)) ? 'is-invalid' : ''; ?>"><?php echo $capacity; ?></textarea>
                            <span class="invalid-feedback"><?php echo $capacity_err;?></span>
                        </div>
                        
                        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="room.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
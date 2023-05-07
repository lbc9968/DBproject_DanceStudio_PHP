<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $level = $style = "";
$name_err = $level_err = $style_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["class_id"]) && !empty($_POST["class_id"])){
    // Get hidden input value
    $class_id = $_POST["class_id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address address
    $input_address = trim($_POST["level"]);
    if(empty($input_address)){
        $address_err = "Please enter an valid level.";     
    } else{
        $level = $input_address;
    }
    
    // Validate salary
    $input_salary = trim($_POST["style"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the correct style.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $style = $input_salary;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($level_err) && empty($style_err)){
        // Prepare an update statement
        $sql = "UPDATE dance_class SET class_name=?, level=?, style_id=? WHERE class_id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_salary, $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_address = $level;
            $param_salary = $style;
            $param_id = $class_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: dance.php");
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
    if(isset($_GET["class_id"]) && !empty(trim($_GET["class_id"]))){
        // Get URL parameter
        $class_id =  trim($_GET["class_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM dance_class WHERE class_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $class_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["class_name"];
                    $level = $row["level"];
                    $style = $row["style_id"];
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
                    <p>Please edit the input values and submit to update the Dance Class record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Class Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <textarea name="level" class="form-control <?php echo (!empty($level_err)) ? 'is-invalid' : ''; ?>"><?php echo $level; ?></textarea>
                            <span class="invalid-feedback"><?php echo $level_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Style</label>
                            <input type="text" name="style" class="form-control <?php echo (!empty($style_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $style; ?>">
                            <span class="invalid-feedback"><?php echo $style_err;?></span>
                        </div>
                        <input type="hidden" name="class_id" value="<?php echo $class_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="dance.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
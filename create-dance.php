<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$cname = $level = $styleid = $fees = "";
$cname_err = $level_err = $styleid_err = $fees_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate First Name
    $input_name = trim($_POST["cname"]);
    if(empty($input_name)){
        $cname_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $cname_err = "Please enter a valid name.";
    } else{
        $cname = $input_name;
    }
    
    // Validate Last Name
    $input_level = trim($_POST["level"]);
    if(empty($input_level)){
        $level_err = "Please enter a level.";     
    } else{
        $level = $input_level;
    }
    
    // Validate styleid
    $input_style = trim($_POST["styleid"]);
    if(empty($input_style)){
        $styleid_err = "Please enter valid styleid.";  
    } else{
        $styleid = $input_style;
    }
	
	
    
    // Check input errors before inserting in database
    if(empty($cname_err) && empty($level_err) && empty($styleid_err) && empty($fees_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO dance_class (class_name, level, style_id) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sii", $param_cname, $param_level, $param_styleid, );
            
            // Set parameters
            $param_cname = $cname;
            $param_level = $level;
            $param_styleid = $styleid;	
			
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
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
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Dance Class</title>
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
                    <h2 class="mt-5">Create Dance Class</h2>
                    <p>Please fill this form and submit to add Dance Class record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Class Name</label>
                            <input type="text" name="cname" class="form-control <?php echo (!empty($cname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cname ?>">
                            <span class="invalid-feedback"><?php echo $cname_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <textarea name="level" class="form-control <?php echo (!empty($level_err)) ? 'is-invalid' : ''; ?>"><?php echo $level; ?></textarea>
                            <span class="invalid-feedback"><?php echo $level_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Style (Please enter a valid Style ID)</label>
                            <input type="text" name="styleid" class="form-control <?php echo (!empty($styleid_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $styleid; ?>">
                            <span class="invalid-feedback"><?php echo $styleid_err;?></span>
                        </div>
						
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="dance.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
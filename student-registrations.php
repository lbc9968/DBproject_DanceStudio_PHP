<?php require_once "head.php"; ?>
<?php require_once "navbar-new.php" ?>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Student Registrations</h2>  
						<a href="create-student-registration.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Student Registration</a>						
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
					
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM v_student_reservations";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>First Name</th>";
                                        echo "<th>Last Name</th>";
                                        echo "<th>Class Name</th>";  
										echo "<th>Instructor Name</th>";
                                        echo "<th>Room Name</th>";
                                        echo "<th>Max Capacity</th>"; 	
										echo "<th>Start Date</th>";
                                        echo "<th>End Date</th>";
                                        echo "<th>Start Time</th>"; 
										echo "<th>End Time</th>"; 	
										echo "<th>Action</th>";										
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
										echo "<td>" . $row['first_name'] . "</td>";
                                        echo "<td>" . $row['last_name'] . "</td>";
                                        echo "<td>" . $row['class_name'] . "</td>"; 
										echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['room_name'] . "</td>";
                                        echo "<td>" . $row['max_capacity'] . "</td>"; 
										echo "<td>" . $row['class_start'] . "</td>";
                                        echo "<td>" . $row['class_end'] . "</td>";
                                        echo "<td>" . $row['class_start_time'] . "</td>"; 
                                        echo "<td>" . $row['class_end_time'] . "</td>";
										echo "<td>";                                            
                                            echo '<a href="update-student-registration.php?class_reservation_id='. $row['class_reservation_id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete-student-registration.php?class_reservation_id='. $row['class_reservation_id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";	
                                        
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
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
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
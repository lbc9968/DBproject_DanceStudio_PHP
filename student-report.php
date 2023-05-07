<?php require_once "head.php"; ?>
<?php require_once "navbar-new.php" ?>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Student Report</h2> 
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
					// Set parameters
					$student_id = trim($_GET["student_id"]);
					
                    
                    // Attempt select query execution
                    $sql = "SELECT s.first_name, s.last_name, dc.class_name, e.name, sr.room_name, sr.max_capacity, 
							CAST(rr.class_start AS DATE) class_start,CAST(rr.class_end AS DATE) class_end,rr.class_start_time,rr.class_end_time
							FROM `DanceStudio`.`class_details` cd 
								inner join `DanceStudio`.`students` s
									on cd.student_id = s.student_id
								inner join `DanceStudio`.`employees` e
									on cd.instructor_id= e.id
								inner join room_reservations rr 
									on cd.room_reservation_id = rr.reservation_id
								inner join `DanceStudio`.`studio_room` sr    
									on rr.room_id = sr.room_id
								inner join `DanceStudio`.`dance_class` dc
									on rr.class_id = dc.class_id WHERE cd.student_id = '".$student_id."'";
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
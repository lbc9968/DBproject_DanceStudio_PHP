<header class="navbar navbar-default navbar-static-top">

<style>
    /* Add some padding on document's body to prevent the content
    to go underneath the header and footer */
    body{        
        padding-top: 60px;
        padding-bottom: 40px;
    }
    .container{        
        margin: 0 auto; /* Center the DIV horizontally */
    }
    .fixed-header, .fixed-footer{
        width: 100%;
        position: fixed;        
        background: Green;
        padding: 20px 0;
        color: #fff;
    }
    .fixed-header{
        top: 0;
    }
    .fixed-footer{
        bottom: 0;
    }    
    /* Some more styles to beutify this example */
    nav a{
        color: #fff;
        text-decoration: none;
        padding: 10px 10px;
        display: inline-block;
    }
    .container p{
        line-height: 200px; /* Create scrollbar to test positioning */
    }
	.title-font{
		font-size:15;
		font-weight: bold;
	}
</style>

 <div class="fixed-header">
 
        <div class="container">			
            <nav>
				<a href="index.php" style="color:white;"><i class = "fa fa-diamond"></i> Dance Studio </a>
                <a href="index.php" style="color:white;">Instructors</a>
                <a href="student.php" style="color:white;">Students</a>
                <a href="room-reservations.php" style="color:white;">Class Schedules</a>
                <a href="student-registrations.php" style="color:white;">Student Registration</a>
                <a href="room.php" style="color:white;">Dance Rooms</a>
				<a href="dance.php" style="color:white;">Dance Classes</a>	
				<a href="dance-style.php" style="color:white;">Dance Styles</a>				
            </nav>
        </div>
    </div>

   
</header>
<?php
  
    $conn = mysqli_connect("localhost","root","","nobody");
    // Check connection
    if (mysqli_connect_errno()){
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    //login

    function checkIfLogged(){

		session_start();

	    if($_SESSION['session']!=1){ 
	  
		  header("Location: login.php");  
		  
		}
		

    }

    
	

    function sanitize($data, $conn) {

		$data = trim($data);
		$data = stripslashes($data);
		//$data = htmlspecialchars($data);
		$data = $conn->real_escape_string($data);
		return $data;
		
	}

	function debug_to_console( $data ) {
  
	    $output = $data;
	    if ( is_array( $output ) )
	        $output = implode( ',', $output);

	    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
		
  	}

?>
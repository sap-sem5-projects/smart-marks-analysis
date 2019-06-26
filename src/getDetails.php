<?php

	require 'db.php';
	$conn = createConnection();

	if(isset($_POST["studentId"]) && isset($_POST["studentId"]) != ""){
		$studentId = $_POST["studentId"];
		$displayquery = "SELECT * FROM `student` WHERE `sid`='$studentId'";
		if(!$result = mysqli_query($conn , $displayquery)){
			exit(mysqli_error());
		}
		$response = array();
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_assoc($result)){
				$response = $row;
			}
		}
		else{
			$response["status"] = 200;
			$response["message"] = "Data Not Found!";
		}
		echo json_encode($response);
	}
	else{
		$response["status"] = 200;
		$response["message"] = "Invalid Request!";
	}
	closeConnection($conn);

?>

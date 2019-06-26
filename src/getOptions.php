<?php

	// session_start();
	// if(!isset($_SESSION['loggedIn'])) {
	// 	header('Location: index.php');
	// }

	require 'db.php';
//$bid=$_SESSION['bid'];

//DONE EDITING
	// $conn = createConnection();
/*
	function getSemesters() {
		$conn = createConnection();
		$sem = "";
		//$sql2="select * from `sem`;";
	$sql = " SELECT * FROM `sem` where `semid` in (select `semid` from `teacher_subject` where `tid` in (select `tid` from `teacher` where `bid` ='$bid' and `tid`='$username'));";
		$result = mysqli_query($conn, $sql);
	//	echo $conn->error;
		while($row = mysqli_fetch_array($result)) {
		//	$sem .= '<option value="'.$row["cname"].'">'.$row["cname"].'</option>';
				$sem .= '<option value="'.$row["semid"].'">'.$row["sem"].'</option>';
		//	$sem .= '<option value="'.$row["sem"].'">'.$row["cname"].'</option>';
			//$sem .= '<option value="'.$row["sem"].'">'.$row["sem"].'</option>';
		}
		return $sem;
	}*/
	function getSemesters() {
	$conn = createConnection();
	$sem = "";
	$tid=$_SESSION['username'];
//	$sem= '<option value="">Select Subj</option>';
	$sql = " SELECT * FROM `sem` where `semid` in (select `semid` from `teacher_subject` where `tid`='$tid');";
	$result = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_array($result)) {
		$sem .= '<option value="'.$row["semid"].'">'.$row["sem"].'</option>';
	}
	return $sem;
	closeConnection($conn);
}
//done editing
	// $conn = createConnection();
	if(isset($_POST['semId'])) {
		// echo $semid
$conn = createConnection();
		$semid = $_POST['semId'];
		$tid=$_SESSION['username'];
		echo "sfdvd";
		$subject = '<option value="">Select Subject</option>';
		//$sql = "SELECT * FROM `subject` where `semid`='$semid';
		$sql = "SELECT * FROM `subject` where `semid`=$semid;";

		$result = mysqli_query($conn, $sql);

		while($row = mysqli_fetch_array($result)) {
			$subject .= '<option value="'.$row["sub_id"].'">'.$row["name"].'</option>';
		}
		echo $subject;
		// echo $semId;
	//	return $subject;
}//done editing

?>

<?php
	session_start();
	require 'db.php';
	function getClass() {
		$conn = createConnection();
		$bid=$_SESSION['bid'];
		$username=$_SESSION['username'];
		
		$sem = "";
		
		$sql = "SELECT * FROM `sem` where `semid` in (select `semid` from `teacher_subject` where `tid` in (select `tid` from `teacher` where `bid` ='$bid' and `tid`='$username'));";
		$result = mysqli_query($conn, $sql);
		
		while($row = mysqli_fetch_array($result)) {
			$sem .= '<option value="'.$row["semid"].'">'.$row["cname"].'</option>';
			//$sem .= '<option value="'.$row["sem"].'">'.$row["cname"].'</option>';
		}
		//echo $sem;
		return $sem;
	}
	
	$conn = createConnection();
	

	if(isset($_POST['semid']) && $_POST['request']==='student') {
		
		$semid = $_POST['semid'];
		$student = '<option value="all">All</option>';

		$sql = "SELECT * FROM `student` WHERE `semid`=".$semid;
		$result = mysqli_query($conn, $sql);
		

		while($row = mysqli_fetch_array($result)) {
			$student .= '<option value="'.$row["sid"].'">'.$row["name"].'</option>';
		}
		echo $student;
		
	}

	if(isset($_POST['semid']) && $_POST['request']==='exam') {
		
		$semid = $_POST['semid'];
		$sid = $_POST['sid'];
		$tid = $_SESSION['username'];
		$exam = '';

		$sql = "select *from exam,subject where tsid in (select tsid from teacher_subject where semid = ".$semid." 
		and tid = ".$tid.")and sub_id in (select sub_id from teacher_subject where semid = ".$semid." and tid = ".$tid.");";
		$result = mysqli_query($conn, $sql);

		$exam = '<option value="">Select Exam</option>';
		while($row = mysqli_fetch_array($result)) {
			$exam .= '<option value="'.$row["exid"].'">'.$row["exam_name"]." ".$row["name"].'</option>';
		}
		echo $exam;
		
	}

		if(isset($_POST['semid']) && $_POST['request']==='subject') {
		
		$semid = $_POST['semid'];
		$tid = $_SESSION['username'];
		$subject = '';

		$sql = "select *from subject where sub_id in(select sub_id from teacher_subject where semid = ".$semid." and 
		tid = ".$tid.")";
		$result = mysqli_query($conn, $sql);
		$subject = '<option value="">Select Subject</option>';
		while($row = mysqli_fetch_array($result)) {
			$subject .= '<option value="'.$row["sub_id"].'">'.$row["name"].'</option>';
		}
		echo $subject;
		
	}

	closeConnection($conn);
?>
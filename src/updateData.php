<?php

	require 'db.php';
	$conn = createConnection();

	if(isset($_POST["sid"])){
			$subid = $_POST['subid'];
			$sid=$_POST["sid"];
			$ia1Marks = $_POST['ia1Marks'];
			$practicalMarks = $_POST['practicalMarks'];
			$ia2Marks = $_POST['ia2Marks'];
			$semesterMarks = $_POST['semesterMarks'];
			
			$sql = "UPDATE marks,exam,teacher_subject set marks = ".$ia1Marks." where sid = ".$sid." and marks.exid = exam.exid and exam.tsid = teacher_subject.tsid and teacher_subject.tid =5001 and teacher_subject.sub_id =".$subid;
			mysqli_query($conn , $sql);
			echo $conn->error;
		}		

	closeConnection($conn);

?>
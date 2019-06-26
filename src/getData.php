<?php
//done editing
	session_start();
	if(!isset($_SESSION['loggedIn'])) {
		header('Location: index.php');
		exit;
	}
	require 'db.php';
	$conn = createConnection();
	// if($_POST['subject']!="" && $_POST['sem']!="") {
	if($_POST['subject']!="" && $_POST['sem']!="") {
		$subject = $_POST['subject'];
		$sem = $_POST['sem'];
		$bid=$_SESSION['bid'];
		$data = '<div class="col-10">
				<div class="d-flex justify-content-end">
					 <button type="button" class="btn btn-info mb-4"><a href ="analysis2.php">Analysis</a></button>
				</div>
				<table class="table table-bordered table-striped text-center text-white border-white table-dark">
					<tr>
						<th>Roll No.</th>
						<th>Name</th>
						<th>IA-1</th>
						<!--<th>IA-2</th>-->
						<!--<th>Practical/Viva</th>-->
						<!--<th>Semester</th>-->
						<th>Edit</th>
						<!--<th>Delete</th>-->
					</tr>';
		$displayqueryStudent = "SELECT * FROM `student` WHERE `semid` = $sem AND `bid` = $bid";
//$displayqueryStudent = "select * from marks where exid in (select exid from exam where exam_name='IA1' and tsid in (select tsid from teacher_subject where tid=5001));";
		$resultStudent = mysqli_query($conn , $displayqueryStudent);

		///$displayqueryMarks = "SELECT * FROM `marks` WHERE `studentId` = ".$_POST['sem']." AND `studentBranch` = ".$_SESSION['teacherBranch'];
		//$resultMarks = mysqli_query($conn , $displayqueryStudent);

		if(mysqli_num_rows($resultStudent)>0){
			$number = 1;
			$i=0;
			$semester=[];
			while($row = mysqli_fetch_array($resultStudent)){
				//$sql = "SELECT * FROM `marks` WHERE `sid` = ".$row['sid']." AND `exid`in (select exid from exam where tsid in (select tsid from `teacher_subejct` where sub_id='$_POST[]'));

				//$sql = "SELECT * FROM `marks` WHERE `sid` = ".$row['sid']." AND `exid`in (select exid from exam where tsid in (select tsid from `teacher_subejct` where sub_id='$_POST[]'));
				//$displayqueryStudent = "select * from marks where exid in (select exid from exam where exam_name='IA1' and tsid in (select tsid from teacher_subject where tid=5001));";
				//$sql = "select * from marks where exid in (select exid from exam where exam_name='IA1' and tsid in (select tsid from teacher_subject where tid=5001));";
$sql="SELECT marks FROM `marks` where `exid` in (SELECT `exid` FROM `exam` where `exam_name`='IA1' AND `tsid` in (SELECT `tsid` FROM `teacher_subject` where tid=5001))";
			//	$sql="select * from `marks` where exid in (select exid from exam where exam_name='IA1' and tsid in (select tsid from teacher_subject where tid=5001));";
				$marks = mysqli_query($conn, $sql);
				if(mysqli_num_rows($marks)>0){
				 	while($marksrow = mysqli_fetch_array($marks)) {
					$semester[$i]= $marksrow['marks'];
					$i++;
					}
				}
				$data .= '<tr>
							<td>'.$row['sid'].'</td>
							<td>'.$row['name'].'</td>
							<td>'.$semester[$number-1].'</td>
							<td>
								<button class="btn btn-warning" onclick="getUserDetails('.$row['sid'].')">Edit</button>
							</td>
							<!--<td>
								<button class="btn btn-danger" onclick="deleteUser('.$row['sid'].')">Delete</button>
							</td>-->
						</tr>';
				$number++;
			}
			$data .= '</table></div>';
		}
		else{
			$data = "<p class='text-danger mt-5 h3 font-weight-bold'>No Data Found!!!</p>";
		}
		echo "$data";
	} else {
		echo "$data";
	}

?>

<?php
//require 'getQuery.php';
if(!empty($_POST['Search'])){

$semid =$_POST['sem'];
$sid = 	$_POST['student'];
$exid = $_POST['exam'];
$type = $_POST['type'];
$subid = $_POST['subject'];
$tid = $_SESSION['username'];

//echo $subid;

$conn = createConnection();

if($sid==='all'){

$labels = [];
$data = [];
$type = 'pie';
$label = "Pass-Fail ratio";

	echo "<br>All students sorted from higest to lowest marks obtained<br>";
	$sql="select *from student , marks where exid = ".$exid." and semid = ".$semid." and student.sid = 
	marks.sid order by marks desc;";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
    array_push($labels,'Pass');
    array_push($data,$result->num_rows);
    while($row = $result->fetch_assoc()) {
        echo "Roll no: " . $row["sid"]. " &nbspName: " . $row["name"]. " &nbspMarks: " . $row["marks"]. "<br>";
    }} 	
    else {
    echo "0 results";
}

	echo "<br>List of all students failed in exam<br>";
	$sql = "select *from student , marks where exid = ".$exid." and 
	marks < (select min from exam where exid = ".$exid.")and student.sid = marks.sid order by marks asc;";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
    array_push($labels,'Fail');
    array_push($data,$result->num_rows);

    while($row = $result->fetch_assoc()) {
        echo "Roll no: " . $row["sid"]. " &nbspName: " . $row["name"]. " &nbspMarks: " . $row["marks"]. "<br>";
    }
	} 
	else {
		echo "0 results";
	}

echo '<canvas id="myChart1" width="150" height="50"></canvas>';
$script = "<script>
var ctx = document.getElementById('myChart1').getContext('2d');
var myChart = new Chart(ctx, {
    type: '".$type."',
    data: {
        labels:".json_encode($labels).",
        datasets: [{
            label: '".$label."',
            data: ".json_encode($data).",
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 99, 132, 0.2)',
             
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255,99,132,1)',
      
            ],
            borderWidth: 2.5
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]

        }
    }
});
</script>";

echo $script;

echo "<br>Average of class<br>";
	
$sql = "select semid,avg(marks) from student , marks where exid = ".$exid.";";

$result = $conn->query($sql);
echo $conn->error;



if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo " Average : " . $row["avg(marks)"]. "<br>";
    }
} else {
    echo "0 results";
}
}

else {

if(!empty($subid)){
	echo "<br>Student marks accross for particular subject<br>";
	$sql = "select *from marks,exam where marks.exid in (select exid from exam where tsid in (select tsid from 
	teacher_subject where tid = ".$tid." and sub_id = ".$subid." and semid = ".$semid.")) and marks.exid = 
	exam.exid and sid = ".$sid.";";
	$result = $conn->query($sql);
$labels = [];
$data = [];
$type = 'bar';
$label = "Marks accross various test";

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Exam Name: " . $row['exam_name']. " Subject: " . $row["sid"]. " Marks: " . $row["marks"]. " Out of: " . $row["max"]. "<br>";
        array_push($labels,$row['exam_name']);
        array_push($data,$row['marks']);
    }
} else {
    echo "0 results";
}

echo '<canvas id="myChart2" width="150" height="50"></canvas>';
$script = "<script>
var ctx = document.getElementById('myChart2').getContext('2d');
var myChart = new Chart(ctx, {
    type: '".$type."',
    data: {
        labels:".json_encode($labels).",
        datasets: [{
            label: '".$label."',
            data: ".json_encode($data).",
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                	min: 0,
                    max: 20,
                    beginAtZero:true
                }
            }]

        }
    }
});
</script>";

echo $script;
}
else{
echo "<br>Student marks accross for particular exam<br>";
$sql = "select *from marks,exam where marks.exid = ".$exid." and marks.exid = exam.exid and sid = ".$sid.";";
$result = $conn->query($sql);
$labels = [];
$data = [];
$type = 'pie';
$label = "Result";

if ($result->num_rows > 0) {
    // output data of each row
    array_push($labels,"Out of");
    array_push($data,"20");
    while($row = $result->fetch_assoc()) {
       echo "Exam Name: " . $row['exid']. " Subject: " . $row["sid"]. " Marks: " . $row["marks"]."<br>";
        array_push($labels,'Obtained');
        array_push($data,$row['marks']);
    }
    	//echo json_encode($data);
    	
} else {
    echo "0 results";
}

echo '<canvas id="myChart2" width="150" height="50"></canvas>';
$script = "<script>
var ctx = document.getElementById('myChart2').getContext('2d');
var myChart = new Chart(ctx, {
    type: '".$type."',
    data: {
        labels:".json_encode($labels).",
        datasets: [{
            label: '".$label."',
            data: ".json_encode($data).",
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                	min: 0,
                    max: 20,
                    beginAtZero:true
                }
            }]

        }
    }
});
</script>";

echo $script;

}
}
}
?>
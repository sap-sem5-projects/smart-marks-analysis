<?php
//session_start();
require 'getQuery.php';
$sem = getClass();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="./css/bootstrap/css/bootstrap.min.css">
    <script src="js/script.js" charset="utf-8"></script>
<title>Analysis</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
function getstud() {
    $('#sem').change(function() {
        var semid = this.value;
        $.ajax({
            url: "getQuery.php",
            type: "post",
            data: {
                semid:semid,
                request : "student"
            },

            success: function(data, status) {
            	console.log(data);
                $('#student').html(data);
                // alert(data);
            }
        });
    });
}	

function getexam() {

    $('#sem').change(function() {
        var sid = this.value;
        var semid = $("#sem").val();
        console.log(semid);
        $.ajax({
            url: "getQuery.php",
            type: "post",
            data: {
                semid:semid,
                sid:sid,
                request : "exam"
            },

            success: function(data, status) {
            	console.log(data);
                $('#exam').html(data);
                // alert(data);
            }
        });
    
    });
}

function getsubjects() {

    $('#sem').change(function() {
        var semid = this.value;
        console.log(semid);
        $.ajax({
            url: "getQuery.php",
            type: "post",
            data: {
                semid:semid,
                request : "subject"
            },

            success: function(data, status) {
            	console.log(data);
                $('#subject').html(data);
                // alert(data);
            }
        });
    
    });

}


function sendData() {

        var semid = $("#sem").val();
        var sid = $("#student").val();
        var exid = $("#exam").val();
        var type = $("#type").val();
        var subid = $("#subject").val();
        console.log(semid);
        $.ajax({
            url: "getQueryData.php",
            type: "post",
            data: {
                sem:semid,
                student:sid,
                exam:exid,
                type:type,
                subject:subid,
                Search : "set"
            },

            success: function(data, status) {
                console.log(data);
                $('#result').html(data);
                // alert(data);
            }
        });

}

</script>

<script type="text/javascript">
	$(function() {	
		getexam();
		getstud();
		getsubjects()
	});
</script>

</head>
<body class="bg-light border border-dark rounded">

<center>
<div class="form-group">   
<form action="analysis2.php" method="post" class="form-horizontal">
	<select id="sem" name="sem" class="col-sm-2 control-label bg-secondary">
		<option value="">Select Class</option>
		
		<?php echo $sem; ?> 
	</select>

	<select id="student" name="student" class="col-sm-2 control-label">
		<option value="">Select Student</option>
		
	</select>

	<select id="exam" name="exam" class="col-sm-2 control-label bg-secondary">
		 <option value="">Select Exam</option> 
		
	</select>

	<select id="subject" name="subject" class="col-sm-2 control-label">
		<option value="">Select Subject</option>
		
	</select>


	<select id="type" name="type" class="col-sm-2 control-label bg-secondary">
		<option value="">Select Type</option>
		<option value="1">Bar</option>
		<option value="2">Pie</option>
		<option value="3">Graph</option>
	</select>

	<input type="submit" name="Search" value="Search" class="btn col-sm-2 control-label"/>

</form>
</div>
</center>
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

</body>
</html>

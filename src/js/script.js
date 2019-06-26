function checkData() {
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;

    if (username.length == 0 || password.length == 0) {
        swal("Invalid","Enter Username & Password!","error");
        if (username.length == 0) {
            document.getElementById('username').focus();
        } else {
            document.getElementById('password').focus();
        }
    } else {
        $.ajax({
    		url:"checkData.php",
    		type:"post",
    		data:{
    			username:username,password:password
    		},

    		success:function(data , status){
    			if(data == "Success") {
                    var name = username.charAt(0).toUpperCase() + username.substr(1);
                    var msg = "Welcome "+name;
                    swal("LogIn Successful",msg,"success");
                    setInterval(function() {
                        window.location.assign('student.php');
                    }, 700);
                } else {
                    swal("Invalid Data","No data found!","error");
                    document.getElementById("password").value = '';
                    document.getElementById('username').focus();
                    // document.getElementById('username').select();
                }
    		}
        });
    }
}

var count = -1;

function verifyValues() {
    var subject = document.getElementById('subject').value;
    var sem = document.getElementById('sem').value;
    count+=1;
    // alert(subject+" "+year+" "+sem);
    if((subject == "" || sem == "") && count > 0) {
        swal("Invalid Option","First Select Options!","warning");
    } else if(count > 0) {
        $.ajax({
            url: "getData.php",
            type: "post",
            data: {
                subject:subject, sem:sem
            },
            success:function(data, status) {
                if(data) {
                    console.log(data);
                    document.getElementById('putData').innerHTML = data;
                } else {
                    alert(data);
                }
            }
        });
    }
}


function getOptions() {
    $('#sem').change(function() {
        var semId = this.value;
        $.ajax({
            url: "getOptions.php",
            type: "post",
            data: {
                semId:semId
            },

            success: function(data, status) {
                $('#subject').html(data);
                // alert(data);
            }
        });
    });
}

function addRecord() {
    var studentId = $("#studentId").val();
    var studentName = $("#studentName").val();
    var studentName = $("#studentId").val();
    var studentEmail = $("#studentEmail").val();
    var studentSem = $("#studentSem").val();
    var studentId = $("#studentId").val();
    var studentId = $("#studentId").val();
    var studentId = $("#studentId").val();
}

function getUserDetails(studentId){
    $("#hiddenuserid").val(studentId);

    $.post("getDetails.php" , {
        studentId:studentId
    } , function(data , status){
        var student = JSON.parse(data);
        $("#updatestudentId").val(student.studentId);
        $("#updatestudentName").val(student.studentName);
        $("#updatestudentEmail").val(student.studentEmail);
        // $("#updatestudentBranch").val(student.studentBranch);
      //  $("#updatestudentSem").val(student.studentSem);
        $("#updateia1Marks").val(student.ia1Marks);
      //  $("#updateia2Marks").val(student.ia2Marks);
      //  $("#updatepracticalMarks").val(student.practicalMarks);
        //$("#updatesemesterMarks").val(student.semesterMarks);
    });

    $("#updateUserModal").modal("show");
    // swal("", String(studentId), "");
}

function updateUserDetails() {
    //Called after user hits update button
    var sid = $("#hiddenuserid").val();
    var ia1Marks = $("#updateia1Marks").val();
    var ia2Marks = $("#updateia2Marks").val();
    var practicalMarks = $("#updatepracticalMarks").val();
    var semesterMarks = $("#updatesemesterMarks").val();
    var subid = $("#subject").val();
    $.ajax({
            url: "updateData.php",
            type: "post",
            data: {
                subid:subid,
                sid:sid,
                ia1Marks:ia1Marks,
                ia2Marks:ia2Marks,
                practicalMarks:practicalMarks,
                semesterMarks:semesterMarks
            },

            success:function(data, status) {
                if(data) {
                   swal("", String("Record Updated"), "");
                } else {
                 console.log(data);
                }
            }
        });

    verifyValues();

}

















function deleteUser(studentId) {
    // Delete Button
    // alert(studentId);
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function(){
        swal("Deleted!", "Student Record has been deleted.", "success");
    });
    // );
}









function go(){
  window.location.assign('analysis2.php');
}



function logout() {
    $.ajax({
        url: 'logout.php',
        type: 'post',
        data: {},

        success: function(data, status) {
            swal("Logged Out","Logged out successfully!","success");
            setInterval(function() {
                window.location.assign('index.php');
            }, 1200);
        }
    });
}

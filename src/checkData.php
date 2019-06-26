<?php
    require 'db.php';

    session_start();
    // if ($_SESSION['loggedIn'] == 1) {
    //     header('Location: test.php');
    //     exit;
    // }
    //done editin

    $conn = createConnection();

    $username = $_POST['username'];
    $password = $_POST['password'];
    $password=md5($password);
    $sql = "SELECT * FROM `teacher` WHERE `tid` = '$username' AND `password` = '$password'";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($result);
    if ($rows == 1) {
        while($data = mysqli_fetch_array($result)) {
            $_SESSION['bid'] = $data['bid'];
            $_SESSION['username'] = $data['tid'];
        }
        $_SESSION['loggedIn'] = 1;
        echo "Success";
    } else {
        echo "";
    }

    closeConnection($conn);
?>

<?php

    function createConnection() {
        $dbUsername = 'root';
        $dbPassword = '';
        $dbHost = 'localhost';
        $dbDatabaseName = 'ip';
        return mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbDatabaseName);
        //echo 'connected';
    }
//DONE EDITING
    function closeConnection($conn) {
        $conn->close();
    }

?>

<?php
    if (!empty($_POST['EMAIL']) && !empty($_POST['PASSWORD'])) {
        $EMAIL = $_POST['EMAIL'];
        $PASSWORD = $_POST['PASSWORD'];
        $result = array();
        $conn = mysqli_connect("localhost", "root", "", "fyp");
        if ($conn) {
            $sql = "select * from USERS where EMAIL = '" . $EMAIL . "'";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) != 0) {
                $row = mysqli_fetch_assoc($res); 
                if (mysqli_query($conn, $sql)) {
                    $result = array("status" => "success", "message" => "Login successful",
                        "NAME" => $row['NAME'], "EMAIL" => $row['EMAIL'], "PASSWORD" => $row['PASSWORD']);
                } else $result = array("status" => "failed", "message" => "Login failed try again");
            } else $result = array("status" => "failed", "message" => "Retry with correct email and password");
        } else $result = array("status" => "failed", "message" => "Database connection failed");
    } else $result = array("status" => "failed", "message" => "All fields are required");
    echo json_encode($result, JSON_PRETTY_PRINT);
?> 
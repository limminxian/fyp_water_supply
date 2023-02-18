<?php include_once 'conn.php';
    if (!empty($_POST['EMAIL']) && !empty($_POST['PASSWORD'])) {
        $conn = getDB();
        $EMAIL = $_POST['EMAIL'];
        $PASSWORD = $_POST['PASSWORD'];
        $result = array();
        if ($conn) {
            $sql = "select u.NAME, u.EMAIL, u.PASSWORD, u.TYPE, u.STATUS, r.name as ROLENAME, u.ID from users u
            inner join role r on u.TYPE = r.ID
            where u.EMAIL = '" . $EMAIL . "'";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) != 0) {
                $row = mysqli_fetch_assoc($res); 
                if (mysqli_query($conn, $sql)) {
                    if($row['ROLENAME'] == 'Technician' || $row['ROLENAME'] == 'technician'|| $row['ROLENAME'] == 'TECHNICIAN') {
                        if($row['STATUS'] == 'ACTIVE' || $row['STATUS'] == 'Active') {
                            $result = array("status" => "success", "message" => "Login successful",
                            "ID" => $row['ID'], "NAME" => $row['NAME'], "EMAIL" => $row['EMAIL'], "PASSWORD" => $row['PASSWORD'], "ROLENAME" => $row['ROLENAME'], "STATUS" => $row['STATUS']);
                        } else $result = array("status" => "failed", "message" => "You have been suspended");
                    } else $result = array("status" => "failed", "message" => "You are not a technician to log in");
                } else $result = array("status" => "failed", "message" => "Login failed try again");
            } else $result = array("status" => "failed", "message" => "Retry with correct email and password");
        } else $result = array("status" => "failed", "message" => "Database connection failed");
    } else $result = array("status" => "failed", "message" => "All fields are required");
    echo json_encode($result, JSON_PRETTY_PRINT);
?>
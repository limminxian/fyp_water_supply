<?php
if (!empty($_POST['userID'])
	&& !empty($_POST['userID'])
	&& !empty($_POST['userID'])
) 
{
	$connection = mysqli_connect("localhost", "root", "", "fyp");
    $userID = $_POST['userID'];
    $result = array();
	$ticketsArr = array();
	
    if ($connection) {
		$ticketsSQL = "SELECT * FROM TICKET WHERE HOMEOWNER = '".$userID."'";
		$ticketsResult = mysqli_query($connection, $ticketsSQL);	
		if (mysqli_num_rows($ticketsResult) != 0) {
			while($ticketRow = mysqli_fetch_array($ticketsResult, MYSQLI_ASSOC)){
				$id = $ticketRow["ID"];
				$date = $ticketRow["DATE"];
				$serviceType = $ticketRow["TYPE"];
				$description = $ticketRow["DESCRIPTION"];
				$status = $ticketRow["STATUS"];
				
				$arr = array("date" => $date, 
									"serviceType" => $serviceType, 
									"description" => $description, 
									"status" => $status, 
									);
									
				$ticketsArr[$id] = $arr;
			}
			$result = array("status" => "success", "message" => "Fetch data successful");
			$result["tickets"] = $ticketsArr;
		} else $result = array("status" => "failed", "message" => "Failed to ticket data");					
    } else $result = array("status" => "failed", "message" => "Database connection failed");
} else $result = array("status" => "failed", "message" => "All fields are required");
echo json_encode($result, JSON_PRETTY_PRINT);
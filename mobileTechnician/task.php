<?php
    $conn = mysqli_connect("localhost", "root", "", "fyp");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        die();
    }

    //creating a query
    //$stmt = $conn->prepare("SELECT ID, HOMEOWNERNAME, SERVICETYPE, DESCRIPTION, ADDRESS, STATUS FROM tasktest;");
    $stmt = $conn->prepare("select h.STREET, h.BLOCKNO, h.UNITNO, h.POSTALCODE, u.NAME, t.STATUS, t.DESCRIPTION, k.NAME as SERVICETYPE
    from homeowner h, users u, ticket t, tickettype k
    where h.ID = u.ID  
    and h.ID = t.HOMEOWNER
    and t.TYPE = k.ID; ");
    // table - field
    // homeowner - name (from user table)
    // ticket - type
    // ticket - description
    // ticket - status
    // where clause = area (from homeowner table)
    



    //executing the query 
    $stmt->execute();
    
    //binding results to the query 
    $stmt->bind_result($STREET, $BLOCKNO, $UNITNO, $POSTALCODE, $NAME, $STATUS, $DESCRIPTION, $SERVICETYPE);
    
    $tasks = array(); 
    
    //traversing through all the result 
    while($stmt->fetch()){
        $task = array();
        $task['STREET'] = $STREET; 
        $task['BLOCKNO'] = $BLOCKNO;
        $task['UNITNO'] = $UNITNO;
        $task['POSTALCODE'] = $POSTALCODE; 
        $task['NAME'] = $NAME; 
        $task['STATUS'] = $STATUS; 
        $task['DESCRIPTION'] = $DESCRIPTION; 
        $task['SERVICETYPE'] = $SERVICETYPE; 
        array_push($tasks, $task);
    }
    
    //displaying the result in json format 
    echo json_encode($tasks);
?>
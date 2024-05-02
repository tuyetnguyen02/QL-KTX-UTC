<?php 

function queryResult($conn, $sql){
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return 0;
    }
}

function queryExecute($conn, $sql){
    if ($conn->query($sql) === TRUE) {
        return TRUE;
    } else {
        return FALSE;
    }
}

?>
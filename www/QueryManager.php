<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cegodb";

function sendSql()
{
    if(!isset($_POST['sql']) || $_POST['sql'] == "") {
        return false;
    }

    $conn = new mysqli($GLOBALS["servername"], $GLOBALS["username"], $GLOBALS["password"], $GLOBALS["dbname"]);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        return false;
    } 

    // $sql = "SELECT firstname, lastname FROM users";
    $result = $conn->query($_POST['sql']);
    
    if(!$result) {
        return false;
    }

    $fields = $result->fetch_fields();

    $fileHandle = fopen("sql_results.txt", "w") or die("Unable to open file!");

    if(!$result || $result->num_rows == 0) {
        return false;
    }

    // output data of each row
    while($row = $result->fetch_assoc()) {
        $txt = "";

        foreach($fields as $value) {
            $txt .= $value->name . ": " . $row[$value->name] . ", ";
        }
        
        $txt = rtrim($txt, ", ");
        $txt .= "\n";
        
        fwrite($fileHandle, $txt);
    }

    $result->data_seek(0);

    if(filesize("sql_results.txt") > 0) {
        $outer_count = 0;
        

        $deleteQuery = "DELETE FROM users WHERE ";
        foreach($fields as $value) {
        
            // echo $value->name;
            $deleteQuery .= $value->name . " IN (". 
            get_row_attribute($result, $value->name).
            ") AND ";

            $outer_count++;
            $result->data_seek($outer_count);
        }

        $deleteQuery = rtrim($deleteQuery, " AND ");

        $deleteResult = $conn->query($deleteQuery);
    }

    fclose($fileHandle);

    $conn->close();
    return true;
}

function get_row_attribute($sql_result, $attribute) {
    $txt = "";
    
    $sql_result->data_seek(0);
    while($id_row = $sql_result->fetch_assoc()) {
        $txt .= "'" . $id_row[$attribute] . "'" . ", ";
    }

    $txt = rtrim($txt, ", ");

    return $txt;
}
?>
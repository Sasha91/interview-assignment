<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cegodb";

function sendSql()
{
    if(isset($_POST['sql']) && $_POST['sql'] != "") {

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

        $fileHandle = fopen("sql_results.txt", "w") or die("Unable to open file!");


        if ($result && $result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $txt = "";

                $txt = isset($row["id"]) ? $txt . $row["id"] . ", " : $txt . "";
                $txt = isset($row["firstname"]) ? $txt . $row["firstname"] . ", " : $txt . "";
                $txt = isset($row["lastname"]) ? $txt . $row["lastname"] . ", " : $txt . "";
                $txt = isset($row["email"]) ? $txt . $row["email"] . ", " : $txt . "";

                
                $txt = $txt . "\n";
                fwrite($fileHandle, $txt);
            }

            $result->data_seek(0);

            if(filesize("sql_results.txt") > 0) {
                $outer_count = 0;
                $fields = $result->fetch_fields();

                echo "DELETE FROM users WHERE ";

                foreach($fields as $value) {
                
                    // echo $value->name;
                    echo $value->name . " in {". 
                    get_row_attribute($result, $value).
                    "} AND";

                    $outer_count++;
                    $result->data_seek($outer_count);
                }
            }

        } else {
            return false;
        }
        fclose($fileHandle);

        $conn->close();
        return true;
    }

    return false;
}

function get_row_attribute($sql_result, $attribute) {
    $txt = "";
    
    $sql_result->data_seek(0);
    while($id_row = $sql_result->fetch_assoc()) {
        $txt = $txt . $id_row[$attribute] . ", ";
    }

    $txt = rtrim($txt, ", ");

    return $txt;
}
?>
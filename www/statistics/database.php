<?php
// utente: mathe
// database: mathe
// host: localhost
// password: Math3!SiP
define("DBSERVERNAME", $dbserver);
define("DBNAME", $db);
define("DBUSERNAME", $dbuser);
define("DBPASSWORD", $userpass);

// development configuration
// define("DBSERVERNAME", "localhost:3306");
// define("DBNAME", "mathe_offline");
// define("DBUSERNAME", "root");
// define("DBPASSWORD", "root");

define("QUERYPREFIX", __DIR__ . "/queries/");

define("JSON_PRINT_MODE", 0);
define("ARRAY_PRINT_MODE",1);
define("CSV_PRINT_MODE",  2);
define("DO_NOT_PROCESS",  3);


function initialize() {
    // Install split_str function
    // mathe_data("sql_split", $key = "", $mode = DO_NOT_PROCESS);
}

function jsonify($result, $key) {
    print "{\n";

    $row_count = $result->num_rows -1;
    while($row = $result->fetch_assoc()) {

        print "\"{$row[$key]}\" : {";
        
        $field_count = count($row) -1;
        foreach( $row as $column_name => $value) {
            // $value = str_replace(array("\r","\n"), "\\n", $value);
            print "\"{$column_name}\" : `{$value}`" . ($field_count-- ? ',' : '');
        }

        print '}' . ($row_count-- ? ',' : '') . "\n";
    }
    
    print '}';
}

function arrayfy($result) {
    print "[\n";

    $row_count = $result->num_rows -1;
    while($row = $result->fetch_assoc()) {

        print "{";

        $field_count = count($row) -1;
        foreach( $row as $column_name => $value) {
            // $value = str_replace(array("\r","\n"), "\\n", $value);
            print "\"{$column_name}\" : `{$value}`" . ($field_count-- ? ',' : '');
        }

        print '}' . ($row_count-- ? ',' : '') . "\n";
    }
    
    print ']';
}

function csvfy($result, $separator = ',') {
    $row_count = $result->num_rows -1;
    $fields = $result->fetch_fields();

    // CSV Header
    $field_count = count($fields) - 1;
    foreach($fields as $field ){
        print $field->name . ($field_count-- ? $separator : '');
    }

    print "\n";
    
    while($row = $result->fetch_assoc()) {

        $field_count = count($row) -1;
        foreach( $row as $column_name => $value) {
            $v = is_numeric($value) ? $value : "\"{$value}\"";
            print $v . ($field_count-- ? $separator : '');
        }

        print "\n";
    }
    
}

function mathe_with_connection($callback){
    // Create connection
    $conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);
    $conn->set_charset('utf8');
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $callback($conn);

    $conn->close();
}

/*
  $query - name of the file containing the sql query. 
  File should be in ./queries and should have no extension .sql

  $key = "id" - Witch element will be used as a key in the generated structure.
  $mode = JSON_PRINT_MODE - By default emit a json object with $key as the key for each entry.
  $prepared = false | [types, [value1, ...valueN]]- Executes the query with a preparedStatement
 */
function mathe_data($query, $key = "id", $mode = JSON_PRINT_MODE, $prepared = false){

    $sql = file_get_contents(QUERYPREFIX . $query . ".sql");

    $printer = function ($result) use ($mode, $key) {
        switch ($mode) {
        case JSON_PRINT_MODE:
            jsonify($result, $key);
            break;

        case ARRAY_PRINT_MODE:
            arrayfy($result);
            break;

        case CSV_PRINT_MODE:
            csvfy($result);
            break;

        default:
        case DO_NOT_PROCESS:
            // dont print anything
        }
    };

    if($prepared == false) {
        $run_query = function ($conn) use ($sql ,$key, $mode, $printer){
            if ($result = $conn->query( $sql ) ){
                $printer($result);
            } else {
                echo "<h1>QUERY FAIL</h1>";
            }
        };
    } else {
        $run_query = function ($conn) use ($sql ,$key, $mode, $printer, $prepared){
            $statement = $conn->prepare( $sql );
            $statement->bind_param($prepared[0], $param);

            $param = $prepared[1][0];
            $statement->execute();

            if ($result = $statement->get_result()){
                $printer($result);
            } else {
                echo "<h1>PREPARED QUERY FAIL</h1>";
            }

        };
    }

    mathe_with_connection($run_query);
}
?>

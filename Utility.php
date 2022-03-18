<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "custom";

function connect(){
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function query($sql)
{
    $conn = connect();

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $result = $conn->query($sql);
    $conn->close();
    
    if ($result === true or $result === false or $result->num_rows > 0) {
        return $result;
    }
    return null;
}

function bootstrap(){
    echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>';
}

function getFields($table){
    $sql = "SHOW COLUMNS FROM $table";
    $result = query($sql);
    $fields = [];
    while ($row = $result->fetch_assoc()) {
        $fields[] = array(
            'name' => $row["Field"],
            'type' => $row["Type"]
        );
    }
    return $fields;
}

function bindQuery($sql, $params = [])
{
    $conn = connect();
    $stmt = $conn->prepare($sql);
    $types = '';
    $bindings = [
        'integer' => 'i',
        'double' => 'd',
        'string' => 's',
        'boolean' => 'b',
        'blob' => 'b',
        'NULL' => 's'
    ];
    foreach ($params as $param)
        $types .= $bindings[gettype($param)];
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();
    return $result;
}
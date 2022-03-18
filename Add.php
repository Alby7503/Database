<?php
$table = $_GET["table"] ?? null;
if (is_null($table) or empty($table)) {
    die("Tabella non specificata");
}
require_once "Utility.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fields = getFields($table);
    $sql = "INSERT INTO $table (";
    foreach ($fields as $key => $field) {
        $sql .= $field['name'] . ', ';
    }
    $sql = substr($sql, 0, -2);
    $sql .= ') VALUES (';
    $sql .= str_repeat('?, ', count($fields));
    $sql = substr($sql, 0, -2);
    $sql .= ')';
    $params = [];
    foreach ($fields as $field) {
        array_push($params, $_POST[$field['name']]);
    }
    $result = query($sql, $params);
    var_dump($params);
    var_dump($sql);
    var_dump($result);
    if ($result === true) {
        echo "Inserimento avvenuto con successo";
    } else {
        echo "Errore nell'inserimento";
    }
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi</title>
    <?php bootstrap(); ?>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Aggiungi alla tabella <b><?php echo $table; ?></b></h1>
        <form method="POST">
        <?php
        //$sql = "SHOW COLUMNS FROM $table";
        $fields = getFields($table);
        foreach ($fields as $key => $field) {
            $fieldName = $field["name"];
            $fieldType = $field["type"];
            $fieldType = explode("(", $fieldType)[0];
            $fieldType = strtolower($fieldType);
            echo "<div class=\"form-group\">
                <label for=\"$fieldName\">$fieldName ($fieldType)</label>
                <input type=\"$fieldType\" class=\"form-control\" id=\"$fieldName\">
            </div>";
        }
        ?><br>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Aggiungi</button>
        </div>
        </form>
    </div>
</body>

</html>
<?php
$table = $_GET["table"] ?? null;
require_once "Utility.php";
checkTable($table);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fields = getColumns($table);
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
    $result = bindQuery($sql, $params);
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
            $fields = getColumns($table);
            foreach ($fields as $key => $field) {
                $fieldName = $field["name"];
                $fieldType = $field["type"];
                $fieldType = explode("(", $fieldType)[0];
                $fieldType = strtolower($fieldType);
                echo "<div class=\"form-group\">
                <label for=\"$fieldName\">$fieldName ($fieldType)</label>
                <input type=\"$fieldType\" class=\"form-control\" id=\"$fieldName\" name=\"$fieldName\">
            </div>";
            }
            ?><br>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Aggiungi</button>
            </div>
        </form>
    </div>
    <?php overrideBack() ?>
</body>

</html>
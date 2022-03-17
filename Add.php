<?php
require_once "Utility.php";
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
    <form method="POST">
    <?php
    $table = $_GET["table"] ?? null;
    if (is_null($table) or empty($table)) {
        die("Tabella non specificata");
    }
    $sql = "SHOW COLUMNS FROM $table";
    $fields = query($sql);
    if ($fields->num_rows > 0) {
        while ($field = $fields->fetch_assoc()) {
            $fieldName = $field["Field"];
            $fieldType = $field["Type"];
            $fieldType = explode("(", $fieldType)[0];
            $fieldType = strtolower($fieldType);
            echo "<div class=\"form-group\">
                <label for=\"$fieldName\">$fieldName ($fieldType)</label>
                <input type=\"$fieldType\" class=\"form-control\" id=\"$fieldName\" name=\"$fieldName\">
            </div>";
        }
    }
    ?><br>
    <div class="text-center">
        <button type="submit" class="btn btn-primary">Aggiungi</button>
    </div>
    </form>
</body>

</html>
<?php

use function PHPSTORM_META\override;

require_once "Utility.php";
$table = $_GET["table"] ?? null;
checkTable($table);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerca</title>
    <?php bootstrap(); ?>
</head>

<body>
    <div class="container">
        <h1 class="text-primary">Cerca</h1>
        <form method="POST">
            <input type="hidden" name="table" value="<?php echo $table; ?>">
            <div class="form-group">
                <label for="column">Colonna</label>
                <select class="form-control" id="column" name="column">
                    <?php
                    $columns = getColumns($table);
                    foreach ($columns as $column)
                        echo '<option value="' . $column["name"] . '">' . $column['name'] . ' (' . $column['type'] . ')</option>';
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="value">Valore</label>
                <input type="text" class="form-control" id="value" name="value">
            </div><br>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Cerca</button>
            </div>
        </form><br>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $column = $_POST["column"];
            checkColumn($table, $column);
            $value = $_POST["value"];
            if (!checkValid($value))
                die('<div class="alert alert-danger">Valore non valido</div>');
            $sql = "SELECT * FROM $table WHERE $column LIKE ?";
            $result = bindQuery($sql, [$value]);
            if ($result->num_rows == 0)
                echo '<div class="alert alert-danger">Nessun risultato</div>';
            else {
                echo '<table class="table table-striped">';
                echo '<thead><tr>';
                foreach ($columns as $column)
                    echo '<th>' . $column['name'] . '</th>';
                echo '</tr></thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    foreach ($columns as $column)
                        echo '<td>' . $row[$column['name']] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            }
        }
        ?>
    </div>
    <?php overrideBack() ?>
</body>

</html>
<?php
require_once "Utility.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database</title>
    <?php bootstrap(); ?>
</head>

<body>
    <div class="container">
        <h1>Elenco tabelle di <?php echo $dbname ?></h1>
        <div class="row">
            <?php
            $sql = "SHOW TABLES";
            $result = query($sql);

            if (!is_null($result) and $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $table = $row["Tables_in_$dbname"];
                    $sql = "SHOW COLUMNS FROM $table";
                    $columns = query($sql);
                    echo "<div class=\"card\" style=\"width: 18rem;\">
            <div class=\"card-header\">$table</div>
            <ul class=\"list-group list-group-flush\">";
                    while ($column = $columns->fetch_assoc()) {
                        echo "<li class=\"list-group-item\">" . $column["Field"] . "</li>";
                    }
                    echo "</ul>
                    <div class=\"form-group text-center\" style=\"margin: 5% 0 5% 0\">
                        <a href=\"Add.php?table=$table\" class=\"btn btn-primary\">Aggiungi</a>
                        <a href=\"Interact.php?table=$table&action=drop\" class=\"btn btn-danger\">Elimina</a>
                    </div></div>";
                }
            }
            ?>
        </div>
    </div>
</body>

</html>
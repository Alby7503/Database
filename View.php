<?php
$table = $_GET["table"] ?? null;
require_once "Utility.php";
checkTable($table);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizza</title>
    <?php bootstrap(); ?>
</head>

<body>
    <div class="container">
        <h1 class="text-primary text-center">Visualizza tabella <b><?php echo $table; ?></b></h1>
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <?php
                    $fields = getColumns($table);
                    foreach ($fields as $key => $field) {
                        $fieldName = $field["name"];
                        echo "<th>$fieldName</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                echo "";
                $sql = "SELECT * FROM $table";
                $result = query($sql);
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td><button type="button" class="btn btn-close btn-danger " onclick="deleteRow(this)"></button></td>';
                        foreach ($fields as $key => $field) {
                            $fieldName = $field["name"];
                            echo "<td>" . $row[$fieldName] . "</td>";
                        }
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function deleteRow(button) {
            var row = button.parentElement.parentElement;
            let id = row.querySelector("td:nth-child(2)").innerText;
            fetch("Delete.php?table=<?php echo $table; ?>&pk=" + id, {
                method: "DELETE"
            }).then(function(response) {
                if (response.status == 200) {
                    row.remove();
                }
            });
        }
    </script>
</body>

</html>
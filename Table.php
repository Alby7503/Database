<?php
require_once "Utility.php";
$allowed_types = ['int', 'text'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table = $_POST["table"] ?? null;
    checkTable($table, true);
    $pk = $_POST["pk"] ?? null;
    $field_count = $_POST["field_count"] ?? null;
    if (!checkValid($pk) or !checkValid($field_count)) {
        die("Campo non valido: $pk");
    }
    $params = [];
    for ($i = 0; $i < $field_count; $i++) {
        $param = $_POST["field$i"] ?? null;
        $type = $_POST["type$i"] ?? null;
        if (checkValid($param) and checkValid($type) and ctype_alpha($param) and in_array(strtolower($type), $allowed_types)) {
            array_push($params, $param, $type);
        } else {
            die("Campo non valido: $param");
        }
    }
    $sql = "CREATE TABLE $table($pk INT NOT NULL AUTO_INCREMENT PRIMARY KEY";
    $params_count = count($params);
    if ($params_count / 2 > 0) {
        for ($i = 0; $i < $params_count; $i += 2) {
            $sql .= ', ' . $params[$i] . ' ' . $params[$i + 1];
        }
    }
    $sql .= ')';
    query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea tabella</title>
    <?php bootstrap(); ?>
</head>

<body>
    <div class="container">
        <h1 class="text-primary">Crea tabella</h1>
        <form method="POST">
            <input class="form-control" type="text" name="table" placeholder="Table Name"><br>
            <input class="form-control" type="text" name="pk" placeholder="Primary Key"><br>
            <input type="hidden" id="field_count" name="field_count" value="0">
            <h2 class="text-primary">Aggiungi campi</h2><br>
            <span id="fields">
                <template>
                    <div class="row">
                        <div class="col-sm-1">
                            <div class="text-center">
                                <button class="btn btn-close btn-warning" type="button" onclick="removeField(this)"></button>
                            </div>
                        </div>
                        <div class="col">
                            <input class="form-control" type="text" name="field{{number}}" placeholder="Nome Campo">
                        </div>
                        <div class="col">
                            <select class="form-control" name="type{{number}}">
                                <?php
                                foreach ($allowed_types as $allowed_type)
                                    echo "<option value='$allowed_type'>$allowed_type</option>";
                                ?>
                            </select>
                        </div>
                    </div>
                </template>
            </span>
            <br>
            <button type="button" class="btn btn-info" onclick="addField()">Aggiungi campo</button>
            <br><br>
            <input type="submit" class="btn btn-primary" value="Crea tabella"></button>
        </form>
    </div>
    <script>
        var fields = [];
        let field = document.getElementsByTagName("template")[0];
        const fieldsContainer = document.getElementById("fields");
        const fieldCount = document.getElementById("field_count");

        function addField() {
            let newField = field.content.cloneNode(true);
            newField.querySelector("input").name = "field" + fields.length;
            newField.querySelector("select").name = "type" + fields.length;
            fieldsContainer.appendChild(newField);
            fields.push(newField);
            fieldCount.value = fields.length;
        }

        function removeField(button) {
            button.parentElement.parentElement.parentElement.remove();
            fields.splice(fields.indexOf(button.parentElement.parentElement), 1);
            fieldCount.value = fields.length;
        }

        addField();
    </script>
</body>

</html>
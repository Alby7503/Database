<?php
require_once "Utility.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table = $_POST["table"] ?? null;
    checkTable($table, true);
    $pk = $_POST["pk"] ?? null;
    if (!checkValid($pk)) {
        die("Chiave primaria non valida");
    }
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
                            <select class="form-control">
                                <option value="INTEGER">INTEGER</option>
                                <option value="TEXT">TEXT</option>
                            </select>
                        </div>
                    </div>
                </template>
            </span>
            <br>
            <button type="button" class="btn btn-info" onclick="addField()">Aggiungi campo</button>
            <br><br>
            <button class="btn btn-primary" onclick="createTable()">Crea tabella</button>
        </form>

    </div>

    <script>
        var fields = [];
        let field = document.getElementsByTagName("template")[0];
        const fieldsContainer = document.getElementById("fields");

        function addField() {
            let newField = field.content.cloneNode(true);
            fieldsContainer.appendChild(newField);
            fields.push(newField);
        }

        function removeField(button) {
            button.parentElement.parentElement.parentElement.remove();
            fields.splice(fields.indexOf(button.parentElement.parentElement), 1);
        }

        addField();
    </script>
</body>

</html>
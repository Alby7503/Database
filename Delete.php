<?php
if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
    die("Metodo non valido");
}
$table = $_GET["table"] ?? null;
require_once "Utility.php";
checkTable($table);
$pk = getPrimaryKey($table);
$sql = "DELETE FROM $table WHERE $pk = ?";
$params = [$_GET['pk']];
$result = bindQuery($sql, $params);

<?php
require_once "Utility.php";
$table = $_GET["table"] ?? null;
$action = $_GET["action"] ?? null;
checkTable($table);
if (is_null($action) or empty($action)) {
    die("Azione non specificata");
}
switch ($action) {
    case 'add':
        echo '<iframe frameborder="0" src="Add.php?table=' . $table . '" width="100%" height="100%"></iframe>';
        break;
    case 'drop':
        $sql = "DROP TABLE $table";
        $result = query($sql);
        header("Location: index.php");
        break;
    default:
        break;
}
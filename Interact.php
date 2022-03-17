<?php
require_once "Utility.php";
$table = $_GET["table"] ?? null;
$action = $_GET["action"] ?? null;
if (is_null($table) or empty($table)) {
    die("Tabella non specificata");
}
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
        echo var_dump($result);
        header("Location: index.php");
        break;
    default:
        # code...
        break;
}
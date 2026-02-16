<?php
require_once "classes/Penumpang.php";
$penumpang = new Penumpang();
$penumpang->hapus($_GET['id']);
header("Location: index.php");
?>

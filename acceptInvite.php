<?php
session_start();
require_once 'src/connection.php';
require_once 'src/user.php';
$connection = new Connection();

if(isset($_GET['id'])) {
    $connection->acceptInvite($_GET['id']);

    header ('Location: album.php');
}

?>
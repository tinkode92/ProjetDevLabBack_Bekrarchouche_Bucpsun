<?php
if(isset($_GET['id'])) {
    require_once 'src/connection.php';
    $connection = new Connection();
    $connection->deleteMovie($_GET['id']);


    header ('Location: album.php');
}
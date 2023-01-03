<?php
if(isset($_GET['id'])) {
    require_once 'src/connection.php';
    $connection = new Connection();
    $connection->deleteAlbum($_GET['id']);


    header ('Location: album.php');
}
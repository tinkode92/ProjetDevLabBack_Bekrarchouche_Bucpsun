<?php
if(isset($_GET['id'])) {
    session_start();
    require_once 'src/user.php';
    require_once 'src/connection.php';
    $connection = new Connection();
    $connection->leaveAlbum($_GET['id']);


    header ('Location: album.php');
}
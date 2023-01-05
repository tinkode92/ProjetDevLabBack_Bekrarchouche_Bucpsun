<!DOCTYPE HTML>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="CSS/style.css">
    <title>Dywiki's connexion</title>
    
</head>
<body>

    <div class="flex fixed top-[50%] left-[50%] translate-y-[-50%] translate-x-[-50%]">
        <form class="flex flex-col p-4 place-content-center" method="post">
            <input type="email" class="p-1.5 border-gray-300 rounded-full bg-[#F3F3F3] my-2 drop-shadow-md" name="email" placeholder="Votre email">
            <input type="password" class="p-1.5 border-gray-300 rounded-full bg-[#F3F3F3] my-2 drop-shadow-md"  name="password" placeholder="Votre mot de passe">
            <p>Pas de compte ?<a class="text-[#7BC8FF] px-4" href="index.php">Inscrivez-vous</a></p>
            <button name="submit" type="submit" class="bg-[#F3F3F3] drop-shadow-md rounded-full p-1 mt-2">Connexion</button>
        </form>
    </div>

    <?php
    session_start();
    require_once 'src/connection.php';
    require_once 'src/user.php';
    $connection = new Connection();
    $connection->connect();
    ?>

</body>
</html>

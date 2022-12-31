<!DOCTYPE HTML>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="CSS/style.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dywiki's Inscription</title>

</head>
<body>

    <div class="flex">
        <form class="flex flex-col p-4 place-content-center" method="post">
            <input type="email" class="p-1.5 border-gray-300 rounded-full bg-[#F3F3F3] my-2 drop-shadow-md" name="email" placeholder="Votre email">
            <input type="password" class="p-1.5 border-gray-300 rounded-full bg-[#F3F3F3] my-2 drop-shadow-md"  name="password1" placeholder="Votre mot de passe">
            <input type="password" class="p-1.5 border-gray-300 rounded-full bg-[#F3F3F3] my-2 drop-shadow-md" name="password2" placeholder="Confirmer le mot de passe">
            <input type="text" class="p-1.5 border-gray-300 rounded-full bg-[#F3F3F3] my-2 drop-shadow-md" name="first_name" placeholder="Votre prénom">
            <input type="text" class="p-1.5 border-gray-300 rounded-full bg-[#F3F3F3] my-2 drop-shadow-md" name="last_name" placeholder="Votre nom">
            <p>Déjà inscrit ?<a class="text-[#7BC8FF] px-4" href="login.php">Connectez-vous</a></p>
            <button type="submit" class="bg-[#F3F3F3] drop-shadow-md rounded-full p-1 mt-2">Envoyer</button>
        </form>
    </div>

    <?php
    require_once 'src/connection.php';
    require_once 'src/user.php';


    if ($_POST) {
        $user = new User(
            $_POST['email'],
            $_POST['password1'],
            $_POST['password2'],
            $_POST['first_name'],
            $_POST['last_name'],
        );

        if ($user->verify()) {
            // save to database
            $connection = new Connection();
            $result = $connection->insert($user);


            if ($result) {
                echo '<h2 class="msg">Vous êtes inscrit !</h2>';
            } else {
                echo '<h2 class="msg">Erreur interne 🥲</h2>';
            }
        } else {
            echo '<h2 class="msg">Il manque des informations OU le mot passe confirmé est différent de celui entrer</h2>';
        }

        header('Refresh: 8, index.php');
        exit();

    }
    ?>

</body>
</html>

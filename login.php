<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dywiki's connexion</title>
</head>
<body>

<div class="flex">
    <form class="flex flex-col p-4 place-content-center" action="POST">
        <input type="email" class="p-1.5 border-gray-300 rounded-full bg-[#F3F3F3] my-2 drop-shadow-md" name="email" placeholder="Votre email">
        <input type="password" class="p-1.5 border-gray-300 rounded-full bg-[#F3F3F3] my-2 drop-shadow-md"  name="password1" placeholder="Votre mot de passe">
        <p>Pas de compte ?<a class="text-[#7BC8FF] px-4" href="index.php">Inscrivez-vous</a></p>
        <button type="submit" class="btn" value="Register">Connexion</button>
    </form>
</div>

</body>
</html>

<?php

class Connection
{
    public PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:dbname=dywiki;host=127.0.0.1', 'root');
    }

    public function insert(User $user): bool
    {
        $query = 'INSERT INTO user (email, password, first_name, last_name)
                  VALUES (:email, :password, :first_name, :last_name)';

        $statement = $this->pdo->prepare($query);

        return $statement->execute([
            'email' => $user->email,
            'password' => md5($user->password),
            'first_name' => $user->firstName,
            'last_name' => $user->lastName,
        ]);
    }

    public function connect()
    {

        $connection = new Connection();
        $bdd = $connection->pdo;
        if (isset($_POST['submit'])) {
            if ($_POST['email'] != "" || $_POST['password'] != "") {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $sql = "SELECT * FROM user WHERE email=? AND password=? ";
                $query = $bdd->prepare($sql);
                $query->execute(array($email, md5($password)));
                $row = $query->rowCount();
                $fetch = $query->fetch();
                if ($row > 0) {
                    $_SESSION['user_id'] = $fetch['id'];
                    $_SESSION['user_email'] = $fetch['email'];
                    $_SESSION['user_password'] = $fetch['password'];
                    $_SESSION['user_name'] = $fetch['first_name'];
                    $_SESSION['user_last_name'] = $fetch['last_name'];
                    header("location: home.php");
                } else {
                    echo '<h2 class="msg">Email ou mot de passe invalide</h2>';
                }
            } else {
                echo '<h2 class="msg">Veuillez entrer vos informations dans le champs ci-dessus</h2>';
            }
        }
    }
}

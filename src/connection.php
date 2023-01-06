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

    public function findUser(): array
    {
        $query = "SELECT * FROM user";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array());

        return $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function InsertAlbum(Album $album): bool
    {
        $query = 'INSERT INTO album (name, status, user_id)
                  VALUES (?, ?, ?)';

        $stmt = $this->pdo->prepare($query);

        return $stmt->execute([
            $album->name,
            $album->status,
            $_SESSION['user_id'],
        ]);
    }

    public function InsertMovie(Movie $movie): bool
    {
        $query = 'INSERT INTO album_movies (id_api, album_id)
                  VALUES (?, ?)';

        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            $movie->id_api,
            $movie->album_id,
        ]);
    }

    public function findAlbum($id): array
    {
        $query = "SELECT * FROM album WHERE user_id=?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array($id));

        return $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function invite($album_id, $user_mail): string | null
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(id) FROM album WHERE id=? AND user_id=?");
        $stmt->execute(array($album_id, $_SESSION["user_id"]));
        
        // l'utilisateur ne possède pas d'album avec cette id
        if ($stmt->rowCount() < 1) die("401 Non authorisé");

        $stmt = $this->pdo->prepare("SELECT id FROM user WHERE email=?");
        $stmt->execute(array($user_mail));

        $to_id = $stmt->fetchColumn(0);
        if (!$to_id) return null;

        $query = "INSERT INTO album_invites (from_id, to_id, album_id) VALUES (?, ?, ?)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array($_SESSION["user_id"], $to_id, $album_id));
        $id = $this->pdo->lastInsertId();

        return dirname($_SERVER['HTTP_REFERER']) . '/acceptInvite.php?id=' . $id;
    }


    public function acceptInvite($id)
    {
        $stmt = $this->pdo->prepare("SELECT album_id FROM album_invites WHERE id=? AND to_id=?");
        $stmt->execute(array($id, $_SESSION["user_id"]));
        $album_id = $stmt->fetchColumn(0);
        
        // invitation non destiné à l'utilisateur
        if (!$album_id) die("401 Non authorisé");

        $stmt = $this->pdo->prepare("INSERT INTO album_shares (user_id, album_id) VALUES (?, ?)");
        $stmt->execute(array($_SESSION["user_id"], $album_id));

        $stmt = $this->pdo->prepare("DELETE FROM album_invites WHERE id = ?");
        $stmt->execute(array($id));
    }

    public function deleteMovie(int $id): bool
    {
        $query = 'DELETE FROM album_movies
                  WHERE id = :id';
        $statement = $this->pdo->prepare($query);

        return $statement->execute([
            'id' => $id,
        ]);
    }

    public function deleteAlbum(int $id): bool
    {
        $query = 'DELETE FROM album_movies WHERE album_id = :id';
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'id' => $id,
        ]);

        $query = 'DELETE FROM album WHERE id = :id';
        $statement = $this->pdo->prepare($query);

        return $statement->execute([
            'id' => $id,
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
                    echo '<h2 class="flex justify-center">Email ou mot de passe invalide</h2>';
                    header("Refresh: 3");
                }
            } else {
                echo '<h2 class="flex justify-center">Veuillez entrer vos informations dans le champs ci-dessus</h2>';
                header("Refresh: 3");
            }
        }
    }
}

?>
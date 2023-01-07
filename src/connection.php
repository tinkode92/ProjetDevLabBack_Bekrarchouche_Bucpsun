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

        $defaultImage = "usser.png";

        $query = 'INSERT INTO user (email, password, first_name, last_name, img_profile)
                  VALUES (:email, :password, :first_name, :last_name, :img_profile)';

        $statement = $this->pdo->prepare($query);

        return $statement->execute([
            'email' => $user->email,
            'password' => md5($user->password),
            'first_name' => $user->firstName,
            'last_name' => $user->lastName,
            'img_profile' => $defaultImage,
        ]);
    }

    public function changeImg(int $userId, string $newImg): bool {

        $targetDir = "src/assets/img/";
        $targetFile = $targetDir . basename($newImg["name"]);

        if (move_uploaded_file($newImg["tmp_name"], $targetFile)) {

            $query = 'UPDATE user SET img_profile = :newImg WHERE id = :id';
            $statement = $this->pdo->prepare($query);


            return $statement->execute([
                'userId' => $userId,
                'newImg' => $targetFile,
            ]);
        } else {
            return false;
        }
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

    public function findAlbumMovie($id): array
    {
        $query = "SELECT * FROM album_movies WHERE album_id=?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array($id));

        return $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    $_SESSION['img'] = $fetch['img_profile'];
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
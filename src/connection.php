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

        $defaultImage = "src/assets/img/usser.png";

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

    public function changeImg(int $userId, array $newImg): bool
    {

        $targetDir = "src/assets/img/";
        $targetFile = str_replace(' ', '', $targetDir . basename($newImg["name"]));

        if (move_uploaded_file($newImg["tmp_name"], $targetFile)) {

            $query = 'UPDATE user SET img_profile = :img_profile WHERE id = :id';
            $statement = $this->pdo->prepare($query);
            return $statement->execute([
                ':id' => $userId,
                ':img_profile' => $targetFile,
            ]);
        } else {
            return false;
        }
    }

    public function getImg(int $userId)
    {
        $query = 'SELECT img_profile FROM user WHERE id = :id';
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':id', $userId, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            $fetch = $statement->fetch();
            return $fetch['img_profile'];
        }
        return null;
    }

    public function findUser(): array
    {
        $query = "SELECT * FROM user";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array());

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUser($id): array
    {
        $query = "SELECT * FROM user WHERE id = ?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array($id));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function AlbumLiked($user_id,$album_id): bool
    {
        $query = 'INSERT INTO album_liked (user_id, album_id)
                  VALUES (?, ?)';

        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            $user_id,
            $album_id,
        ]);
    }

    public function AlbumDisliked($user_id, $album_id): bool
    {
        $query = 'DELETE FROM album_liked WHERE user_id = ? AND album_id = ?';
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            $user_id,
            $album_id,
        ]);
    }

    public function findAlbumLiked($user_id) {
        $query = 'SELECT a.id, a.name, a.status, a.user_id FROM album_liked al 
                INNER JOIN album a ON al.album_id = a.id
                WHERE al.user_id = ?';

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }


    public function findAlbum($id): array
    {
        // sélectionner à la fois les albums possédés par l'utilisateurs et ceux chargés avec lui
        // https://fr.m.wikipedia.org/wiki/Fichier:SQL_Joins.svg
        $stmt = $this->pdo->prepare(
            "WITH S AS (SELECT *, 1 AS shared FROM album_shares) 
            SELECT A.*, S.shared FROM album A 
            LEFT JOIN S ON A.id = S.album_id 
            WHERE A.user_id = ? OR S.user_id = ?"
        );
        $stmt->execute(array($id, $id));

        return $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAlbumMovie($id): array
    {
        $query = "SELECT * FROM album_movies WHERE album_id=?";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array($id));

        return $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function invite($album_id, $user_mail): string|null
    {
        // verifier que l'album existe bien
        $stmt = $this->pdo->prepare("SELECT COUNT(id) FROM album WHERE id=? AND user_id=?");
        $stmt->execute(array($album_id, $_SESSION["user_id"]));

        // l'utilisateur ne possède pas d'album avec cette id
        if ($stmt->rowCount() < 1)
            die("401 Non authorisé");

        // chercher l'invité
        $stmt = $this->pdo->prepare("SELECT id FROM user WHERE email=?");
        $stmt->execute(array($user_mail));

        $to_id = $stmt->fetchColumn(0);
        if (!$to_id)
            return null;

        // creer l'invitation
        $query = "INSERT INTO album_invites (from_id, to_id, album_id) VALUES (?, ?, ?)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array($_SESSION["user_id"], $to_id, $album_id));
        $id = $this->pdo->lastInsertId();

        // former le lien d'invitation en fonction de l'url du serveur
        return dirname($_SERVER['HTTP_REFERER']) . '/acceptInvite.php?id=' . $id;
    }


    public function acceptInvite($id)
    {
        // vérifier que l'invitation existe bien
        $stmt = $this->pdo->prepare("SELECT album_id FROM album_invites WHERE id=? AND to_id=?");
        $stmt->execute(array($id, $_SESSION["user_id"]));
        $album_id = $stmt->fetchColumn(0);

        // invitation non destiné à l'utilisateur
        if (!$album_id)
            die("401 Non authorisé");

        // ajouter l'album dans les albums partagés
        $stmt = $this->pdo->prepare("INSERT INTO album_shares (user_id, album_id) VALUES (?, ?)");
        $stmt->execute(array($_SESSION["user_id"], $album_id));

        // supprimer l'invitation maintenant obsolète
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


    public function leaveAlbum(int $id): bool
    {
        $query = 'DELETE FROM album_shares WHERE album_id = ? AND user_id = ?';
        $statement = $this->pdo->prepare($query);
        return $statement->execute(array($id, $_SESSION['user_id']));
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
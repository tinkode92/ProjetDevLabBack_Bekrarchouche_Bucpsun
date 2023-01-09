<?php

class Connection
{
    public PDO $pdo;

    public function __construct()
    {
        // Création d'un objet PDO permettant de se connecter à la base de données 'dywiki'
        $this->pdo = new PDO('mysql:dbname=dywiki;host=127.0.0.1', 'root');
    }

    public function insert(User $user): bool
    {
        // Définition d'une image de base pour un nouveau profil
        $defaultImage = "src/assets/img/usser.png";

        // Définition de la requête SQL qui sera utilisée pour insérer l'album dans la base de données
        $query = 'INSERT INTO user (email, password, first_name, last_name, img_profile)
                  VALUES (:email, :password, :first_name, :last_name, :img_profile)';

        // Préparation de la requête
        $statement = $this->pdo->prepare($query);

        // Hashage du mot de passe de l'utilisateur en B_CRYPT
        $hashedPassword = password_hash($user->password, PASSWORD_BCRYPT);

        // Exécution de la requête en fournissant les valeurs à insérer dans la base de données
        return $statement->execute([
            'email' => $user->email,
            'password' => $hashedPassword,
            'first_name' => $user->firstName,
            'last_name' => $user->lastName,
            'img_profile' => $defaultImage,
        ]);
    }

    public function changeImg(int $userId, array $newImg): bool
    {
        // Définition du répertoire cible où sera déplacée l'image téléchargée
        $targetDir = "src/assets/img/";

        // Définition du nom de fichier cible en enlevant les espaces et en concaténant le répertoire cible
        // et le nom de fichier de l'image téléchargée
        $targetFile = str_replace(' ', '', $targetDir . basename($newImg["name"]));

        // Si le déplacement de l'image téléchargée vers le répertoire cible réussit
        if (move_uploaded_file($newImg["tmp_name"], $targetFile)) {
            // Définition de la requête SQL qui sera utilisée pour mettre à jour l'enregistrement de l'utilisateur dans la base de données
            $query = 'UPDATE user SET img_profile = :img_profile WHERE id = :id';

            // Préparation de la requête
            $statement = $this->pdo->prepare($query);

            // Exécution de la requête en fournissant les valeurs à mettre à jour
            return $statement->execute([
                ':id' => $userId,
                ':img_profile' => $targetFile,
            ]);
        } else {
            // Si le déplacement de l'image téléchargée échoue, on renvoie false
            return false;
        }
    }

    public function getImg(int $userId)
    {
        // Définition de la requête SQL qui sera utilisée pour récupérer l'image de profil de l'utilisateur
        $query = 'SELECT img_profile FROM user WHERE id = :id';

        // Préparation de la requête
        $statement = $this->pdo->prepare($query);

        // Liaison de la valeur de l'ID de l'utilisateur à la requête préparée
        $statement->bindParam(':id', $userId, PDO::PARAM_INT);

        // Exécution de la requête
        $statement->execute();

        // Si au moins une ligne a été retournée par la requête
        if ($statement->rowCount() > 0) {

            // Récupération du premier résultat de la requête sous forme de tableau associatif
            $fetch = $statement->fetch();

            // Renvoi de la valeur de l'image de profil
            return $fetch['img_profile'];
        }
        // Si aucune ligne n'a été retournée par la requête, on renvoie null
        return null;
    }

    public function findUser(): array
    {
        // Définition de la requête SQL qui sera utilisée pour récupérer tous les enregistrements de la table 'user'
        $query = "SELECT * FROM user";

        // Préparation de la requête
        $stmt = $this->pdo->prepare($query);

        // Exécution de la requête
        $stmt->execute(array());

        // Récupération de tous les résultats de la requête sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUser($id): array
    {
        // Définition de la requête SQL qui sera utilisée pour récupérer l'enregistrement de la table 'user' correspondant à l'ID fourni en paramètre
        $query = "SELECT * FROM user WHERE id = ?";

        // Préparation de la requête
        $stmt = $this->pdo->prepare($query);

        // Exécution de la requête en fournissant la valeur de l'ID
        $stmt->execute(array($id));

        // Récupération de tous les résultats de la requête sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function InsertAlbum(Album $album): bool
    {

        // Définition de la requête SQL qui sera utilisée pour insérer l'album dans la base de données
        $query = 'INSERT INTO album (name, status, user_id)
                  VALUES (?, ?, ?)';

        // Préparation de la requête
        $stmt = $this->pdo->prepare($query);

        // Exécution de la requête en fournissant les valeurs à insérer dans la base de données
        return $stmt->execute([
            $album->name,
            $album->status,
            $_SESSION['user_id'],
        ]);
    }

    public function InsertMovie(Movie $movie): bool
    {
        // Définition de la requête SQL qui sera utilisée pour insérer le film dans la base de données
        $query = 'INSERT INTO album_movies (id_api, album_id)
                  VALUES (?, ?)';

        // Préparation de la requête
        $stmt = $this->pdo->prepare($query);

        // Exécution de la requête en fournissant les valeurs à insérer dans la base de données
        return $stmt->execute([
            $movie->id_api,
            $movie->album_id,
        ]);
    }

    public function AlbumLiked($user_id, $album_id): bool
    {
        // Définition de la requête SQL qui sera utilisée pour ajouter l'album aux albums likés
        // d'un utilisateur (ou nous même) dans la base de données
        $query = 'INSERT INTO album_liked (user_id, album_id)
                  VALUES (?, ?)';

        // Préparation de la requête
        $stmt = $this->pdo->prepare($query);

        // Exécution de la requête en fournissant les valeurs à insérer dans la base de données
        return $stmt->execute([
            $user_id,
            $album_id,
        ]);
    }

    public function AlbumDisliked($user_id, $album_id): bool
    {

        // Définition de la requête SQL qui sera utilisée pour supprimer l'album qu'on a liké
        // d'un utilisateur (ou nous même) dans la base de données
        $query = 'DELETE FROM album_liked WHERE user_id = ? AND album_id = ?';

        // Préparation de la requête
        $stmt = $this->pdo->prepare($query);

        // Exécution de la requête en fournissant les valeurs de l'ID de l'utilisateur et de l'album
        return $stmt->execute([
            $user_id,
            $album_id,
        ]);
    }

    public function findAlbumLiked($user_id)
    {

        // Définition de la requête SQL qui sera utilisée pour récupérer les albums likés de l'utilisateur dans la base de données
        $query = 'SELECT a.id, a.name, a.status, a.user_id FROM album_liked al 
                INNER JOIN album a ON al.album_id = a.id
                WHERE al.user_id = ?';

        // Préparation de la requête
        $stmt = $this->pdo->prepare($query);

        // Exécution de la requête en fournissant l'ID de l'utilisateur
        $stmt->execute([$user_id]);

        // Récupération et retour des résultats de la requête;
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
        // Préparation de la requête
        $stmt->execute(array($id, $id));

        // Récupération de tous les résultats de la requête sous forme de tableau associatif
        return $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAlbumMovie($id): array
    {

        // Définition de la requête SQL qui sera utilisée pour récupérer les films d'un album dans la base de données
        $query = "SELECT * FROM album_movies WHERE album_id=?";

        // Préparation de la requête
        $stmt = $this->pdo->prepare($query);

        // Exécution de la requête en fournissant l'ID de l'album
        $stmt->execute(array($id));

        // Récupération et retour des résultats de la requête sous forme de tableau associatif
        return $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function invite($album_id, $user_mail): string|null
    {
        // Vérifier que l'album existe bien et qu'il appartient bien à l'utilisateur connecté
        $stmt = $this->pdo->prepare("SELECT COUNT(id) FROM album WHERE id=? AND user_id=?");
        $stmt->execute(array($album_id, $_SESSION["user_id"]));

        // Si l'utilisateur ne possède pas d'album avec cette ID, on affiche une erreur
        if ($stmt->rowCount() < 1)
            die("401 Non authorisé");

        // Récupérer l'ID de l'utilisateur à qui on veut envoyer une invitation
        $stmt = $this->pdo->prepare("SELECT id FROM user WHERE email=?");
        $stmt->execute(array($user_mail));

        // Récupération de l'ID de l'utilisateur
        $to_id = $stmt->fetchColumn(0);

        // Si l'utilisateur n'existe pas, on renvoie null
        if (!$to_id)
            return null;

        // Création de l'invitation en enregistrant l'ID de l'utilisateur qui envoie l'invitation,
        // l'ID de l'utilisateur qui reçoit l'invitation et l'ID de l'album associé à l'invitation
        $query = "INSERT INTO album_invites (from_id, to_id, album_id) VALUES (?, ?, ?)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array($_SESSION["user_id"], $to_id, $album_id));
        // Récupération de l'ID de l'invitation qui vient d'être créée
        $id = $this->pdo->lastInsertId();

        // Formation du lien d'invitation en fonction de l'URL du serveur et renvoi du lien
        return dirname($_SERVER['HTTP_REFERER']) . '/acceptInvite.php?id=' . $id;
    }


    public function acceptInvite($id)
    {
        // Vérifier que l'invitation existe bien et qu'elle est bien destinée à l'utilisateur connecté
        $stmt = $this->pdo->prepare("SELECT album_id FROM album_invites WHERE id=? AND to_id=?");
        $stmt->execute(array($id, $_SESSION["user_id"]));
        // Récupération de l'ID de l'album associé à l'invitation
        $album_id = $stmt->fetchColumn(0);

        // Si l'invitation n'est pas destinée à l'utilisateur, on affiche une erreur
        if (!$album_id)
            die("401 Non authorisé");

        // Ajout de l'album dans la liste des albums partagés de l'utilisateur
        $stmt = $this->pdo->prepare("INSERT INTO album_shares (user_id, album_id) VALUES (?, ?)");
        $stmt->execute(array($_SESSION["user_id"], $album_id));

        // Suppression de l'invitation maintenant obsolète
        $stmt = $this->pdo->prepare("DELETE FROM album_invites WHERE id = ?");
        $stmt->execute(array($id));
    }

    public function deleteMovie(int $id): bool
    {
        // Création de la requête permettant de supprimer un film dans la table album_movies
        $query = 'DELETE FROM album_movies
                  WHERE id = :id';

        // Préparation de la requête
        $statement = $this->pdo->prepare($query);

        // Exécution de la requête et renvoi du résultat
        return $statement->execute([
            'id' => $id,
        ]);
    }


    // Cette fonction permet de supprimer dans un premier temps tout les films d'un album et d'ensuite supprimer l'album
    // afin de ne pas causer d'erreur SQL lié au FOREIGN KEY
    public function deleteAlbum(int $id): bool
    {

        // Création de la requête permettant de supprimer les films d'un album dans la table album_movies
        $query = 'DELETE FROM album_movies WHERE album_id = :id';

        // Préparation de la requête
        $statement = $this->pdo->prepare($query);

        // Exécution de la requête avec l'ID de l'album en paramètre
        $statement->execute([
            'id' => $id,
        ]);

        // Création de la requête permettant de supprimer un album dans la table album
        $query = 'DELETE FROM album WHERE id = :id';

        // Préparation de la requête
        $statement = $this->pdo->prepare($query);

        // Exécution de la requête avec l'ID de l'album en paramètre et renvoi du résultat
        return $statement->execute([
            'id' => $id,
        ]);
    }


    // Elle permet de quitter un album où nous avons été inviter et dont nous avons accepté l'invitation au préalable
    public function leaveAlbum(int $id): bool
    {

        // Création de la requête permettant de supprimer un album des albums partagés d'un utilisateur
        $query = 'DELETE FROM album_shares WHERE album_id = ? AND user_id = ?';

        // Préparation de la requête
        $statement = $this->pdo->prepare($query);

        // Exécution de la requête avec l'ID de l'album et l'ID de l'utilisateur en paramètre et renvoi du résultat
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
                $sql = "SELECT * FROM user WHERE email=?";
                $query = $bdd->prepare($sql);
                $query->execute([$email]);
                $row = $query->rowCount();
                $fetch = $query->fetch();
                if ($row > 0 && password_verify($password, $fetch['password'])) {
                    $_SESSION['user_id'] = $fetch['id'];
                    $_SESSION['user_email'] = $fetch['email'];
                    $_SESSION['user_password'] = $fetch['password'];
                    $_SESSION['user_name'] = $fetch['first_name'];
                    $_SESSION['user_last_name'] = $fetch['last_name'];
                    $_SESSION['img'] = $fetch['img_profile'];
                    header("location: home.php");
                } else {
                    echo '<h2 class="flex justify-center font-semibold text-xl mt-4 text-[#fefae0] mt-[275px]">Email ou mot de passe invalide</h2>';
                    header("Refresh: 3");
                }
            } else {
                echo '<h2 class="flex justify-center font-semibold text-xl mt-4 text-[#fefae0] mt-[275px]">Veuillez entrer vos informations dans le champs ci-dessus</h2>';
                header("Refresh: 3");
            }
        }
    }
}

?>
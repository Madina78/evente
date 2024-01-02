<?php
session_start();

// Informations de connexion à la base de données
$host = "localhost:3309";
$user = "root";
$mdp = "";
$bdd = "evente";

try {
    // Connexion à la base de données avec PDO
    $connexion = new PDO("mysql:host=$host;dbname=$bdd", $user, $mdp);

    // Définir le mode d'erreur PDO à exception
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les données de la requête POST
    $email = $_GET['email'];
    $password = $_GET['password'];
    $nom = $_GET['nom'];
    $prenom = $_GET['prenom'];

    // Vérifier si l'utilisateur existe déjà
    $sqlCheckUser = "SELECT COUNT(*) AS count FROM user WHERE email = :email";
    $requeteCheckUser = $connexion->prepare($sqlCheckUser);
    $requeteCheckUser->bindParam(':email', $email);
    $requeteCheckUser->execute();
    $result = $requeteCheckUser->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        // L'utilisateur existe déjà, rediriger vers la page de connexion avec un message
        echo json_encode(["status" => 1, "message" => "Vous avez déjà un compte"]);
    } else {
        // L'utilisateur n'existe pas, procéder à l'insertion
        $sqlInsertUser = "INSERT INTO user (nom, prenom, email, password) VALUES (:nom, :prenom, :email, :password)";
        $requeteInsertUser = $connexion->prepare($sqlInsertUser);
        $requeteInsertUser->bindParam(':nom', $nom);
        $requeteInsertUser->bindParam(':prenom', $prenom);
        $requeteInsertUser->bindParam(':email', $email);
        $requeteInsertUser->bindParam(':password', $password);

        // Exécuter la requête d'insertion
        $requeteInsertUser->execute();

        // Récupérer l'ID de l'utilisateur nouvellement inscrit
        $idClient = $connexion->lastInsertId();

        // Mettre à jour la session avec l'ID de l'utilisateur
        $_SESSION['user_id'] = $idClient;

        // Rediriger vers la page Clhome.html
        echo json_encode(["status" => 2, "message" => "Inscription réussie"]);
    }
} catch (PDOException $e) {
    // En cas d'erreur, retourner un message d'erreur
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    // Fermer la connexion à la base de données
    $connexion = null;
}
?>

<?php
session_start()
// log.php

// Récupérer les données de la requête POST
$nom = isset($_POST['nom']) ? $_POST['nom'] : '';
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';


// Informations de connexion à la base de données
$host = "localhost:3309"; // Adresse du serveur de la base de données
$user = "root"; // Nom d'utilisateur de la base de données
$mdp = ""; // Mot de passe de la base de données
$bdd = "evente"; // Nom de la base de données

try {
    // Connexion à la base de données avec PDO
    $connexion = new PDO("mysql:host=$host;dbname=$bdd", $user, $mdp);

    // Définir le mode d'erreur PDO à exception
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparer la requête SQL d'insertion avec des paramètres
    $sql = "INSERT INTO user (nom, prenom, email, password) VALUES (:nom, :prenom, :email, :password)";
    $requete = $connexion->prepare($sql);

    // Liaison des paramètres
    $requete->bindParam(':nom', $nom);
    $requete->bindParam(':prenom', $prenom);
    $requete->bindParam(':email', $email);
    $requete->bindParam(':password', $password);

    // Exécuter la requête
    $requete->execute();

    // Redirection vers la page niceadmin/index.html
    header("Location: Niceadmin/index.html");
    exit(); // Assurez-vous de terminer le script après la redirection
} catch (PDOException $e) {
    echo "Erreur lors de l'insertion des données : " . $e->getMessage();
}

// Fermer la connexion à la base de données
$connexion = null;
?>

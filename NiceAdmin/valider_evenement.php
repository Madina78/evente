<?php
// valider_evenement.php

// Récupérer l'ID de l'événement depuis la requête GET
$eventId = isset($_GET['event_id']) ? $_GET['event_id'] : null;

if ($eventId !== null) {
    // Mettre à jour la base de données pour définir la colonne "auto" à 1
    // Vous devez remplacer les informations de connexion et la requête SQL avec les vôtres
    $host = "localhost:3309";
    $user = "root";
    $mdp = "";
    $bdd = "evente";

    try {
        $connexion = new PDO("mysql:host=$host;dbname=$bdd", $user, $mdp);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Mettre à jour la colonne "auto" à 1 pour l'événement spécifié
        $requete = $connexion->prepare("UPDATE event SET auto = 1 WHERE id = :eventId");
        $requete->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        $requete->execute();

        // Renvoyer la nouvelle valeur de la colonne "auto"
        $response = array('newAutoStatus' => 1);
        echo json_encode($response);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    } finally {
        $connexion = null;
    }
} else {
    // Gérer l'erreur si l'ID de l'événement n'est pas fourni
    echo "Erreur : ID de l'événement non spécifié.";
}
?>

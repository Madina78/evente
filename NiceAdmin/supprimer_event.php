<?php
// Vérifier si l'ID de l'événement à supprimer est présent dans la requête POST
if (isset($_POST['event_id'])) {
    // Récupérer l'ID de l'événement à supprimer
    $eventId = $_POST['event_id'];

    // Connexion à la base de données
    $host = "localhost:3309";
    $user = "root";
    $mdp = "";
    $bdd = "evente";

    try {
        $connexion = new PDO("mysql:host=$host;dbname=$bdd", $user, $mdp);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer la requête de suppression
        $requete = $connexion->prepare("DELETE FROM event WHERE id = :eventId");
        $requete->bindParam(':eventId', $eventId, PDO::PARAM_INT);

        // Exécuter la requête
        $requete->execute();

        // Rediriger vers la page actuelle ou une autre page si nécessaire
        header("Location: listeevn.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    } finally {
        $connexion = null;
    }
}
?>

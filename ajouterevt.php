<?php
// Assurez-vous que le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer les données du formulaire
    $nom_evenement = $_POST['nom_evenement'];
    $categorie = $_POST['categorie'];
    $dateDebut = $_POST['date_debut'];
    $heureDebut = $_POST['heure_debut'];
    $lieu = $_POST['lieu'];

    // Traiter le fichier image s'il est téléchargé
    $imageFileName = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageFileName = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imageFileName);
    }

    // Connexion à la base de données
    $host = "localhost:3309"; // Adresse du serveur MySQL
    $user = "root"; // Nom d'utilisateur MySQL
    $mdp = ""; // Mot de passe MySQL
    $bdd = "evente"; // Nom de la base de données

    try {
        // Connexion à la base de données avec PDO
        $connexion = new PDO("mysql:host=$host;dbname=$bdd", $user, $mdp);

        // Définir le mode d'erreur PDO à exception
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       // Préparer la requête d'insertion
$sql = "INSERT INTO event (nomev, categorie, date, heure, lieux, image) 
VALUES (:nnom_evenement, :categorie, :dateDebut, :heureDebut, :lieu, :image)";
$requete = $connexion->prepare($sql);

// Liaison des paramètres
$requete->bindParam(':nom_evenement', $nomEvenement);
$requete->bindParam(':categorie', $categorie);
$requete->bindParam(':dateDebut', $dateDebut);
$requete->bindParam(':heureDebut', $heureDebut);
$requete->bindParam(':lieu', $lieu);
$requete->bindParam(':image', $imageFileName);

        // Exécution de la requête
        $requete->execute();

        // Redirection vers une page de confirmation ou autre
        header("Location: previsualiser.php");
        exit();
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message d'erreur
        echo "Erreur : " . $e->getMessage();
    } finally {
        // Fermer la connexion à la base de données
        $connexion = null;
    }
}
?>

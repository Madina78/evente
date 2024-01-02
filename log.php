<?php
$hostname = 'localhost:3309';
$database = 'evente';
$username = 'root';
$password = '';

error_log('Début du script log.php', 0);

// Assurez-vous que la session est démarrée
session_start();

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des données du formulaire
    $email = $_GET['email'];
    $password = $_GET['password'];

    // Préparation de la requête SQL avec des paramètres liés
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);

    // Exécution de la requête
    $stmt->execute();

    // Récupération du résultat
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Si l'utilisateur est trouvé
        if ($user['email'] == 'dinaguemach@gmail.com') {
            if ($user['password'] == $password) {
                // Mettez à jour la session avec l'ID de l'utilisateur
                $_SESSION['user_id'] = $user['id_client'];
                echo json_encode(["status" => 1]); // Utilisateur trouvé avec le bon email et mot de passe
            } else {
                echo json_encode(["status" => 4]); // Utilisateur trouvé, mais le mot de passe ne correspond pas
            }
        } else {
            if ($user['password'] == $password) {
                // Mettez à jour la session avec l'ID de l'utilisateur
                $_SESSION['user_id'] = $user['id_client'];
                echo json_encode(["status" => 2]); // Utilisateur trouvé avec un autre email, mais le mot de passe ne correspond pas
            } else {
                echo json_encode(["status" => 5]); // Utilisateur trouvé, mais l'email et le mot de passe ne correspondent pas
            }
        }
    } else {
        echo json_encode(["status" => 3]); // Utilisateur non trouvé
    }

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>

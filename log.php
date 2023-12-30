<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$hostname = 'localhost:3309';  // Nom de l'hôte MySQL (peut-être 'localhost' seul)
$database = 'evente';
$username = 'root';
$password = '';

error_log('Début du script log.php', 0);

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Paramètres de test pour email et mot de passe
    $email = 'dinaguemach@gmail.com';
    $password = '1234';

    // Préparation de la requête SQL avec des paramètres liés
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email AND password = :password");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    // Exécution de la requête
    $stmt->execute();
   // Récupération du résultat
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        // Si l'utilisateur est trouvé avec l'email correct, redirige vers NiceAdmin/index.html
        if ($user['email'] == 'dinaguemach@gmail.com') {
            echo "Avant la redirection";
            error_log('Avant la redirection', 0);
            header("Location: http://localhost/Evente/NiceAdmin/index.html");
            exit(); // Assurez-vous de terminer le script après la redirection
        } else {
            // Si l'email ne correspond pas, redirige vers clhome.html
            header("Location: http://localhost/Evente/Clhome.html");
            exit(); // Assurez-vous de terminer le script après la redirection
        }
    } else {
        // Si l'utilisateur n'est pas trouvé, redirige vers signup.html avec un message
        header("Location: signup.html?message=Veuillez vous inscrire");
        exit(); // Assurez-vous de terminer le script après la redirection
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

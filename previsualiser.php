<?php
// Démarrer la session
session_start();

// Connexion à la base de données
$host = "localhost:3309"; // Adresse du serveur MySQL
$user = "root"; // Nom d'utilisateur MySQL
$mdp = ""; // Mot de passe MySQL
$bdd = "evente"; // Nom de la base de données

try {
    $connexion = new PDO("mysql:host=$host;dbname=$bdd", $user, $mdp);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération de l'identifiant du client à partir de la session
    $userId = $_SESSION['user_id'];

    // Récupération des données de la table event pour l'utilisateur actuel avec autorisation = 0
    $requete = $connexion->prepare("SELECT * FROM event WHERE id_client = :userId AND auto = 0");
    $requete->bindParam(':userId', $userId);
    $requete->execute();
    $events = $requete->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
} finally {
    $connexion = null;
}
?>
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Evente</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <style>

/* Ajout de styles pour gérer la disposition des cartes */
.card-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  transition: 0.3s;
  width: calc(25% - 20px); /* Ajuste la largeur en fonction du pourcentage */
  margin: 10px;
  box-sizing: border-box;
  border-radius: 10px;
}

.card img {
  width: 100%;
  height: auto;
  border-radius: 10px 10px 0 0;
}

.container2 {
  padding: 10px;
}

button {
  cursor: pointer;
  padding: 5px 10px;
  border: none;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #ddd;
}


/* Style de la petite photo de profil */
.profile-link img.profile-img {
  width: 30px; /* Ajustez la taille souhaitée */
  height: 30px;
  border-radius: 50%;
  margin-right: 10px; /* Ajoute une marge à droite du nom pour l'espace */
}

/* Styliser le lien du profil */
.profile-link {
  display: flex;
  align-items: center;
}

/* Styliser le nom à côté de la photo de profil */
.profile-link span {
  margin-right: 5px;
}

/* Styliser le dropdown */
.dropdown ul {
  display: none;
  /* Autres styles pour le dropdown... */
}

/* Afficher le dropdown au survol du lien du profil */
.dropdown:hover ul {
  display: block;
}

</style>


  <!-- Favicons -->
 
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="Clhome.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: MeFamily
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/family-multipurpose-html-bootstrap-template-free/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

</head>

	
<body>
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="index.html">Evente</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
    <ul>
        <li><a class="active" href="Clhome.php">Home</a></li>
        <li><a href="ajouter-even.html">Ajouter un Evenment</a></li>
        <li><a href="contact.html">Contact</a></li>
        <li class="dropdown">
            <a href="#" class="profile-link">
                <img src="profile-img.jpg" alt="Profile Photo" class="profile-img">
                <?php
                try {
                    $connexion = new PDO("mysql:host=$host;dbname=$bdd", $user, $mdp);
                    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Requête pour récupérer le prénom de l'utilisateur à partir de l'ID
                    $requete = $connexion->prepare("SELECT prenom FROM user WHERE id_client = :userId");
                    $requete->bindParam(':userId', $userId, PDO::PARAM_INT);
                    $requete->execute();

                    // Récupération du prénom
                    $resultat = $requete->fetch(PDO::FETCH_ASSOC);
                    $prenomUtilisateur = $resultat['prenom'];

                    // Définir la variable de session avec le prénom de l'utilisateur
                    $_SESSION['prenom'] = $prenomUtilisateur;

                    echo '<span>' . $_SESSION['prenom'] . '</span>';
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                } finally {
                    $connexion = null;
                }
                ?>
                <i class="bi bi-chevron-down"></i>
            </a>
            <ul>
                <li><a href="#">My Profile</a></li>
                <li><a href="#">Account sitting</a></li>
                <li><a href="#">Need help?</a></li>
                <li><a href="index.html">Sign out</a></li>
            </ul>
        </li>
    </ul>
    <i class="bi bi-list mobile-nav-toggle"></i>
</nav><!-- .navbar -->


    </div>
  </header><!-- End Header -->
  <br>
  <br>
  <br>
  <br>
  
      <div class="card-container">
  
   
         <?php
        // Affichage des cartes avec les données récupérées
        foreach ($events as $event) {
       
            echo '<div class="card">';
            echo '<img src="' . $event['image'] . '"  alt="Image de l\'événement"  " class="card-img">';
            echo '<div class="container2">';
            echo '<h4><b>' . $event['nomev'] . '</b></h4>';
            echo '<a href="details.php?id=' . $event['id'] . '"><button>Détails</button></a>';
            echo '</div>';
            echo '</div>';
        }
        ?>
        </div>
   
 


  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <h3>Evente</h3>
  
      <p>Evente - L'expertise pour tous vos événements, publics et professionnels</p>
      <div class="social-links">
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>

      <div class="copyright">
        &copy; Copyright <strong><span>Evente</span></strong>. All Rights Reserved
      </div>
   
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/family-multipurpose-html-bootstrap-template-free/ -->
        Designed by Esst
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
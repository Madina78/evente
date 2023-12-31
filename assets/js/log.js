// Attendez que le document soit prêt avant d'exécuter le code
$(document).ready(function() {

  // Fonction qui sera appelée lors de la soumission du formulaire
  function submitForm() {
    // Récupérer les valeurs de l'email et du mot de passe depuis les champs de formulaire
    var email = $("#email").val();
    var password = $("#password").val();

    // Effectuer une requête AJAX vers le fichier log.php
    $.ajax({
      url: 'log.php', // URL de la requête
      type: 'GET', // Type de requête (GET dans ce cas)
      data: {
        email: email,
        password: password
      }, // Données à envoyer avec la requête
      dataType: 'json', // Indiquez que vous attendez une réponse JSON
      success: function(data) {
        // Fonction exécutée en cas de succès de la requête AJAX

        if (data.status === 1) {
          // Utilisateur trouvé avec le bon email et mot de passe, redirection vers NiceAdmin/index.html
          window.location.href = 'http://localhost/Evente/NiceAdmin/index.html';
        } else if (data.status === 2) {
          // Utilisateur trouvé, mais l'email et le mot de passe ne correspondent pas, redirection vers Clhome.html
          window.location.href = 'http://localhost/Evente/Clhome.php';
        } else if (data.status === 3) {
          // Utilisateur non trouvé, redirection vers signup.html
          window.location.href = 'http://localhost/Evente/signup.html?message=Veuillez vous inscrire';
        } else if (data.status === 4) {
          // Utilisateur trouvé avec le bon email, mais le mot de passe ne correspond pas
         var errorMessage = "Mot de passe incorrect pour l'utilisateur dinaguemach@gmail.com";
          console.log(errorMessage); 
          addErrorMessage(errorMessage);
        } else if (data.status === 5) {
          // Utilisateur trouvé avec un autre email, mais le mot de passe ne correspond pas
          var errorMessage = "votre Mot de passe est incorrect ";
          console.log(errorMessage);
          addErrorMessage(errorMessage);
        }
      },
      error: function(error) {
        // Fonction exécutée en cas d'erreur de la requête AJAX
        $("#addInServer").html('AJAX Error: ' + error.responseText);
      }
    });
  }

  // Fonction pour ajouter un message d'erreur à la fin du formulaire
  function addErrorMessage(message) {
    // Créez un élément de paragraphe pour afficher le message d'erreur
    var errorElement = $("<p>").text(message).css("color", "red");

    // Ajoutez cet élément à la fin de votre formulaire
    $("#main form").append(errorElement);
  }

  // Définir le gestionnaire d'événements pour la soumission du formulaire
  $("#main form").submit(function(event) {
    event.preventDefault(); // Empêcher le comportement par défaut du formulaire
    // Avant chaque soumission, retirez les messages d'erreur précédents
    $("#main form p").remove();
    // Appeler la fonction pour soumettre le formulaire
    submitForm();
  });
});
$(document).ready(function () {
    $("#inscrire").click(function () {
        // Récupérer les valeurs des champs du formulaire
        var nom = $("#nom").val();
        var prenom = $("#prenom").val();
        var email = $("#email").val();
        var password = $("#password").val();

        // Valider les données du formulaire
        if (!validateForm(nom, prenom, email, password)) {
            // Si la validation échoue, afficher un message d'erreur
            return;
        }

        // Envoyer les données à sign.php via Ajax
        var formData = {
            nom: nom,
            prenom: prenom,
            email: email,
            password: password,
        };

        $.ajax({
            url: 'sign.php',
            type: 'GET',
            data: formData,
            dataType: 'json',
            success: function (data) {
                if (data.status === 1) {
                    // Utilisateur existe déjà, rediriger vers log.html avec un message
                    alert(data.message);
                    window.location.href = 'http://localhost/Evente/login.html';
                } else if (data.status === 2) {
                    // Utilisateur ajouté avec succès, rediriger vers Clhome.html
                    alert(data.message);
                    window.location.href = 'http://localhost/Evente/Clhome.php';
                } else if (data.status === "error") {
                    // Une erreur s'est produite, afficher le message d'erreur
                    alert(data.message);
                }
            },
            error: function (error) {
                console.error("Error sending data. Status:", error.status);
            }
        });
    });

    function validateForm(nom, prenom, email, password) {
        // Initialiser un tableau pour stocker les messages d'erreur
        var errorMessages = [];
    
        // Vérifier si tous les champs sont remplis
        if (nom === "" || prenom === "" || email === "" || password === "") {
            errorMessages.push("Tous les champs doivent être remplis.");
        }
    
       // Valider le format de l'email
       var emailRegex = new RegExp(/^[a-zA-Z]+[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/);
      if (!emailRegex.test(email)) {
       errorMessages.push("Le format de l'email est incorrect.");
       }

    
        // Valider que le nom et le prénom contiennent uniquement des caractères alphabétiques
        var nameRegex = /^[a-zA-Z]+$/;
        if (!nameRegex.test(nom) || !nameRegex.test(prenom)) {
            errorMessages.push("Le nom et le prénom doivent contenir uniquement des caractères alphabétiques.");
        }
    
        // Valider que le mot de passe a au moins 8 caractères alphanumériques
        var passwordRegex = /^(?=.*[a-zA-Z0-9]).{8,}$/;
        if (!passwordRegex.test(password)) {
            errorMessages.push("Le mot de passe doit avoir au moins 8 caractères alphanumériques.");
        }
    
        // Si des messages d'erreur existent, les afficher et renvoyer false
        if (errorMessages.length > 0) {
            addErrorMessage(errorMessages.join("<br>"));
            return false;
        }
    
        // Toutes les validations réussies
        return true;
    }

    // Fonction pour ajouter un message d'erreur à la fin du formulaire
    function addErrorMessage(message) {
        // Créez un élément de paragraphe pour afficher le message d'erreur
        var errorElement = $("<p>").html(message).css("color", "red");

        // Ajoutez cet élément à la fin de votre formulaire
        $("#main form").append(errorElement);
    }
});

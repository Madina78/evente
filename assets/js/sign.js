function submitForm() {
    console.log("You clicked on the button");

    // Obtenir les données du formulaire
    var formData = {
        nom: document.getElementById("nom").value,
       prenom: document.getElementById("prenom").value,
        email: document.getElementById("email").value,
        password: document.getElementById("password").value,
        dataType: "json",
    };

    // Envoyer les données à sign.php via Ajax
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "log.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    // Convertir formData en chaîne JSON
    var jsonData = JSON.stringify(formData);

    // Envoyer la requête
    xhr.send(jsonData);
}

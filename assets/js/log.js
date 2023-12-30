$(document).ready(function() {
  var insert = 0;

  function submitForm() {
    var email = $("#email").val();
    var password = $("#password").val();

    $.ajax({
      url: 'log.php',
      type: 'POST',
      data: {
        email: email,
        password: password
      },
      success: function(data) {
        insert++;
        $('#addInServer').html(data + "<br>" + insert + " Data inserted");
      },
      error: function(error) {
        $("#addInServer").html('AJAX Error: ' + error.responseText);
      }
    });
  }

  $("form").submit(function(event) {
    event.preventDefault();
    submitForm();
  });
});

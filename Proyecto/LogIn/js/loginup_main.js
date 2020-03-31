$( document ).ready(function() {

    $("#contactForm").submit(function(e) {
        e.preventDefault();
    });

    //al premer forgot password
    $(".xforgot").on("click", function(data){

        var xname = $('.xname').val();

        $.post("../php/forgotpwd.php", {email: xname}, function(data){

            
        });

        Swal.fire(
            'Forgot Password',
            'Si la compte existeix, s\'enviara un email de restabliment',
            'info'
          );
    })
});

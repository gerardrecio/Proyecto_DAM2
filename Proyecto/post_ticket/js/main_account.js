$(document).ready(function(){


    $(".xcanviar_password").on("click", 
      function(e){
        e.preventDefault();

        var password = $(".xpassword").val();
        var password2 = $(".xpassword2").val();
        var nom_email = $(".xcontact_info")[0].textContent;  //per obtenir el nom

        if (password != password2)
        {
          Swal.fire({
            icon: 'error',
            title: 'Canviar Contrasenya',
            text: 'Les contrasenyes no coincideixen'
          });
        }
        else
        {
            $.post("php/canviar_pwd.php", {pwd: password, email: nom_email}, 
          
            function(data){

              console.log(data);

              if (data == 1)
              {
                  Swal.fire({
                    icon: 'success',
                    title: 'Canviar Contrasenya',
                    text: 'Contrasenya canviada exitosament'
                  });
                  setTimeout(marxarCorrecte, 1500);
              }
            });
        }
      }
    );

    function marxarCorrecte(){
      location.href = "php/logout.php";
    }
});
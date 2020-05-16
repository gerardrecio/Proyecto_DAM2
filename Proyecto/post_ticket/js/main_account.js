$(document).ready(function(){


    $(".xcanviar_password").on("click", 
      function(e){
        e.preventDefault();

        var password_old = $(".xpassword_old").val();
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
            $.post("php/canviar_pwd.php", {pwd_old: password_old, pwd: password, email: nom_email}, 
          
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
              else
              {
                Swal.fire({
                  icon: 'error',
                  title: 'Canviar Contrasenya',
                  text: 'La contrasenya no s\'ha pogut canviar'
                });
              }
            });
        }
      }
    );

    function marxarCorrecte(){
      location.href = "php/logout.php";
    }

    $(".xcrear_taulell").on("click", function(){

      $.post('php/obtenir_dades.php', function(data){

        console.log(data);
        var email = data;

        if (email != '')
        {
          (async () => {
    
            const { value: formValues } = await Swal.fire({
              title: 'Creació Taulell',
              html:
                '<div class="col-md-12 mb-12">'+
                  '<label for="nom_correu">Email Usuari</label>'+
                  '<br><input id="nom_correu" class="form-control" type="text" value="'+email+'" disabled>'+
                '</div><br>'+
                '<div class="col-md-12 mb-12">'+
                  '<label for="nom_taulell">Nom del Taulell</label>'+
                  '<br><input id="nom_taulell" class="form-control" type="text">'+
                '</div>',
              focusConfirm: false,
              confirmButtonText: "Crear",
              preConfirm: () => {
                return [
                  $('#nom_taulell').val()
                ]
              }
            })
    
            //si el formulari es correcte
            if (formValues) {
  
              var nom_indicat = $('#nom_taulell').val();
              
              $.post('php/create_table.php', {name_table: nom_indicat, correu: email}, 
              
              function(data){
                
                if (data == 1)
                {
                  Swal.fire(
                    'Creació Taulell!',
                    'Correcte, Taulell creat amb exit',
                    'success'
                  )
                }
                else
                {
                  Swal.fire(
                    'Creació Taulell!',
                    'Incorrecte, ja ets propietari d\'aquest taulell',
                    'error'
                  )
                }
              });
  
                console.log(JSON.stringify(formValues));
              }
            }
        )();
        }
      });
    });
});
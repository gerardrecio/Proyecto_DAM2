$(document).ready(function(){

    $(".xcrear_taulell").on("click", function(){

      $.post('php/obtenir_dades.php', function(data){

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
                  $('#nom_taulell').val(),
                  $('#nom_correu').val(),
                ]
              }
            })
    
            //si el formulari es correcte
            if (formValues) {
  
              var nom_indicat = $('#nom_taulell').val();
              var nom_correu = $('#nom_correu').val();
              
              $.post('php/create_table.php', {name_table: nom_indicat, correu: nom_correu}, 
              
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
              }
            }
        )();
        }

      });

    })

    $(".xcompartir_taulell").on('submit', function(e) {
      e.preventDefault();
    });

    $(".xcategoria_taulell").on('submit', function(e){
      e.preventDefault();
    });

    //al fer click al boto de compartir
    $(".xcompartir_noms").on('click', function(){

      var qtt_bo = $(".xcrear_llistacompartida li.list-group-item.bg-primary").length;  //mida dels emails bons
      var nom_taulell = new URLSearchParams(window.location.search).get('id_taulell'); //obte el parametre de la URL en format GET
      var nom_email = $(".xnom_email")[0].textContent.split("(")[0];  //per obtenir el nom

      if (qtt_bo == 0)
      {
        Swal.fire(
          'Compartir Taulell',
          'Necessites minim 1 destinari!',
          'error'
        );
      }
      else
      {
        var string_bo = $(".xcrear_llistacompartida li.list-group-item.bg-primary")[0].textContent;
        //falta fer el compartir taulell
        $.post("php/compartir_taules.php", {email_bo: string_bo, taula: nom_taulell, email_creador: nom_email}, 
        
          function(data){

            if (data == 1)
            {
              Swal.fire(
                'Compartir Taulell',
                'S\'ha enviat l\'email als destinataris i s\'ha compartit el taulell',
                'success'
              );

              //remove

              $(".xcrear_llistacompartida").empty();
              $(".xescriure_compartit").val("");

            }
            else
            {
                Swal.fire(
                'Compartir Taulell',
                'S\'ha enviat l\'email als destinataris i s\'ha compartit el taulell',
                'success'
              );
            }
          }
        );
      }
      
    });

    $(".xescriure_compartit").on('keypress', function(e){

      var keycode = e.keyCode;
      var separador = ";";
      var nom_taulell = new URLSearchParams(window.location.search).get('id_taulell'); //obte el parametre de la URL en format GET
      //var nom_taulell = $(".xnom_taulell")[0].textContent.split(" ")[1];
      var nom_email = $(".xnom_email")[0].textContent.split("(")[0];  //per obtenir el nom
      var escrit = $(".xescriure_compartit").val(); //contingut escrit

      if (escrit.search(";") == -1) //vol dir que no l'ha trobat
      {
        if (keycode == 59)  //;
        {
          counter = 1;  //posem el contador en 1 per no poder escriure mes
          var escrit = $(".xescriure_compartit").val(); //contingut escrit
          
          $(".xcrear_llistacompartida").empty(); //remove de la llista anterior
  
            $.post("php/comprobar_email.php", {taulell: nom_taulell, creador: nom_email, email: escrit}, 
            function(data){
  
              var parsed = JSON.parse(data);
  
              if (parsed.Resposta == 1)
              {
                $(".xcrear_llistacompartida").append("<li class='list-group-item bg-primary'>"+parsed.email+"</li>"); //esta disponible per compartir
              }
              else
              {
                $(".xcrear_llistacompartida").append("<li class='list-group-item bg-warning'>"+parsed.email+"</li>");  //no esta disponible per compartir
              }
            }
          )
        }
      }
      else
      {
        e.preventDefault();
      }
    })

    $(".xcrear_categories").on('click', function(){

      var input = $(".xescriure_categoria").val();

      var nom_taulell = new URLSearchParams(window.location.search).get('id_taulell'); //obte el parametre de la URL en format GET
      var nom_email = $(".xnom_email")[0].textContent.split("(")[0];  //per obtenir el nom

      if (input == "")
      {
        Swal.fire({
          icon: 'error',
          title: 'Crear Categoria',
          text: 'No pots deixar el camp buit'
        });
      }
      else
      {
        $.post("php/crear_categoria.php", {taulell: nom_taulell, categoria: input, creador: nom_email}, 
        
          function(data){

            if (data == 1)
            {
              Swal.fire({
                icon: 'success',
                title: 'Crear Categoria',
                text: 'Categoria Creada amb exit'
              });
            }
            else
            {
              Swal.fire({
                icon: 'error',
                title: 'Crear Categoria',
                text: 'La Categoria ja existeix'
              });
            }
          }
        );
      }
    });

    $(".xescriure_compartit").on('keyup', function(e){

      if (e.keyCode == 8)
      {
        if ($(".xescriure_compartit").val().length == 0)
        {
          $(".xcrear_llistacompartida").empty(); //remove de la llista anterior
        }
      }
    });

    function remoure_taula(){
      
      $(".xcrear_taularols").empty();
    };

    function crear_taula(){
      var roles;
      var nom_taulell = new URLSearchParams(window.location.search).get('id_taulell'); //obte el parametre de la URL en format GET
      var nom_email = $(".xnom_email")[0].textContent.split("(")[0];  //per obtenir el nom

      $.post("php/obtain_roles.php", 
      
      function(data){

        var parsed = JSON.parse(data);

        for (i = 0; i < parsed.length; i++)
        {
          roles+='<option value='+parsed[i].id+'>'+parsed[i].nom+'</option>';
        }

        //removem la taula anterior per si hi ha nous canvis
        remoure_taula();

          $.post("php/obtain_rols_mails.php", {tablero: nom_taulell, creador: nom_email}, 
          
          function(data){

            var parsed = JSON.parse(data);
            var nom = $(".xnom_email")[0].textContent.split("(")[0].trim();  //per obtenir el nom

            if (parsed[0].mailusu != null)
            {
              for (i = 0; i < parsed.length; i++)
              {
                if (parsed[i].mailusu != nom)
                {
                  $(".xcrear_taularols").append('<tr><th scope="row">'+i+'</th><td>'+parsed[i].mailusu+'</td><td>'+parsed[i].nomrol+'</td><td><select class="form-control">'+roles+'</select></td><td><button class="btn btn-primary xactivar_rol">Activar</button></td></tr>');
                }
              }
            }
            else
            {
              $(".xcrear_taularols").append('<tr><td colspan="5" class="text-center">No hi ha usuaris</td></tr>');
            }
          })
      });
    };

    //esborrar

    function remoure_tauladelete(){
      
      $(".xcrear_taulaeliminar").empty();
    };

    function crear_delete_table(){

      var nom_taulell = new URLSearchParams(window.location.search).get('id_taulell'); //obte el parametre de la URL en format GET
      var nom_email = $(".xnom_email")[0].textContent.split("(")[0];  //per obtenir el nom

      $.post("php/obtain_tasques_usuari.php", {tablero: nom_taulell, creador: nom_email}, 
      
      function(data){

        var parsed = JSON.parse(data);

        //removem la taula anterior per si hi ha nous canvis
        remoure_tauladelete();

        var nom = $(".xnom_email")[0].textContent.split("(")[0].trim();  //per obtenir el nom

          if (parsed.length != 0)
          {
            for (i = 0; i < parsed.length; i++)
            {
              if (parsed[i].mail != nom)
              {
                $(".xcrear_taulaeliminar").append('<tr><th scope="row">'+i+'</th><td>'+parsed[i].mail+'</td><td>'+parsed[i].numtasques+'</td><td><button class="btn btn-danger xactivar_eliminar">Eliminar</button></td></tr>');
              }
            }
          }
          else
          {
            $(".xcrear_taulaeliminar").append('<tr><td colspan="5" class="text-center">No hi ha usuaris</td></tr>');
          }
        }
      );
    };

    $(".xcrear_taulaeliminar").on('click', '.xactivar_eliminar', function(){

       //FUNCIONEN CORRECTAMENT
       var email = $(this).parent().parent().children()[1].textContent;
       var nom_taulell = new URLSearchParams(window.location.search).get('id_taulell'); //obte el parametre de la URL en format GET
       var nom_email = $(".xnom_email")[0].textContent.split("(")[0];  //per obtenir el nom

       $.post("php/eliminar_usuari.php", {mail: email, taulell: nom_taulell, creador: nom_email}, 
        function(data){

          console.log(data);

          if (data == 1)
          {
            Swal.fire({
              icon: 'success',
              title: 'Eliminació Usuaris',
              text: 'S\'ha eliminat un usuari correctament'
            });

            remoure_tauladelete();
            crear_delete_table();
          }
          else
          {
            Swal.fire({
              icon: 'error',
              title: 'Eliminació Usuaris',
              text: 'No s\'ha pogut eliminar l\'usuari'
            });
          }

        }
       );
    });



    $(".xclick_rolsuser").on('click', function(){
      crear_taula();
    });

    $(".xclick_deleteuser").on('click', function(){
      crear_delete_table();
    });

    //al fer click al boto d'activar rol
    $(".xcrear_taularols").on('click', '.xactivar_rol', function(){

      //FUNCIONEN CORRECTAMENT
      var email = $(this).parent().parent().children()[1].textContent;
      var rol_desitjat = $(this).parent().parent().children()[3].children[0].value;
      var nom_taulell = new URLSearchParams(window.location.search).get('id_taulell'); //obte el parametre de la URL en format GET
      var nom_email = $(".xnom_email")[0].textContent.split("(")[0];  //per obtenir el nom


      $.post("php/cambiar_rol.php", {mailto: email, rol: rol_desitjat, nom_tau: nom_taulell, mailcreador: nom_email}, 
      
        function(data){

          if (data == 1)
          {
            Swal.fire({
              icon: 'success',
              title: 'Assignar Rols Usuaris',
              text: 'Rol Assignat correctament'
            });

            crear_taula();
          }
          else
          {
            Swal.fire({
              icon: 'error',
              title: 'Assignar Rols Usuaris',
              text: 'No pots Assignar el mateix rol'
            });
          }
        }
      );
    });
});
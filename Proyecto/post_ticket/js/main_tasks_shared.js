$(document).ready(function(){

  //aqui toca fer la paginacio masiva

  var nom_taulelljs = new URLSearchParams(window.location.search).get('id_taulell'); //obte el parametre de la URL en format GET
  var nom_tasca = new URLSearchParams(window.location.search).get('tasca'); //obte el parametre de la URL en format GET
  var email = new URLSearchParams(window.location.search).get('email'); //obte el parametre de la URL en format GET
  var id = new URLSearchParams(window.location.search).get('idtasca'); //obte el parametre de la URL en format GET
  var estatus = new URLSearchParams(window.location.search).get('estat'); //obte el parametre de la URL en format GET
  var categ = new URLSearchParams(window.location.search).get('categoria'); //obte el parametre de la URL en format GET


  $(".xnom_tasca").append("Tasca: "+nom_tasca);

  $.post("php/obtain_dades_creador_taulell_shared.php", {id_tasca: id}, 
  
    function(data){

    var nom_creador = data;

    console.log(nom_creador);

    $.post("php/obtain_categories.php", {nom_taulell: nom_taulelljs, creador: nom_creador}, 
  
    function(data){
  
      var parsed = JSON.parse(data);
  
      for (i = 0; i < parsed.length; i++)
      {
        $(".xcategoria_form").append("<option>"+parsed[i].nom+"</option");
      }
    });
  });


  $.post("php/obtain_dades_tasca.php", {id_tasca: id}, 
  function(data){

    var parsed = JSON.parse(data);

    console.log(parsed);

    $(".xmissatge_inicial").append(parsed[0].cos_missatge);
    $(".xnom_creador").append("Creador: "+parsed[0].creador);
    $(".xdata_limit").val(parsed[0].data_limit);
    $(".xasignat_task").append(parsed[0].asignat);
    $(".xestat_task").append(parsed[0].descripcio);
    $(".xcategoria_task").append(parsed[0].nom);

    if (parsed[0].data_valor == 0)
    {
      $(".xenviar_boto").prop("disabled", true);
      $("#exampleFormControlTextarea1").prop("disabled", true);
    }

    $.post("php/obtenir_rol_usuari.php", {id_taulell: nom_taulelljs, usuari: email, creador: parsed[0].creador}, 
          
    function(data){

      var rol = data;

      if (rol == 3)
      {
        $(".xcategoria_form").addClass("d-none");
        $(".xestat_form").addClass("d-none");
        $(".xassignat_form").addClass("d-none");
        $(".xcanviar_data").addClass("d-none");
      }
      
      if (rol == 2 && (parsed[0].asignat != email))
      {
        $(".xcategoria_form").addClass("d-none");
        $(".xestat_form").addClass("d-none");
        $(".xassignat_form").addClass("d-none");
        $(".xcanviar_data").addClass("d-none");
      }

      if (rol == 2 && (parsed[0].asignat == email))
      {
        $(".xassignat_form").addClass("d-none");
      }
    });

  }); 

  //al fer doble click al espai disabled de la data LIMIT
  $(".xcanviar_data").on("click", function(){

    if ($(".xdata_limit").attr("disabled") == "disabled")
    {
      //es te que treure el disabled y posar el camp en format DATE
      $(".xdata_limit").attr("disabled", false);
      $(".xdata_limit").attr("type", "date");
    }
    else
    {
      var mydata = $(".xdata_limit").val();
      console.log(mydata);

      $.post("php/canviar_datamytask.php", {id_tasca: id, data_nova: mydata}, 
      
      function(data){
        
        if (data == 1)
        {
          Swal.fire({
            icon: 'success',
            title: 'Canviar Data',
            text: 'Data canviada correctament'
          });
          
          $(".xdata_limit").attr("disabled", true);

          $.post("php/obtain_dades_tasca.php", {id_tasca: id}, 
          function(data){
        
            var parsed = JSON.parse(data);
        
            console.log(parsed);
        
            if (parsed[0].data_valor == 0)
            {
              $(".xenviar_boto").prop("disabled", true);
              $("#exampleFormControlTextarea1").prop("disabled", true);
            }
            else
            {
              $(".xenviar_boto").prop("disabled", false);
              $("#exampleFormControlTextarea1").prop("disabled", false);
            }
          });
        }
        else
        {
          Swal.fire({
            icon: 'error',
            title: 'Canviar Data',
            text: 'La data no s\'ha pogut canviar'
          });
        }
      });
    }
  });

  //obtenir els textos

  $.post("php/obtain_dades_creador_taulell_shared.php", {id_tasca: id}, function(data){

    var email = data;

    $.post("php/obtain_missatge.php", {id_tasca: id, creador: email}, 
    
    function(data){

      var parsed = JSON.parse(data);

      console.log(parsed);

      for (i = 0; i < parsed.length; i++)
      {
        if (parsed[i].valor == 0) //creador
        {
          $(".xrebre_missatges").append(
            "<div class='mt-4 col-xl-5'>"+
              "<h5 class='card-header bg-primary'>"+parsed[i].mail+" - "+parsed[i].fecha+"</h5>"+
              "<div class='card-body bg-primary text-justify'>"+parsed[i].missatge+"</div>"+
            "</div>"
          );
        }
        else
        {
          $(".xrebre_missatges").append(
            "<div class='mt-4 col-xl-5 offset-xl-7'>"+
              "<h5 class='card-header bg-prueba text-dark'>"+parsed[i].mail+" - "+parsed[i].fecha+"</h5>"+
              "<div class='card-body bg-prueba text-dark text-justify'>"+parsed[i].missatge+"</div>"+
            "</div>"
          );
        }
      }

    });
  });

  //obtenir els estats
  $.post("php/obtain_estats.php", 
  
  function(data){

    var parsed = JSON.parse(data);

    for (i = 0; i < parsed.length; i++)
    {
      $(".xestat_form").append("<option>"+parsed[i].descripcio+"</option");
    }
  });

  $.post("php/obtain_dades_creador_taulell_shared.php", {id_tasca: id}, function(data){

    var email = data;

      $.post("php/obtain_usuaris_asignats.php", {nom_taulell: nom_taulelljs, creador: email}, 
      function(data){

        var parsed = JSON.parse(data);

        for (i = 0; i < parsed.length; i++)
        {
          $(".xassignat_form").append("<option>"+parsed[i].mail+"</option");
        }

      });
  });


  //part on pulsaras enviar!

  $(".xenviar_boto").on('click', function(){

      var texto = $(".xtextarea_form").val();

      $.post("php/obtenir_dades.php", function(data){

        var email = data;

        $.post("php/enviar_text.php", {id_tasca: id, text: texto, mail: email}, 
        
          function(data){

            if (data == 1)
            {
              var actual = $(".xnom_creador")[0].textContent.split(":")[1].trim();

              var MyDate = new Date();
              var MyDateString;

              MyDateString = ('0' + MyDate.getDate()).slice(-2) + '/' + ('0' + (MyDate.getMonth()+1)).slice(-2) + '/' + MyDate.getFullYear() + ' ' + ('0' + (MyDate.getHours())).slice(-2) + ':' + ('0' + (MyDate.getMinutes()+1)).slice(-2);

              if (email == actual)
              {
                // es el creador
                $(".xrebre_missatges").append(
                  "<div class='mt-4 col-xl-5'>"+
                    "<h5 class='card-header bg-primary'>"+email+" - "+MyDateString+"</h5>"+
                    "<div class='card-body bg-primary text-justify'>"+texto+"</div>"+
                  "</div>"
                );
              }
              else
              {
                $(".xrebre_missatges").append(
                  "<div class='mt-4 col-xl-5 offset-xl-7'>"+
                    "<h5 class='card-header bg-prueba text-dark'>"+email+" - "+MyDateString+"</h5>"+
                    "<div class='card-body bg-prueba text-dark text-justify'>"+texto+"</div>"+
                  "</div>"
                );
              }
            }
            else
            {
              Swal.fire({
                icon: 'error',
                title: 'Enviament Missatge',
                text: 'No s\'ha pogut enviar el missatge'
              });
            }

        });
      });
  });

  $(".xassignat_form").on("change", function(){

    var selectioned = $(this)[0].value;
    var actual = $(".xasignat_task")[0].textContent.split(":")[1].trim();

    if (selectioned != actual)
    {
      $.post("php/cambiar_assignat_propi.php", {id_tasca: id, assignat: selectioned}, 
      
      function(data){

        if (data == 1)
        {
          $(".xasignat_task").text("Assignat: "+selectioned);

          Swal.fire({
            icon: 'success',
            title: 'Cambiar Assignació',
            text: 'Assignació realitzada correctament'
          });
        }
        else
        {
          Swal.fire({
            icon: 'error',
            title: 'Cambiar Assignació',
            text: 'No s\'ha pogut fer l\'assignació'
          });
        }
      });

    }
  });


  $(".xestat_form").on("change", function(){

    var selectioned = $(this)[0].value;
    var actual = $(".xestat_task")[0].textContent.split(":")[1].trim();

    if (selectioned != actual)
    {
      $.post("php/cambiar_estat_propi.php", {id_tasca: id, estat: selectioned}, 
      
      function(data){

        if (data == 1)
        {
          $(".xestat_task").text("Estat: "+selectioned);

          Swal.fire({
            icon: 'success',
            title: 'Cambiar Estat',
            text: 'Estat cambiat correctament'
          });
        }
        else
        {
          Swal.fire({
            icon: 'error',
            title: 'Cambiar Estat',
            text: 'No s\'ha pogut fer el canvi'
          });
        }

      });

    }

  });


  $(".xcategoria_form").on("change", function(){

    var selectioned = $(this)[0].value;
    var actual = $(".xcategoria_task")[0].textContent.split(":")[1].trim();

    if (selectioned != actual)
    {

      $.post("php/cambiar_categoria_propi.php", {id_tasca: id, categoria: selectioned}, 
      
      function(data){

        if (data == 1)
        {
          $(".xcategoria_task").text("Categoria: "+selectioned);

          Swal.fire({
            icon: 'success',
            title: 'Cambiar Categoria',
            text: 'Categoria cambiada correctament'
          });
        }
        else
        {
          Swal.fire({
            icon: 'error',
            title: 'Cambiar Categoria',
            text: 'No s\'ha pogut fer el canvi'
          });
        }

      });
    }
  });

  //FI PAGINACIO MASIVA

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
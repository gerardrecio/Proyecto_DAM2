$(document).ready(function(){

  //aqui toca fer la paginacio masiva

  var nom_taulelljs = new URLSearchParams(window.location.search).get('id_taulell'); //obte el parametre de la URL en format GET
  var nom_tasca = new URLSearchParams(window.location.search).get('tasca'); //obte el parametre de la URL en format GET
  var email = new URLSearchParams(window.location.search).get('email'); //obte el parametre de la URL en format GET
  var id = new URLSearchParams(window.location.search).get('idtasca'); //obte el parametre de la URL en format GET
  var estatus = new URLSearchParams(window.location.search).get('estat'); //obte el parametre de la URL en format GET
  var categ = new URLSearchParams(window.location.search).get('categoria'); //obte el parametre de la URL en format GET


  $(".xnom_tasca").append("Tasca: "+nom_tasca);
  $(".xasignat_task").append(email);
  $(".xestat_task").append(estatus);
  $(".xcategoria_task").append(categ);

  //obtenir les categories
  $.post("php/obtenir_dades.php", function(data){

    var email = data;

    $.post("php/obtain_categories.php", {nom_taulell: nom_taulelljs, creador: email}, 
    
    function(data){

      var parsed = JSON.parse(data);

      for (i = 0; i < parsed.length; i++)
      {
        $(".xcategoria_form").append("<option>"+parsed[i].nom+"</option");
      }

    });
  });

  //obtenir els textos
  $.post("php/obtenir_dades.php", function(data){

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

  $.post("php/obtenir_dades.php", function(data){

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

  $.post("php/obtain_dades_tasca.php", {id_tasca: id}, 
    function(data){

      var parsed = JSON.parse(data);

      console.log(parsed);

      $(".xmissatge_inicial").append(parsed[0].cos_missatge);
      $(".xnom_creador").append("Creador: "+parsed[0].creador);
      $(".xdata_limit").val(parsed[0].data_limit);
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
              
              $.post('php/create_table.php', {name_table: nom_indicat, correu: "perichors@gmail.com"}, 
              
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
$(document).ready(function(){

  //aqui toca fer la paginacio masiva

  var nom_taulell = new URLSearchParams(window.location.search).get('id_taulell'); //obte el parametre de la URL en format GET

  $.post("php/obtenir_dades.php", function(data){

    var email = data;

      carregar_taulell(0, 10);

      $.post("php/pagination.php", {id_taulell: nom_taulell, creador: email}, 
    
        function(data){

          console.log(data);

          var total_pagines = data / 10;

          console.log(total_pagines);

          if (total_pagines < 1)
          {
            $(".xpagination").append('<li class="page-item active"><a class="page-link" href="#">1</a></li>');
          }
          else
          {
            for (i = 0; i < total_pagines; i++)
            {
              var n = i+1;
              if (i == 0)
              {
                $(".xpagination").append('<li class="page-item active"><a class="page-link xnumero" href="#">'+n+'</a></li>');
              }
              else
              {
                $(".xpagination").append('<li class="page-item"><a class="page-link xnumero" href="#">'+n+'</a></li>');
              }
            }
          }
        }
      )
  });

  function carregar_taulell(pagina, cantitat){
    $.post("php/obtenir_dades.php", function(data){

      var i = pagina * cantitat;
      var fins = cantitat + i;
      var email = data;
  
        $.post("php/obtenir_taulell.php", {id_taulell: nom_taulell, creador: email}, 
        
          function(data){
            var dades_taulell = JSON.parse(data);
            console.log(dades_taulell);

            if (dades_taulell.length == 0)
            {
              $(".xcrear_tauladash").append('<tr><td colspan="6" class="text-center">No hi ha usuaris</td></tr>');
            }
            else
            {
              for (i; i < fins; i++)
              {
                var xt = dades_taulell[i].color;
  
                console.log(xt);
  
                if (xt == 1)
                {
                  var xcolor = "<span class='badge-dot badge-warning mr-1'></span>";
                }
                else
                {
                  var xcolor = "<span class='badge-dot badge-success mr-1'></span>";
                }
  
                $(".xcrear_tauladash").append('<tr><th scope="row">'+dades_taulell[i].id+'</th><td>'+dades_taulell[i].titol+'</td><td>'+dades_taulell[i].categoria+'</td><td>'+dades_taulell[i].asignat+'</td><td>'+dades_taulell[i].data_limit+'</td><td>'+xcolor+dades_taulell[i].estat+'</td><td><button class="btn btn-primary xanar_tasca">Veure Tasca</button></td></tr>');
              }
            }
        });
    })
  };

  $(".xcrear_tauladash").on("click", ".xanar_tasca", function(){

      var tasca = $(this).parent().parent().children()[1].textContent;
      var email = $(this).parent().parent().children()[3].textContent;
      var id = $(this).parent().parent().children()[0].textContent;
      var categoria = $(this).parent().parent().children()[2].textContent;
      var estat = $(this).parent().parent().children()[5].textContent;

      window.location.href = "mytask.php?id_taulell="+nom_taulell+"&email="+email+"&tasca="+tasca+"&idtasca="+id+"&categoria="+categoria+"&estat="+estat;

  });

  $(".xpagination").on('click', '.xnumero', function(){

    var valor = $(this)[0].text;  //numero de pagina que toco
    //removem el active als que hu tinguin
    $('.page-item').removeClass('active');

    $(this).parent().addClass('active');  //assignem el active al que toca
    $(".xcrear_tauladash").empty();
    carregar_taulell(valor-1, 10);
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
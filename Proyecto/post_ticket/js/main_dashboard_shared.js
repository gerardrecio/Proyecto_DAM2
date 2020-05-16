$(document).ready(function(){

  //aqui toca fer la paginacio masiva

  var nom_taulell = new URLSearchParams(window.location.search).get('id_taulell'); //obte el parametre de la URL en format GET
  var nom_creador = new URLSearchParams(window.location.search).get('email_creador'); //obte el parametre de la URL en format GET

  $.post("php/obtenir_dades.php", function(data){

    var email = data;

        $.post("php/obtenir_rol_usuari.php", {id_taulell: nom_taulell, usuari: email, creador: nom_creador}, 
          
        function(data){

          var rol = data;

          if (rol == 3)
          {
            $(".xcrear_tasca").addClass("d-none");
          }

          if (rol == 2)
          {
            $(".xcrear_tasca").addClass("d-none");
          }

        });

      carregar_taulell(0, 10);

      $.post("php/pagination.php", {id_taulell: nom_taulell, creador: nom_creador}, 
    
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


  $.post("php/obtain_categories.php", {nom_taulell: nom_taulell, creador: nom_creador}, 
        
  function(data){

    var parsed = JSON.parse(data);

    for (i = 0; i < parsed.length; i++)
    {
      $(".xbuscador_categories").append(
        
      "<div class='custom-control custom-checkbox'>"+
      "<input type='checkbox' class='custom-control-input' id='customCheck_"+i+"'>"+
      "<label class='custom-control-label customCheck_"+i+"' for='customCheck_"+i+"'>"+parsed[i].nom+"</label>"+
      "</div>"
      );
    }
  });

  $.post("php/obtain_usuaris_per_taulell.php", {nom_taulell: nom_taulell, creador: nom_creador}, 
        
  function(data){

    var parsed = JSON.parse(data);

    for (i = 0; i < parsed.length; i++)
    {
      $(".xbuscador_usuaris").append(
        
      "<div class='custom-control custom-checkbox'>"+
      "<input type='checkbox' class='custom-control-input' id='customChk_"+i+"'>"+
      "<label class='custom-control-label customChk_"+i+"' for='customChk_"+i+"'>"+parsed[i].mail+"</label>"+
      "</div>"
      );
    }
  });



  $(".xbtn_buscar").on("click", function(e){

    e.preventDefault();

    var cat = [];
    var users = [];
    
    $('.xbuscador_categories input[type=checkbox]').each(function () {

      if (this.checked)
      {
        var nom = $("."+this.id)[0].textContent;
        cat.push(nom);
      }
    });

    $('.xbuscador_usuaris input[type=checkbox]').each(function () {

      if (this.checked)
      {
        var nom = $("."+this.id)[0].textContent;
        users.push(nom);
      }
    });


    $(".xpagination").on('click', '.xnumero_filtre', function(){
      //removem el active als que hu tinguin
      $('.page-item').removeClass('active');
      $(this).parent().addClass('active');  //assignem el active al que toca
  
      var valor = $(this)[0].text;
      //eliminem la taula
      $(".xcrear_tauladash").empty();
      //FALTA re-crear la taula
  
      var cat = [];
      var users = [];
      
      $('.xbuscador_categories input[type=checkbox]').each(function () {
  
        if (this.checked)
        {
          var nom = $("."+this.id)[0].textContent;
          cat.push(nom);
        }
      });
  
      $('.xbuscador_usuaris input[type=checkbox]').each(function () {
  
        if (this.checked)
        {
          var nom = $("."+this.id)[0].textContent;
          users.push(nom);
        }
      });
  
  
      $.post("php/obtenir_dades.php", function(data){
  
        var email = data;
        var ordenacio = $(".xdata option:selected").text();
  
        var ord;
  
        if (ordenacio === "Ascendent")
        {
          ord = 0;
        }
        else
        {
          ord = 1;
        }
  
        //console.log(cat);
        //console.log(users);
        //console.log(nom_taulell);
        //console.log(email);
        //console.log(ord);
  
        $.post("php/obtenir_taulell_filtre.php", {id_taulell: nom_taulell, creador: nom_creador, categories: cat, usuaris: users, order: ord}, 
        
        function(data){
  
          //console.log(data);
  
          //removem tota la taula
          $(".xcrear_tauladash").empty();
          //re invoquem la taula amb les noves dades
          var dades_taulell = JSON.parse(data);
  
          //console.log(dades_taulell);
  
          if (dades_taulell.length == 0)
          {
            $(".xcrear_tauladash").append('<tr><td colspan="7" class="text-center">No hi ha tasques</td></tr>');
          }
          else
          {
            var valor_minim = (valor-1) * 10;
            for (i = valor_minim; i < valor_minim+10; i++)
            {
              var xt = dades_taulell[i].color;
  
              //console.log(xt);
  
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
      });
    });


    $.post("php/obtenir_dades.php", function(data){

      var email = data;
      var ordenacio = $(".xdata option:selected").text();

      var ord;

      if (ordenacio === "Ascendent")
      {
        ord = 0;
      }
      else
      {
        ord = 1;
      }

      //console.log(cat);
      //console.log(users);
      //console.log(nom_taulell);
      //console.log(email);
      //console.log(ord);

      $.post("php/obtenir_taulell_filtre.php", {id_taulell: nom_taulell, creador: nom_creador, categories: cat, usuaris: users, order: ord}, 
      
      function(data){

        //console.log(data);

        //removem tota la taula
        $(".xcrear_tauladash").empty();
        //removem la paginacio
        $(".xpagination").empty();
        //re invoquem la taula amb les noves dades
        var dades_taulell = JSON.parse(data);

        console.log(dades_taulell);

        if (dades_taulell.length == 0)
        {
          $(".xcrear_tauladash").append('<tr><td colspan="7" class="text-center">No hi ha tasques</td></tr>');
        }
        else
        {

          var pagines_totals = dades_taulell.length/10;
          //console.log(pagines_totals);

          //creacio de les pagines filtrades

          for (i = 0; i < pagines_totals; i++)
          {
            var n = i+1;
            if (i == 0)
            {
              $(".xpagination").append('<li class="page-item active"><a class="page-link xnumero_filtre" href="#">'+n+'</a></li>');
            }
            else
            {
              $(".xpagination").append('<li class="page-item"><a class="page-link xnumero_filtre" href="#">'+n+'</a></li>');
            }
          }

          for (i = 0; i < 10; i++)
          {
            var xt = dades_taulell[i].color;

            //console.log(xt);

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

    });

  });







  $(".xcrear_tasca").on("click", function(){

    $.post("php/obtenir_dades.php", function(data){

      var email = data;

        $.post("php/obtain_categories_taulell.php", {nom_taulell: nom_taulell, creador: nom_creador}, 
        
        function(data){

          var parsed = JSON.parse(data);

          console.log(parsed);

          if (parsed.length > 0)
          {
            var cat = "";

            for (i = 0; i < parsed.length; i++)
            {
              cat+="<option>"+parsed[i].nom+"</option>";
            }
  
            $.post("php/obtain_usuaris_per_taulell.php", {nom_taulell: nom_taulell, creador: nom_creador}, 
            
            function(data){
  
              var parsed = JSON.parse(data);
  
              var ts = "";
  
              for (i = 0; i < parsed.length; i++)
              {
                ts+="<option>"+parsed[i].mail+"</option>";
              }
  
                (async () => {
                  
                  const { value: formValues } = await Swal.fire({
                    title: 'Creació Tasca',
                    html:
                    '<div class="row">'+
                        '<div class="col-6">'+
                          '<label for="nom_correu">Nom de la tasca</label>'+
                          '<br><input id="nom_tasca" class="form-control" type="text">'+
                        '</div>'+
                        '<div class="col-6">'+
                          '<label for="data_limit">Data Limit</label>'+
                          '<br><input id="data_limit" class="form-control" type="date">'+
                        '</div>'+
                    '</div>'+
  
                    '<br><div>'+
                      '<label for="cos_tasca">Assignació</label>'+
                      '<br><select class="form-control" id="seleccio_assignat">'+ts+'</select>'+
                    '</div>'+
  
                    '<br><div>'+
                      '<label for="cos_tasca">Categoria</label>'+
                      '<br><select class="form-control" id="seleccio_cat">'+cat+'</select>'+
                    '</div>'+
                    
                    '<br><div>'+
                      '<label for="cos_tasca">Missatge</label>'+
                      '<br><textarea class="form-control" id="cos_tasca" rows="3"></textarea>'+
                    '</div>',
                    focusConfirm: false,
                    confirmButtonText: "Crear",
                    preConfirm: () => {
                      return [
                        $('#nom_tasca').val(),
                        $('#data_limit').val(),
                        $('#cos_tasca').val(),
                        $('#seleccio_cat').val(),
                        $('#seleccio_assignat').val()
                      ]
                    }
                  })
  
                  //si el formulari es correcte
                  if (formValues) {
                      console.log(formValues);
                      console.log(email);
                      console.log(nom_taulell);
                      console.log(formValues[0]);
                      console.log(formValues[1]);
                      console.log(formValues[2]);
                      console.log(formValues[3]);
                      console.log(formValues[4]);
  
                      $.post("php/crear_tasca.php", {creador: nom_creador, nom_taulell: nom_taulell, nom: formValues[0], data_limit: formValues[1], assignat: formValues[4], categoria: formValues[3], missatge: formValues[2], creador_tasca: email}, 
                      
                      function(data){
  
                        if (data == 1)
                        {
                          Swal.fire(
                            'Creació Tasca!',
                            'Correcte, Tasca creada amb exit',
                            'success'
                          )
  
                                  //removem tota la taula
                          $(".xcrear_tauladash").empty();
                          //removem la paginacio
                          $(".xpagination").empty();
  
                          $.post("php/obtenir_dades.php", function(data){
  
                            var email = data;
                        
                              carregar_taulell(0, 10);
                        
                              $.post("php/pagination.php", {id_taulell: nom_taulell, creador: nom_creador}, 
                            
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
                        }
                        else
                        {
                          Swal.fire(
                            'Creació Tasca!',
                            'Incorrecte, torna-ho a intentar',
                            'error'
                          )
                        }
  
                      });
                    }
                  }
              )();
  
            });
          }
          else
          {
            Swal.fire({
              icon: 'error',
              title: 'Creació Tasca',
              text: 'No hi han categories, tens que crear primer una categoria'
            })
          }

        });
    });
  });


  function carregar_taulell(pagina, cantitat){
    $.post("php/obtenir_dades.php", function(data){

      var i = pagina * cantitat;
      var fins = cantitat + i;
      var email = data;
  
        $.post("php/obtenir_taulell.php", {id_taulell: nom_taulell, creador: nom_creador}, 
        
          function(data){
            var dades_taulell = JSON.parse(data);
            console.log(dades_taulell);

            if (dades_taulell.length == 0)
            {
              $(".xcrear_tauladash").append('<tr><td colspan="7" class="text-center">No hi ha tasques</td></tr>');
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

      window.location.href = "mytaskshared.php?id_taulell="+nom_taulell+"&email="+email+"&tasca="+tasca+"&idtasca="+id+"&categoria="+categoria+"&estat="+estat;

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

(function ($) {
    "use strict";

    /*==================================================================
    [ Focus Contact2 ]*/
    $('.input100').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
            else {
                $(this).removeClass('has-val');
            }
        })    
    })

    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        if (check == true)
        {

            var xname = $('.xname').val();
            var xemail = $('.xemail').val();
            var xsurname = $('.xsurname').val();
            var xpassword = $('.xpassword').val();

            $.post("../php/registro.php", {email: xemail, name: xname, surname: xsurname, password: xpassword}, 
            
            function(data){

                console.log(data);

                if (data == 1)
                {
                    Swal.fire(
                        'Correcte',
                        'Compte creada exitosament',
                        'success'
                      );     

                    //per redirigir
                    setTimeout(marxarCorrecte, 2000);
                }
                else
                {
                    Swal.fire(
                        'Incorrecte',
                        'La compte no s\'ha pogut crear, ja existeix una compte amb aquest email',
                        'error'
                      );     
                }
            })
   
        }
        else
        {
            Swal.fire(
                'Error',
                'Camps incorrectes o buits',
                'error'
              );
        }


        return check;
    });

    function marxarCorrecte(){
        window.location.replace("../../../index.html");
    }


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    

})(jQuery);
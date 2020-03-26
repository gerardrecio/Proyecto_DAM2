
$( document ).ready(function() {
    
    
    $(".xenviar").on("click", function() {

        if ( $("#contactForm").valid() == true)

        {
            //asincronamente
            $.post("php/email_send.php", {text: $('#message').val(), name: $('#name').val(), email: $('#email').val(), subject: $('#subject').val()}, 
                    
            function(data){

                    console.log(data);

                    //significa que ha enviado el mensaje correctamente
                    if (data == 1)
                    {
                        Swal.fire({
                            icon: 'success',
                            title: 'Contact Us',
                            text: 'Message sent correctly'
                        });

                        //per redirigir
                        setTimeout(marxarCorrecte, 2000);

                    }
                    else
                    {
                        Swal.fire({
                            icon: 'error',
                            title: 'Contact us',
                            text: 'Something went wrong!'
                        });

                        setTimeout(marxarIncorrecte, 2000);

                    }
                }
            )
        }
        
    })
});

//functions

function marxarCorrecte(){
    window.location.replace("contact.html");
}

function marxarIncorrecte(){
    window.location.replace("contact.html");
}

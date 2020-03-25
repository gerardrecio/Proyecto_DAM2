$( document ).ready(function() {

    var xname;
    var xemail;
    var xsurname;
    var xpassword;

//codigo general

    $(".xbutton").on("click", function(){

        if ( $("#contactForm").valid() == true)
        {
            xname = $(".xname").val();
            xemail = $(".xemail").val();
            xsurname = $(".xsurname").val();
            xpassword = $(".xpassword").val();
    
            
            //per registrar en segon pla asincronament
            $.post("php/registrar.php", {username: xname, email: xemail, surname: xsurname, password: xpassword}, 
            
            function(data){
    
            })
        }
    
    });

});
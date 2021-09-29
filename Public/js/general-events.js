//En este punto ya ha cargado el plugin jquery. no es necesaria
//la funcion onload

//Preconfiguracion el tipo de contenido de las solicitudes ajax
$.ajaxSetup({
    scriptCharset: "ISO-8859-15" ,
    contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15"
});

$(".menu-login").on("click", function(e){

    e.preventDefault();

    //mostramos el panel de login

    $(".fondo-login").css("display", "block");
    $(".fondo-login").toggleClass("animate__fadeIn");

});

$(".menu-logout").on("click", function(e){

    e.preventDefault();

    cargaContenido("./?controlador=UsuarioController&accion=salir").then(function(contenido){

        console.log(contenido);

        resultado = JSON.parse(contenido);
    
        if(resultado.mensaje != undefined){

            toast("Saliendo...");

            if( resultado.mensaje == 'ok'){
                
                setTimeout(function(){
                    location.reload();
                },1000);
            }
            
        }
    });

});

$(".cerrar-login").on("click", function(e){
    
    $(".fondo-login").css("display", "none");
    $(".fondo-login .caja-login").toggleClass("animate__animated animate__fadeIn");

});

$(".form-ingresar").on("submit", function(e){

    e.preventDefault();

    let url = $(this).attr('action');
    let datos =getFormData($(this));

    let validacion = true;

    if(datos['usuario'] == ""){
        validacion = false;
    }


    if(datos['contrasena'] == ""){
        validacion = false;
    }

    if(validacion){

        cargaContenido(url, datos).then(function(contenido){

            console.log(contenido);

            resultado = JSON.parse(contenido);
        
            if(resultado.mensaje != undefined){

                toast(resultado.mensaje);

                if( resultado.estadoIngreso == 'ok'){
                    
                    setTimeout(function(){
                        location.reload();
                    },1000);
                }
                
            }
        });

    }

});
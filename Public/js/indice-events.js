window.onload = function(){

    //verificamos si el boton de login está activo, con esto quitamos o no el form de agregar palabras

    if($(".menu-login").length > 0){
        $(".caja-form-nueva-palabra").remove();
        $(".idiomas-administrables").remove();
    }

    //creamos los teclados virtuales
    generarTecladoSimbolos("input[name=palabra-origen]", ".teclado-simbolos-origen");
    generarTecladoSimbolos("input[name=palabra-traducida]", ".teclado-simbolos-traduccion");
    
    $(".caja-form-nueva-palabra>h2").on("click", function(e){

        if($(".caja-form-nueva-palabra").hasClass("activo")){

            $(".caja-form-nueva-palabra").removeClass("activo");

            $(".caja-form-nueva-palabra>h2 .icon-toggle").addClass("ion-chevron-down");
            $(".caja-form-nueva-palabra>h2 .icon-toggle").removeClass("ion-chevron-up");

        }else{
            $(".caja-form-nueva-palabra").addClass("activo");

            $(".caja-form-nueva-palabra>h2 .icon-toggle").removeClass("ion-chevron-down");
            $(".caja-form-nueva-palabra>h2 .icon-toggle").addClass("ion-chevron-up");
        }

    });

    $(".form-agregar-palabra").on("submit", function(e){

        e.preventDefault();

        $(".loader-guardar-palabra").show();

        let url = $(this).attr('action');
        let datos =getFormData($(this));

        //validamos los campos

        let validacion = true;

        if(datos['tipo'] == 0){
            validacion = false;
        }

        if(datos['idioma-origen'] == 0){
            validacion = false;
        }

        if(datos['idioma-traduccion'] == 0){
            validacion = false;
        }

        if(datos['palabra-origen'] == ""){
            validacion = false;
        }

        if(datos['palabra-traduccion'] == ""){
            validacion = false;
        }

        if(validacion){

            cargaContenido(url, datos).then(function(contenido){
    
                try{

                    resultado = JSON.parse(contenido);
            
                    if(resultado.mensaje != undefined){
        
                        toast(resultado.mensaje);
                        
                    }
        
                    setTimeout(function(){
        
                        $(".loader-guardar-palabra").hide();
        
                    },300);
                    
                    $(".form-agregar-palabra")[0].reset();

                }catch(err){

                    $(".loader-guardar-palabra").hide();
                    toast("Error al guardar la información");

                }

            });

        }else{
            toast("Por favor rellena todos los campos");
            $(".loader-guardar-palabra").hide();
        }




    });

    $(".form-buscar-palabra").on("submit", function(e){

        e.preventDefault();

        let contenedor = $(".contenedor-resultado-busqueda");
        let url = $(this).attr('action');
        let busqueda = $(".form-buscar-palabra input[name=buscar-palabra]").val().trim();
        let resultado = {};

        if(busqueda != ""){

            contenedor.empty().hide();

            $(".loader-busqueda").show();

            let datos = {'busqueda': busqueda};

            cargaContenido(url, datos).then(function(contenido){

                resultado = JSON.parse(contenido);

                let html = "<h3>Palabras encontradas:</h3>";
                let numResultados = resultado.length;

                $.each(resultado, function(index, palabra){

                    let palabraBuscadaArr = palabra.palabra;

                    $.each(palabra.traducciones, function(indexT, traduccion){

                        html += "<div class='item-palabra-busqueda'>"
                                    +"<p>"+palabraBuscadaArr.idioma+" <span class='ion-ios-arrow-forward'></span> "+traduccion.idioma_traduccion+"</p> "
                                    +"<span>"+palabraBuscadaArr.palabra+"</span>"
                                    +"<span>"+traduccion.traduccion+"</span>"
                                +"</div>"; 
                    });

                });

                if(numResultados == 0){
                    html += "<b>Sin resultados</b>";
                }

                html +="<div class='clear'></div>";

                setTimeout(function(){

                    $(".loader-busqueda").hide();

                    contenedor.html(html).promise().done(function(){

                        $(this).show();

                        //hacemos scroll hacia abajo

                        $(".app").animate({ scrollTop: $('.app').prop("scrollHeight")}, 1000);
    
                    });

                },300);
            });

        }else{
            contenedor.empty().hide();
        }
    });

    $(".editar-composicion").on("click", function(e){

        e.preventDefault();

        //tomamos el id y el nombre del idioma
        let idIdioma = $(this).data("ididioma");
        let nombre = $(this).parents(".item-lista-idioma").children("div:first-child").text();
        let url = './?controlador=IdiomasController&accion=obtenerComposicion';
        let elemTipos = "";
        $(".caja-composicion h2").html(nombre);
        $(".btn-guardar-compo-idioma").data("ididioma", idIdioma);

        $(".fondo-composicion-idioma").css("display", "block");
        $(".fondo-composicion-idioma").toggleClass("animate__fadeIn");

        cargaContenido(url, {'id': idIdioma}).then(function(resultado){

            let tipos = JSON.parse(resultado);

            $.each(tipos, function(index, tipo){

                elemTipos += "<div class='elem-tipo-compo' data-idtipo='"+tipo.id+"'>"
                                +"<span class='ion-drag'></span>"
                                +"<strong>"+tipo.id+"</strong><b>"+tipo.tipo+"</b>"
                            +"</div>";

            })



            $(".lista-orden-idioma").html(elemTipos);

        });

    });

    $(".lista-orden-idioma").sortable({
        connectWith: ".contenedor-ordenable",
        stop: function(event, ui) {
            //Evento cuando se suelta el elemento
        }
    });

    $(".btn-guardar-compo-idioma").on("click", function(e){

        e.preventDefault();

        let idIdioma = $(this).data("ididioma");
        let datos = {};
        let url = './?controlador=IdiomasController&accion=guardarComposicion';

        let orden = "";
        $(".lista-orden-idioma .elem-tipo-compo").each(function(){
            orden += $(this).data("idtipo") + ",";
        });

        datos = {'id' : idIdioma,
                 'composicion': orden};

        //enviamos el nuevo orden de composicion al servidor
        cargaContenido(url, datos).then(function(resultado){
        
            $resultado = JSON.parse(resultado);

            if($resultado.mensaje != undefined){
                toast("Composición guardada correctamente");

                $(".btn-cerrar-compo-idioma").click();

            }else{
                toast("Error al guardar la composición");
            }
        });
        


    });

    $(".btn-cerrar-compo-idioma").on("click", function(e){

        e.preventDefault();

        $(".fondo-composicion-idioma").css("display", "none");
        $(".fondo-composicion-idioma").toggleClass("animate__fadeIn");

    });

    $(".tecla-simbolo").on("click", function(e){

        e.preventDefault();

        //obtenemos el simbolo, la referencia al input y su contenido
        let simbolo = $(this).text();
        let objetivo = $(this).data('input');
        let contenido = $(objetivo).val();

        //reescribimos su contenido adjuntando el simbolo
        $(objetivo).val(contenido+simbolo);

        //hacemos focus al input para seguir escribiendo
        $(objetivo).focus();

    });

};
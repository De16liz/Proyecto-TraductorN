window.onload = function(){

    let limiteTexto = 300;

    //Estos son los id de idiomas que se van a seleccionar de forma predeterminada
    let idiomaEntrada = 1;
    let idiomaDestino = 4;

    let temporizadorEscritura = null;

    $(".s-idioma-izquierda").val(idiomaEntrada);
    $(".s-idioma-derecha").val(idiomaDestino);

    
    $(".textarea-traducir").on("keyup", function(e){

        if(temporizadorEscritura != null){
            clearTimeout(temporizadorEscritura);
        }

        let valor = $(this).val().trim();

        if(valor.length > limiteTexto){

            valor = valor.substring(0, limiteTexto);
            $(this).val(valor);
        }

        $(".contador-texto.contador-izquierdo").text(valor.length + " / "+limiteTexto);
        


        if(valor.length > 0){

            temporizadorEscritura = setTimeout(function(){

                //enviamos el texto a traducir
                $(".loader-guardar-palabra").show();

                let url = './?controlador=PalabrasController&accion=traducir';
                let datos = {'texto': valor,
                             'idioma_origen': $(".s-idioma-izquierda").val(),
                             'idioma_traduccion': $(".s-idioma-derecha").val()};
        
                cargaContenido(url, datos).then(function(contenido){


                    //console.log(contenido);

                    let areaTraductor = $(".area-resultado-traduccion");

                    try{

                        resultado = JSON.parse(contenido);

                        if(resultado.traduccion != undefined){
    
                            areaTraductor.html(resultado.traduccion);
                        }else{
                            areaTraductor.html('<span class="no-traduccion">Sin resultados</span>');
                        }

                    }catch(err){

                        areaTraductor.html('<span class="no-traduccion">Sin resultados</span>');
                        
                        toast("Ha ocurrido un error al traducir");
                        console.log(err);

                    };

                });

            }, 500);

        }else{
            $(".area-resultado-traduccion").html('<span class="no-traduccion">¡ Hora de traducir !</span>');
        }


    });

    $(".invertir-idiomas").on("click", function(e){

        e.preventDefault();

        //tomamos los idiomas actuales
        let idiomaIzquierda = $(".s-idioma-izquierda").val();
        let idiomaDerecha = $(".s-idioma-derecha").val();

        //eliminamos mensajes que no son resultados traducidos
        $(".area-resultado-traduccion .no-traduccion").remove();

        //tomamos el los valores actuales
        let valorIzquierda = $("textarea.textarea-traducir").val();
        let valorDerecha = $(".area-resultado-traduccion").text();

        //invertimos los valores
        $(".s-idioma-izquierda").val(idiomaDerecha);
        $(".s-idioma-derecha").val(idiomaIzquierda);

        $("textarea.textarea-traducir").val(valorDerecha);

        //disparamos el evento keyup del traductor
        $(".textarea-traducir").keyup();

    });

    $(".s-idioma-derecha").on("change", function(e){
        $(".textarea-traducir").keyup();
    });

    $(".area-resultado-traduccion").on("mouseover", ".tooltip", function(e){

        let palabraOrigen = $(this).data("origen");
        let offset = $(this).offset();

        $(".tooltip-traductor").css('left', (offset.left)+"px" );
        $(".tooltip-traductor").css('top', (offset.top - 30)+"px" );

        $(".tooltip-traductor").html(palabraOrigen).css("display", "block");

    });

    $(".area-resultado-traduccion").on("mouseleave", ".tooltip", function(e){

        $(".tooltip-traductor").css("display", "none");

    });





};
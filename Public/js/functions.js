
async function cargaContenido(url, datos){

    let contenido = "";

    contenido = await $.post(url, datos).promise();

    return contenido;
}

function getFormData($form){

    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

function toast(mensaje){

    if($(".toast").length > 0){
        $(".toast").text(mensaje);
    }else{
        $('body').append('<span class="toast">'+mensaje+'</span>');
    }
    
    $(".toast").addClass("active");
    
    setTimeout(function(){
        $(".toast").removeClass("active");
    }, 3000);
    
}

function generarTecladoSimbolos(objetivo, cajaTeclado){

    let simbolos = 'ÃĀằãāĪĩīÕõṍŨṹũ';

    let html = "";

    for (let i = 0; i < simbolos.length; i++) {
        const simbolo = simbolos[i];

        html += '<a href="#" class="tecla-simbolo" data-input="'+objetivo+'">'+simbolo+'</a>';
        
    }

    $(cajaTeclado).html(html);

}
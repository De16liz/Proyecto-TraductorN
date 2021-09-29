window.onload = function(){


    
    $('.btn-exportar-lista-palabras').on("click", function (e) {   

        var pdf = new jsPDF('p', 'pt', 'letter');
        
        source = $('.caja-lista-palabras')[0];

        specialElementHandlers = {
            '#render': function (element, renderer) {
                return true
            }
        };
        margins = {
            top: 80,
            bottom: 60,
            left: 40,
            width: 522
        };

        pdf.fromHTML(
            source, 
            margins.left, // x coord
            margins.top, { // y coord
                'width': margins.width, 
                'elementHandlers': specialElementHandlers
            },

            function (dispose) {
                pdf.save('lista-palabras.pdf');
            }, margins
        );

    });

};
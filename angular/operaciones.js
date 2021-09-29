window.onload = function()
{
    angular.element( document.getElementById( 'texto-cargar')).scope().cargar_datos();

    angular.element( document.getElementById( 'texto-cargar' )).scope().otra_funcion();
}


var app = angular.module( "apptraductor", [] );

app.controller( "controlador", 

    [ "$scope", "$http", //inyeccion de dependecias.

        function( $scope, $http ){ //----------MAXIMA, no se deba tocar-----------------
            $scope.documento = [ ];
            $scope.informacion = [];

            //console.log("real");
            $scope.buscar = function( e ){
                let tx = e.target.value.toLowerCase();
                if (tx == ''){
                    $scope.informacion = $scope.documento;
                }else{
                    $scope.informacion = [];
                    let filtro1 = $scope.documento.filter(x=>x.texto.toLowerCase().includes(tx) && x.tipo == 'T1');
    
                    if (filtro1.length > 0){
                        // Titulos
                        let tm = [];
                        filtro1.forEach(item => {

                            tm = tm.concat($scope.documento.filter(x=>x.dependencia.startsWith(item.dependencia)));
                            
                        });
                        
                        //let dp = $scope.documento.filter(x=>x.dependencia.startsWith())
                        //console.log(tm);
                        filtro1 = tm;    


                    }else{
                        filtro1 = $scope.documento.filter(x=>x.texto.toLowerCase().includes(tx) && x.tipo == 'T2');
                        let tm = [];
                        filtro1.forEach(item => {

                            tm = tm.concat($scope.documento.filter(x=>x.dependencia.startsWith(item.dependencia)));
                            
                        });
                        filtro1 = tm;
                    }
    
                    $scope.informacion = filtro1;
    
                }
                
            }

            $scope.cargar_datos = function()
            {
                //console.log("real");
                var lin = 'angular/buscador_informe.php';
                //$scope.nombre = 'karol';
               
                console.log(lin);  
                $http.get( lin ).then( //-----------datos-------- 
                
                    function( response )
                    {
                        console.log(lin); 
                       // console.log('datos.php?mivalor=' + $scope.mitexto + "&in=1&fn=10");
                        $scope.informacion = response.data;
                        $scope.documento = response.data;
                        //console.log( $scope.informacion);
                    }   
                );//--------fin datos---    
            }  
        }//-----------FIN del MAXIMA-------------------
    ]
);




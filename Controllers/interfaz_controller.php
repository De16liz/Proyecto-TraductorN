<?php

class InterfazController{

    public static function cargaVista($vista){
        return file_get_contents('Views/'.$vista.'.html');
    }

    public static function cargaPlantilla(){

        $plantilla = self::cargaVista('plantilla');

        //verificamos sesion de usuario
        if(UsuarioController::estado()){
            $plantilla = str_replace('{btn-login}', '<a href="#" class="menu-logout" title="Salir"><span class="ion-log-out"></span></a>', $plantilla);
        }else{
            $plantilla = str_replace('{btn-login}', '<a href="#" class="menu-login" title="Ingresar"><span class="ion-log-in"></span></a>', $plantilla);
        }

        return $plantilla;
    }

    public static function inicio(){

        $plantilla = self::cargaPlantilla();
        $traductor = self::cargaVista('traductor');

        //consultamos la lista de idiomas
        $idiomas = IdiomasController::obtenerIdiomas();

        $html = "";

        foreach ($idiomas as $idioma) {
            $html .= "<option value='".$idioma['id']."'>".$idioma['idioma']."</option>";
        }

        //incluimos los idiomas en la lista de idiomas del selector
        $traductor = str_replace('{idiomas}', $html, $traductor);
        $traductor = str_replace('{idiomasDestino}', $html, $traductor);

        //incluimos el contenido en la plantilla
        $plantilla = str_replace('{contenido}', $traductor, $plantilla);

        //mostramos la vista completa
        echo $plantilla;

    }

    public static function indice(){
        

        $plantilla = self::cargaPlantilla();
        $indice = self::cargaVista('indice');

        //consultamos la lista de idiomas
        $idiomas = IdiomasController::obtenerIdiomas();

        //consultamos la lista de tipos de palabras
        $tipos = TiposController::obtenerTipos();

        $htmlIdiomasSelect = "<option value='0'>[Seleccione un idioma]</option>";
        $htmlIdiomasLista = "";

        foreach ($idiomas as $idioma) {
            $htmlIdiomasSelect .= "<option value='".$idioma['id']."'>".$idioma['idioma']."</option>";
            $htmlIdiomasLista .= "<div class='item-lista-idioma'>
                                    <div><span class='ion-android-star'></span> ".ucfirst($idioma['idioma'])."</div>
                                    <div><a href='#' class='editar-composicion' data-ididioma='".$idioma['id']."'>Editar Composición de prosa</a></div>
                                  </div>";
        }

        $htmlTiposSelect = "<option value='0'>[Seleccione el tipo de palabra]</option>";

        foreach ($tipos as $tipo) {
            $htmlTiposSelect .= "<option value='".$tipo['id']."'>".$tipo['tipo']."</option>";
        }

        //incluimos los idiomas en la lista de idiomas
        $indice = str_replace('{lista-idiomas}', $htmlIdiomasLista, $indice);

        //incluimos los idiomas en la lista de idiomas del selector
        $indice = str_replace('{idiomas}', $htmlIdiomasSelect, $indice);

        //incluimos los tipos en la lista de tipos del selector
        $indice = str_replace('{tipos}', $htmlTiposSelect, $indice);

        //incluimos el contenido en la plantilla
        $plantilla = str_replace('{contenido}', $indice, $plantilla);

        //mostramos la vista completa
        echo $plantilla;
    }

    public static function tipos(){
        

        $plantilla = self::cargaPlantilla();
        $tiposView = self::cargaVista('tipos');

        //consultamos la lista de tipos de palabras
        $tipos = TiposController::obtenerTipos();


        $htmlTipos = "";

        foreach ($tipos as $tipo) {
            $htmlTipos .= "<div>
                                <h3 class='nombre-tipo'>".$tipo['tipo']."</h3>
                                <p>".$tipo['descripcion']."</p>
                           </div>";
        }

        //incluimos los tipos en la lista de tipos del selector
        $tiposView = str_replace('{tipos}', $htmlTipos, $tiposView);

        //incluimos el contenido en la plantilla
        $plantilla = str_replace('{contenido}', $tiposView, $plantilla);

        //mostramos la vista completa
        echo $plantilla;
    }

    public static function acerca(){
        

        $plantilla = self::cargaPlantilla();
        $acerca = self::cargaVista('acerca');

        //incluimos el contenido en la plantilla
        $plantilla = str_replace('{contenido}', $acerca, $plantilla);

        //mostramos la vista completa
        echo $plantilla;
    }
     //Este es algo nuevo agregardo-----------------------------FUNCION INFORME-------------------------
    public static function informe(){
        

        $plantilla = self::cargaPlantilla();
        $informe = self::cargaVista('informe');

        //incluimos el contenido en la plantilla
        $plantilla = str_replace('{contenido}', $informe, $plantilla);

        //mostramos la vista completa
        echo $plantilla;
    }

    public static function palabras(){

        $plantilla = self::cargaPlantilla();
        $lista = self::cargaVista('lista');

        //consultamos la lista de palabras
        $palabras = PalabrasController::obtenerTodas();
        
        $html = "";
        foreach ($palabras as $palabra) {
            $html .= "<div class='item-lista-palabra'>
                        <span>".$palabra['palabra']."</span>
                        <b>".$palabra['idioma']."</b>
                      </div>";
        }

        //incluimos la lista de palabras en la plantilla de la lista
        $lista = str_replace('{palabras}', $html, $lista);

        //incluimos el contenido en la plantilla
        $plantilla = str_replace('{contenido}', $lista, $plantilla);

        //mostramos la vista completa
        echo $plantilla;

        
    }

}

?>
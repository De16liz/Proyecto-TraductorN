<?php
    //Declaracion de funciones  y helpers
function saniText($texto){

    $texto = addslashes($texto);
    $texto = htmlspecialchars($texto);
    $texto = htmlentities($texto);

    return $texto;
}

function multiExplode($delimiters,$string) {
    return explode(
        $delimiters[0],
        strtr(
            $string,
            array_combine(
                array_slice(    $delimiters, 1  ),
                array_fill(
                    0,
                    count($delimiters)-1,
                    array_shift($delimiters)
                )
            )
        )
    );
}

?>
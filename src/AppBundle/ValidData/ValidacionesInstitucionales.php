<?php

namespace AppBundle\ValidData;

class ValidacionesInstitucionales
{

    public function getValidacion()
    {
        return [
            'CANTIDAD_POBLACION_BENEFICIAR' => array(
                'validaciones' => array(
                    array(
                        array(
                            'tipo' => 'texto',
                            'mensaje_error' => 'error.dato.letra'
                        ),
                        array(
                            'tipo' => 'entidad',
                            'clase' => 'Poblacionbeneficia',
                            'campo' => 'poblacionbeneficiadesc',
                            'mensaje_error' => 'error.no.existe.entidad'
                        )
                    )
                ),
            ),
            'VIABILIDAD_PLANEACION' => array(
                'validaciones' => array(
                    array(
                        array(
                            'tipo' => 'no-null',
                            'mensaje_error' => 'error.dato.vacio'
                        ),
                        array(
                            'tipo' => 'texto',
                            'mensaje_error' => 'error.dato.letra'
                        ),
                        array(
                            'tipo' => 'entidad',
                            'clase' => 'Viabilidadplaneacion',
                            'campo' => 'viabilidadplaneacionconcepto',
                            'mensaje_error' => 'error.no.existe.entidad'
                        )
                    )
                ),
            ),
            'ZONA_UBICACION' => array(
                'validaciones' => array(
                    array(
                        array(
                            'tipo' => 'no-null',
                            'mensaje_error' => 'error.dato.vacio'
                        ),
                        array(
                            'tipo' => 'texto',
                            'mensaje_error' => 'error.dato.letra'
                        ),
                        array(
                            'tipo' => 'entidad',
                            'clase' => 'Zonasubicacion',
                            'campo' => 'zonasubicacionnombre',
                            'mensaje_error' => 'error.no.existe.entidad'
                        )
                    )
                ),
            ),
            'CANTIDAD_BENEFICIOS_INSTITUCIONALES' => array(
                'validaciones' => array(
                    array(
                        array(
                            'tipo' => 'no-null',
                            'mensaje_error' => 'error.dato.vacio'
                        ),
                        array(
                            'tipo' => 'texto',
                            'mensaje_error' => 'error.dato.letra'
                        ),
                        array(
                            'tipo' => 'entidad',
                            'clase' => 'Cantidadesbeneficioinst',
                            'campo' => 'cantidadesbeneficiodesc',
                            'mensaje_error' => 'error.no.existe.entidad'
                        )
                    )
                ),
            ),

        ];
    }
}
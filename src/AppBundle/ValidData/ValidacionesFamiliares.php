<?php

namespace AppBundle\ValidData;

class ValidacionesFamiliares
{

    public function getValidacion()
    {
        return [
            'PARENTESCO_SOLICITANTE' => array(
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
                            'clase' => 'Parentescos',
                            'campo' => 'parentesconombre',
                            'mensaje_error' => 'error.no.existe.entidad'
                        )
                    )
                ),
            ),
            'ESTADO_CIVIL' => array(
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
                            'clase' => 'Estadosciviles',
                            'campo' => 'estadocivilnombre',
                            'mensaje_error' => 'error.no.existe.entidad'
                        )
                    )
                ),
            ),
            'INGRESOS' => array(
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
                            'clase' => 'Ingresos',
                            'campo' => 'ingresonombre',
                            'mensaje_error' => 'error.no.existe.entidad'
                        )
                    )
                ),
            ),
            'PERSONAS_A_CARGO' => array(
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
                            'clase' => 'Personascargo',
                            'campo' => 'personacargonombre',
                            'mensaje_error' => 'error.no.existe.entidad'
                        )
                    )
                ),
            ),
            'SITUACION_VIVIENDA' => array(
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
                            'clase' => 'Situacionesvivienda',
                            'campo' => 'situacionviviendanombre',
                            'mensaje_error' => 'error.no.existe.entidad'
                        )
                    )
                ),
            ),
            'DIFICULTAD' => array(
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
                            'clase' => 'Motivosdeuda',
                            'campo' => 'motivodeudanombre',
                            'mensaje_error' => 'error.no.existe.entidad'
                        )
                    )
                ),
            ),
            'CANTIDAD_BENEFICIOS_AOS' => array(
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
                            'clase' => 'Cantidadesbeneficio',
                            'campo' => 'cantidadbeneficionombre',
                            'mensaje_error' => 'error.no.existe.entidad'
                        )
                    )
                ),
            ),
            'CONCEPTO_VISITA_DOMICILIARIA' => array(
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
                            'clase' => 'Conceptosvisita',
                            'campo' => 'conceptovisitanombre',
                            'mensaje_error' => 'error.no.existe.entidad'
                        )
                    )
                ),
            ),
            'AFILIADO_DIBIE' => array(
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
                            'clase' => 'Afiliadodibie',
                            'campo' => 'afiliadodibiedesc',
                            'mensaje_error' => 'error.no.existe.entidad'
                        )
                    )
                ),
            ),
            'DOCUMENTO_BENEFICIARIO_FINAL' => array(
                'validaciones' => array(
                    array(
                        'tipo' => 'no-null',
                        'mensaje_error' => 'error.dato.vacio'
                    ),
                    array(
                        'tipo' => 'numero',
                        'mensaje_error' => 'error.dato.numero'
                    ),
                )
            ),
            'NOMBRE_BENEFICIARIO_FINAL' => array(
                array(
                    'tipo' => 'no-null',
                    'mensaje_error' => 'error.dato.vacio'
                ),
                'validaciones' => array(
                    array(
                        'tipo' => 'texto',
                        'mensaje_error' => 'error.dato.letra'
                    ),
                )
            ),
        ];
    }
}
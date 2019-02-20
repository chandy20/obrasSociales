<?php

namespace AppBundle\ValidData;

class Validaciones
{

    public function getValidacion()
    {
        return array(
            'FECHA_DE_SOLICITUD' => array(
                'validaciones' => array(
                    array(
                        'tipo' => 'no-null',
                        'mensaje_error' => 'error.dato.vacio'
                    ),
                    array(
                        'tipo' => 'fecha',
                        'mensaje_error' => 'error.dato.fecha'
                    )
                )
            ),
            'SECCIONAL' => array(
                'validaciones' => array(
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
                        'clase' => 'Seccionales',
                        'campo' => 'seccionalnombre',
                        'mensaje_error' => 'error.no.existe.entidad'
                    )
                )
            ),
            'TIPO_SOLICITUD' => array(
                'validaciones' => array(
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
                        'clase' => 'Tipossolicitud',
                        'campo' => 'tiposolicitudnombre',
                        'mensaje_error' => 'error.no.existe.entidad'
                    )
                )
            ),
            'CEDULA_SOLICITANTE' => array(
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
            'NOMBRE_Y_APELLIDO_SOLICITANTE' => array(
                'validaciones' => array(
                    array(
                        'tipo' => 'no-null',
                        'mensaje_error' => 'error.dato.vacio'
                    ),
                    array(
                        'tipo' => 'texto',
                        'mensaje_error' => 'error.dato.letra'
                    ),
                )
            ),
            'EMAIL' => array(
                'validaciones' => array(
                    array(
                        'tipo' => 'email',
                        'mensaje_error' => 'error.dato.email'
                    ),
                    array(
                        'tipo' => 'no-null',
                        'mensaje_error' => 'error.dato.vacio'
                    ),
                )
            ),
            'DIRECCION' => array(
                'validaciones' => array(
                    array(
                        'tipo' => 'no-null',
                        'mensaje_error' => 'error.dato.vacio'
                    ),
                    array(
                        'tipo' => 'texto',
                        'mensaje_error' => 'error.dato.letra'
                    ),
                )
            ),
            'TELEFONO' => array(
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
            'TELEFONO_ALTERNO' => array(
                'validaciones' => array(
                    array(
                        'tipo' => 'numero',
                        'mensaje_error' => 'error.dato.numero'
                    ),
                )
            ),
            'CEDULA_FUNCIONARIO_POLICIAL' => array(
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
            'GRADO_FUNCIONARIO_POLICIAL' => array(
                'validaciones' => array(
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
                        'clase' => 'Grados',
                        'campo' => 'gradonombre',
                        'mensaje_error' => 'error.no.existe.entidad'
                    )
                )
            ),
            'UNIDAD' => array(
                'validaciones' => array(
                    array(
                        array(
                            'tipo' => 'texto',
                            'mensaje_error' => 'error.dato.letra'
                        ),
                        array(
                            'tipo' => 'entidad',
                            'clase' => 'unidad',
                            'campo' => 'nombre',
                            'mensaje_error' => 'error.no.existe.entidad'
                        )
                    )
                ),
            ),
            'NOMBRE_FUNCIONARIO_POLICIAL' => array(
                'validaciones' => array(
                    array(
                        'tipo' => 'texto',
                        'mensaje_error' => 'error.dato.letra'
                    ),
                )
            ),
            'ANTIGUEDAD_FUNCIONARIO' => array(
                'validaciones' => array(
                    array(
                        array(
                            'tipo' => 'texto',
                            'mensaje_error' => 'error.dato.letra'
                        ),
                        array(
                            'tipo' => 'entidad',
                            'clase' => 'antiguedad',
                            'campo' => 'tiempo',
                            'mensaje_error' => 'error.no.existe.entidad'
                        )
                    )
                ),
            ),
            'MODALIDADES' => array(
                'validaciones' => array(
                    array(
                        'tipo' => 'no-null',
                        'mensaje_error' => 'error.dato.vacio'
                    ),
                    array(
                        'tipo' => 'texto',
                        'mensaje_error' => 'error.dato.letra'
                    ),
                    array(
                        'tipo' => 'iterativo',
                        'iterator' => 'entidad',
                        'delimiter'=> ';',
                        'clase' => 'Areas',
                        'campo' => 'areanombre',
                        'mensaje_error' => 'error.no.existe.entidad'
                    )
                )
            ),

        );
    }

}

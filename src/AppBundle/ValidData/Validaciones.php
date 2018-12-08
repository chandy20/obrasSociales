<?php

namespace AppBundle\ValidData;

class Validaciones
{

    public function getValidacionInventario()
    {
        return array(
            'FECHA_DE_SOLICITUD' => array(
                'validaciones' => array(
                    array(
                        'tipo' => 'no-null',
                        'mensaje_error' => 'error.import.null.data'
                    ),
                    array(
                        'tipo' => 'fecha',
                        'mensaje_error' => 'error.import.date.data'
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
                        'mensaje_error' => 'error.import.text.data'
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
                        'mensaje_error' => 'error.import.text.data'
                    ),
                    array(
                        'tipo' => 'entidad',
                        'clase' => 'TipoSolicitud',
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
                        'mensaje_error' => 'error.import.numero.data'
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
                        'mensaje_error' => 'error.import.text.data'
                    ),
                )
            ),
            'EMAIL' => array(
                'validaciones' => array(
                    array(
                        'tipo' => 'email',
                        'mensaje_error' => 'error.import.email.data'
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
                        'mensaje_error' => 'error.import.text.data'
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
                        'mensaje_error' => 'error.import.numero.data'
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
                        'mensaje_error' => 'error.import.numero.data'
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
                        'mensaje_error' => 'error.import.text.data'
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
                            'mensaje_error' => 'error.import.text.data'
                        ),
                        array(
                            'tipo' => 'entidad',
                            'clase' => 'Grados',
                            'campo' => 'gradonombre',
                            'mensaje_error' => 'error.no.existe.entidad'
                        )
                    )
                ),
            ),
            'NOMBRE_Y_APELLIDO_SOLICITANTE' => array(
                'validaciones' => array(
                    array(
                        'tipo' => 'no-null',
                        'mensaje_error' => 'error.dato.vacio'
                    ),
                    array(
                        'tipo' => 'texto',
                        'mensaje_error' => 'error.import.text.data'
                    ),
                )
            ),
        );
    }

}

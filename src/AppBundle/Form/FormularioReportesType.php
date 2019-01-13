<?php

namespace AppBundle\Form;

use AppBundle\Entity\Conceptosjunta;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormularioReportesType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $opcionesFechaInicial = [
            'widget' => 'single_text',
            "label" => "Fecha inicial",
            'format' => 'yyyy-MM-dd',
            'empty_value' => "",
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control')
        ];
        $opcionesFechaFinal = [
            'widget' => 'single_text',
            "label" => "Fecha final",
            'format' => 'yyyy-MM-dd',
            'empty_value' => "",
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control')
        ];
        $opcionesSeccional = [
            'label' => "Seccional",
            'mapped' => false,
            'required' => false,
            'class' => 'AppBundle:Seccionales',
            'attr' => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('s')
                    ->orderBy("s.seccionalnombre", "ASC");
            }
        ];
        $opcionesDocumentoTitular = [
            'mapped' => false,
            'required' => false,
            'label' => "Documento del titular",
            'attr' => array('class' => 'form-control'),
        ];
        $opcionesDocumentoSolicitante = [
            'label' => "Documento del solicitante",
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control'),
        ];
        $opcionesPrograma = [
            'label' => "Programa",
            'required' => false,
            'mapped' => false,
            'class' => 'AppBundle:Programas',
            'attr' => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('p')
                    ->orderBy("p.programanombre", "ASC");
            }
        ];
        $opcionesArea = [
            "label" => "Área",
            'mapped' => false,
            'required' => false,
            'class' => 'AppBundle:Areas',
            'attr' => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('a')
                    ->orderBy("a.areanombre", "ASC");
            }
        ];

        $opcionesParentesco = [
            'label' => "Parentesco",
            'mapped' => false,
            'required' => false,
            'class' => 'AppBundle:Parentescos',
            'attr' => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('p')
                    ->orderBy("p.parentesconombre", "ASC");
            }
        ];

        $opcionesGrado = [
            'label' => "Grado",
            'mapped' => false,
            'required' => false,
            'class' => 'AppBundle:Grados',
            'attr' => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('g')
                    ->orderBy("g.gradonombre", "ASC");
            }
        ];
        $opcionesTipo = [
            'mapped' => false,
            'label' => "Tipo de solicitud",
            'required' => false,
            'class' => 'AppBundle:Tipossolicitud',
            'attr' => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('t')
                    ->orderBy("t.tiposolicitudnombre", "ASC");
            }
        ];
        $opcionesEstado = [
            'mapped' => false,
            "label" => "Estado civil",
            'required' => false,
            'class' => 'AppBundle:Estadosciviles',
            'attr' => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('e')
                    ->orderBy("e.estadocivilnombre", "ASC");
            }
        ];
        $opcionesIngresos = [
            'mapped' => false,
            'label' => "Ingresos",
            'required' => false,
            'class' => 'AppBundle:Ingresos',
            'attr' => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('i')
                    ->orderBy("i.ingresonombre", "ASC");
            }
        ];
        $opcionesPersonas = [
            'mapped' => false,
            "label" => "Personas a cargo",
            'required' => false,
            'class' => 'AppBundle:Personascargo',
            'attr' => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('p')
                    ->orderBy("p.personacargonombre", "ASC");
            }
        ];
        $opcionesSituacion = [
            'mapped' => false,
            "label" => "Situación de la vivienda",
            'required' => false,
            'class' => 'AppBundle:Situacionesvivienda',
            'attr' => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('s')
                    ->orderBy("s.situacionviviendanombre", "ASC");
            }
        ];
        $opcionesMotivo = [
            'mapped' => false,
            "label" => "Motivo de deuda",
            'required' => false,
            'class' => 'AppBundle:Motivosdeuda',
            'attr' => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('m')
                    ->orderBy("m.motivodeudanombre", "ASC");
            }
        ];

        $opcionesAgrupaciones = [
            'mapped' => false,
            "label" => "Agrupación de datos por:",
            'required' => false,
            'choices' => [
                'Parentescos' => 'Parentescos',
                'Grados' => 'Grados',
                'Estadosciviles' => 'Estados Civiles',
                'Ingresos' => 'Ingresos',
                'Personascargo' => 'Personas a cargo',
                'Situacionesvivienda' => 'Situaciones de Vivienda',
                'Motivosdeuda' => 'Motivos de deuda',
                'Tipossolicitud' => 'Tipos de solicitud',
                'Seccionales' => 'Seccional'
            ],
            'attr' => array(
                'class' => 'form-control',
            ),
            'expanded' => true,
            'multiple' => true,
        ];
        $builder
            ->add('fechaInicial', DateType::class, $opcionesFechaInicial)
            ->add('fechaFinal', DateType::class, $opcionesFechaFinal)
            ->add('fechaInicial2', DateType::class, $opcionesFechaInicial)
            ->add('fechaFinal2', DateType::class, $opcionesFechaFinal)
            ->add('fechaInicial3', DateType::class, $opcionesFechaInicial)
            ->add('fechaFinal3', DateType::class, $opcionesFechaFinal)
            ->add('fechaInicial4', DateType::class, $opcionesFechaInicial)
            ->add('fechaFinal4', DateType::class, $opcionesFechaFinal)
            ->add('fechaInicial5', DateType::class, $opcionesFechaInicial)
            ->add('fechaFinal5', DateType::class, $opcionesFechaFinal)
            ->add('fechaInicial6', DateType::class, $opcionesFechaInicial)
            ->add('fechaFinal6', DateType::class, $opcionesFechaFinal)
            ->add('fechaInicial7', DateType::class, $opcionesFechaInicial)
            ->add('fechaFinal7', DateType::class, $opcionesFechaFinal)
            ->add('fechaInicial8', DateType::class, $opcionesFechaInicial)
            ->add('fechaFinal8', DateType::class, $opcionesFechaFinal)
            ->add('fechaInicial9', DateType::class, $opcionesFechaInicial)
            ->add('fechaFinal9', DateType::class, $opcionesFechaFinal)
            ->add('fechaInicial10', DateType::class, $opcionesFechaInicial)
            ->add('fechaFinal10', DateType::class, $opcionesFechaFinal)
            ->add('fechaInicial11', DateType::class, $opcionesFechaInicial)
            ->add('fechaFinal11', DateType::class, $opcionesFechaFinal)
            ->add('fechaInicial12', DateType::class, $opcionesFechaInicial)
            ->add('fechaFinal12', DateType::class, $opcionesFechaFinal)
            ->add('documentoSolicitante', null, $opcionesDocumentoSolicitante)
            ->add('documentoTitular', null, $opcionesDocumentoTitular)
            ->add('documentoTitular2', null, $opcionesDocumentoTitular)
            ->add('documentoSolicitante2', null, $opcionesDocumentoSolicitante)
            ->add("concepto", EntityType::class, [
                'mapped' => false,
                'required' => false,
                'class' => 'AppBundle:Concepto',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy("c.nombre", "ASC");
                }
            ])
            ->add("seccional", EntityType::class, $opcionesSeccional)
            ->add("seccional3", EntityType::class, $opcionesSeccional)
            ->add("seccional4", EntityType::class, $opcionesSeccional)
            ->add("parentesco", EntityType::class, $opcionesParentesco)
            ->add("parentesco2", EntityType::class, $opcionesParentesco)
            ->add("grado", EntityType::class, $opcionesGrado)
            ->add("grado2", EntityType::class, $opcionesGrado)
            ->add("tipoSolicitud", EntityType::class, $opcionesTipo)
            ->add("tipoSolicitud2", EntityType::class, $opcionesTipo)
            ->add("estadoCivil", EntityType::class, $opcionesEstado)
            ->add("estadoCivil2", EntityType::class, $opcionesEstado)
            ->add("ingreso", EntityType::class, $opcionesIngresos)
            ->add("ingreso2", EntityType::class, $opcionesIngresos)
            ->add("personasCargo", EntityType::class, $opcionesPersonas)
            ->add("personasCargo2", EntityType::class, $opcionesPersonas)
            ->add("situacionVivienda", EntityType::class, $opcionesSituacion)
            ->add("situacionVivienda2", EntityType::class, $opcionesSituacion)
            ->add("motivoDeuda", EntityType::class, $opcionesMotivo)
            ->add("motivoDeuda2", EntityType::class, $opcionesMotivo)
            ->add("cantidadBeneficio", EntityType::class, [
                'mapped' => false,
                "label" => "Cantidad de beneficios AOS",
                'required' => false,
                'class' => 'AppBundle:Cantidadesbeneficio',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy("c.cantidadbeneficionombre", "ASC");
                }
            ])
            ->add("conceptoVisita", EntityType::class, [
                'mapped' => false,
                "label" => "Concepto de visita",
                'required' => false,
                'class' => 'AppBundle:Conceptosvisita',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy("c.conceptovisitanombre", "ASC");
                }
            ])
            ->add("afiliadoDibie", EntityType::class, [
                'mapped' => false,
                "label" => "Afiliado a DIBIE",
                'required' => false,
                'class' => 'AppBundle:Afiliadodibie',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy("a.afiliadodibiedesc", "ASC");
                }
            ])
            ->add("poblacionBeneficiada", EntityType::class, [
                'mapped' => false,
                "label" => "Población beneficiada",
                'required' => false,
                'class' => 'AppBundle:Poblacionbeneficia',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy("p.poblacionbeneficiadesc", "ASC");
                }
            ])
            ->add("viabilidadPlaneacion", EntityType::class, [
                "label" => "Viabilidad planeación",
                'mapped' => false,
                'required' => false,
                'class' => 'AppBundle:Viabilidadplaneacion',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->orderBy("v.viabilidadplaneacionconcepto", "ASC");
                }
            ])
            ->add("area", EntityType::class, $opcionesArea)
            ->add("area2", EntityType::class, $opcionesArea)
            ->add("zonaUbicacion", EntityType::class, [
                'mapped' => false,
                "label" => "Zona de ubicación",
                'required' => false,
                'class' => 'AppBundle:Zonasubicacion',
                'attr' => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('z')
                        ->orderBy("z.zonasubicacionnombre", "ASC");
                }
            ])
            ->add("programa", EntityType::class, $opcionesPrograma)
            ->add("programa2", EntityType::class, $opcionesPrograma)
            ->add("programa3", EntityType::class, $opcionesPrograma)
            ->add("area3", EntityType::class, $opcionesArea)
            ->add("agrupaciones", ChoiceType::class, $opcionesAgrupaciones)//dificultad
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Conceptosjunta::class,
            'crearResultadoDeportista' => null,
            'idUser' => null,
            'tipoIdentificacion' => null,
            'cedula' => null,
            'nombre' => null,
        ));
    }

}

<?php

namespace AppBundle\Form;

use AppBundle\Entity\Conceptosjunta;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormularioReportesType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
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
            'query_builder' => function(EntityRepository $er) {
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
            'query_builder' => function(EntityRepository $er) {
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
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('a')
                                ->orderBy("a.areanombre", "ASC");
            }
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
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                                ->orderBy("c.nombre", "ASC");
                    }
                ])
                ->add("seccional", EntityType::class, $opcionesSeccional)
                ->add("seccional3", EntityType::class, $opcionesSeccional)
                ->add("seccional4", EntityType::class, $opcionesSeccional)
                ->add("parentesco", EntityType::class, [
                    'mapped' => false,
                    'required' => false,
                    'class' => 'AppBundle:Parentescos',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                                ->orderBy("p.parentesconombre", "ASC");
                    }
                ])
                ->add("grado", EntityType::class, [
                    'mapped' => false,
                    'required' => false,
                    'class' => 'AppBundle:Grados',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('g')
                                ->orderBy("g.gradonombre", "ASC");
                    }
                ])
                ->add("tipoSolicitud", EntityType::class, [
                    'mapped' => false,
                    'label' => "Tipo de solicitud",
                    'required' => false,
                    'class' => 'AppBundle:Tipossolicitud',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('t')
                                ->orderBy("t.tiposolicitudnombre", "ASC");
                    }
                ])
                ->add("estadoCivil", EntityType::class, [
                    'mapped' => false,
                    "label" => "Estado civil",
                    'required' => false,
                    'class' => 'AppBundle:Estadosciviles',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('e')
                                ->orderBy("e.estadocivilnombre", "ASC");
                    }
                ])
                ->add("ingreso", EntityType::class, [
                    'mapped' => false,
                    'label' => "Ingresos",
                    'required' => false,
                    'class' => 'AppBundle:Ingresos',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('i')
                                ->orderBy("i.ingresonombre", "ASC");
                    }
                ])
                ->add("personasCargo", EntityType::class, [
                    'mapped' => false,
                    "label" => "Personas a cargo",
                    'required' => false,
                    'class' => 'AppBundle:Personascargo',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                                ->orderBy("p.personacargonombre", "ASC");
                    }
                ])
                ->add("situacionVivienda", EntityType::class, [
                    'mapped' => false,
                    "label" => "Situación de la vivienda",
                    'required' => false,
                    'class' => 'AppBundle:Situacionesvivienda',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                                ->orderBy("s.situacionviviendanombre", "ASC");
                    }
                ])
                ->add("motivoDeuda", EntityType::class, [
                    'mapped' => false,
                    "label" => "Motivo de deuda",
                    'required' => false,
                    'class' => 'AppBundle:Motivosdeuda',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('m')
                                ->orderBy("m.motivodeudanombre", "ASC");
                    }
                ])
                ->add("cantidadBeneficio", EntityType::class, [
                    'mapped' => false,
                    "label" => "Cantidad de beneficios",
                    'required' => false,
                    'class' => 'AppBundle:Cantidadesbeneficio',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                    'query_builder' => function(EntityRepository $er) {
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
                    'query_builder' => function(EntityRepository $er) {
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
                    'query_builder' => function(EntityRepository $er) {
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
                    'query_builder' => function(EntityRepository $er) {
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
                    'query_builder' => function(EntityRepository $er) {
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
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('z')
                                ->orderBy("z.zonasubicacionnombre", "ASC");
                    }
                ])
                ->add("programa", EntityType::class, $opcionesPrograma)
                ->add("programa2", EntityType::class, $opcionesPrograma)
                ->add("programa3", EntityType::class, $opcionesPrograma)
                ->add("programa4", EntityType::class, $opcionesPrograma)
        //dificultad
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
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

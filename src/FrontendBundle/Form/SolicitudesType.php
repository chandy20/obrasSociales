<?php

namespace FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SolicitudesType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $programas = $options['em']->getRepository('AppBundle:Programas')->findAll();
        $builder
                ->add('solicitudfecha', DateType::class, array(
                    'widget' => 'single_text',
                    "label" => "Fecha",
                    'required' => true,
                    'format' => 'yyyy-MM-dd',
                    'empty_value' => "",
                    'attr' => array('class' => 'form-control',
                    )
                ))
                ->add('idseccional', null, ["placeholder" => "Seleccione", "label" => "Seccional", 'required' => true, 'attr' => array('class' => 'form-control')])
                ->add('idtiposolicitud', null, ["placeholder" => "Seleccione", "label" => "Tipo de Solicitud", 'required' => true, 'attr' => array('class' => 'form-control', 'onchange' => 'mostrarFormulario()')])
                ->add('solicitudcedulasolicita', null, ["label" => "Cedula del Solicitante", 'required' => true, 'attr' => array('class' => 'form-control ', 'placeholder' => "Documento de identidad")])
                ->add('solicitudnombresolicita', null, ["label" => "Nombres y Apellidos del Solicitante", 'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => "Digita Nombres y Apellidos del Solicitante")])
                ->add('antiguedad', null, ["placeholder" => "Seleccione", "label" => "Antiguedad Funcionario", 'required' => false, 'attr' => array('class' => 'form-control')])
                ->add('idparentesco', null, ["placeholder" => "Seleccione", "label" => "Parentesco con el Solicitante", 'required' => true, 'attr' => array('class' => 'form-control')])
                ->add('solicitudcedulafuncionario', null, ["label" => "Cedula Funcionario Policial", 'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => "Digita Cedula Funcionario Policial")])
                ->add('idgrado', null, ["placeholder" => "Seleccione", "label" => "Grado Funcionario Policial", 'required' => true, 'attr' => array('class' => 'form-control')])
                ->add('unidad', null, ["placeholder" => "Seleccione", "label" => "unidad", 'required' => true, 'attr' => array('class' => 'form-control')])
                ->add('solicitudnombrefuncionario', null, ["label" => "Nombre del Funcionario Policial", 'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => "Digita Nombre Completo del Funcionario")])
                ->add('solicituddireccionfuncionario', null, ["label" => "Direccion Funcionario", 'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => "Digita Direccion del Funcionario")])
                ->add('solicitudtelefonosfuncionario', null, ["label" => "Telefono Funcionario", 'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => "Digita Telefono del Funcionario")])
                ->add('programas', ChoiceType::class, ["choices" => $programas, "placeholder" => "Seleccione", "mapped" => false, "multiple" => true, "label" => "Programa", 'required' => true, 'attr' => array('class' => 'form-control')])
                ->add('solicituddescripcion', null, ["label" => "Descripcion de la Solicitud", 'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => "Digita una descripcion para su Solicitud")])
                ->add('idestadocivil', null, ["placeholder" => "Seleccione", "label" => "Estado Civil", 'required' => false, 'attr' => array('class' => 'form-control')])
                ->add('idingreso', null, ["placeholder" => "Seleccione", "label" => "Ingresos", 'required' => false, 'attr' => array('class' => 'form-control')])
                ->add('idpersonacargo', null, ["placeholder" => "Seleccione", "label" => "Personas a Cargo", 'required' => false, 'attr' => array('class' => 'form-control')])
                ->add('idsituacionvivienda', null, ["placeholder" => "Seleccione", "label" => "Situacion de Vivienda", 'required' => false, 'attr' => array('class' => 'form-control')])
                ->add('idmotivodeuda', null, ["placeholder" => "Seleccione", "label" => "Dificultad", 'required' => false, 'attr' => array('class' => 'form-control')])
                ->add('cantidadesbeneficio', null, ["placeholder" => "Seleccione", "label" => "Cantidad Beneficios Recibidos AOS", 'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => "Digita la cantidad de Beneficios Recibidos")])
                ->add('idconceptovisita', null, ["placeholder" => "Seleccione", "label" => "Concepto Visita Domiciliaria", 'required' => false, 'attr' => array('class' => 'form-control')])
                ->add('idafiliadodibie', null, ["placeholder" => "Seleccione", "label" => "Afiliado a DIBIE?", 'required' => false, 'attr' => array('class' => 'form-control')])
                ->add('idpoblacionbeneficia', null, ["placeholder" => "Seleccione", "label" => "Cantidad de Poblacion a Beneficiar", 'required' => false, 'attr' => array('class' => 'form-control')])
                ->add('idviabilidadplaneacion', null, ["placeholder" => "Seleccione", "label" => "Viabilidad Planeacion", 'required' => false, 'attr' => array('class' => 'form-control')])
                ->add('idzonaubicacion', null, ["placeholder" => "Seleccione", "label" => "Zona de Ubicacion", 'required' => false, 'attr' => array('class' => 'form-control')])
                ->add('idcantidadesbeneficioinst', null, ["placeholder" => "Seleccione", "label" => "Cantidad Beneficio Institucionales", 'required' => false, 'attr' => array('class' => 'form-control')])
                ->add('curriculum', FileType::class, array('label' => 'Adjunte Documentación en formato .pdf', 'required' => false))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Solicitudes', 'em' => null));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'frontendbundle_solicitudes';
    }

}

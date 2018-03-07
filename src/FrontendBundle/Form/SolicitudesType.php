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
        $constraint = array(new \Symfony\Component\Validator\Constraints\NotBlank());
        $constraintEmail = array(new \Symfony\Component\Validator\Constraints\NotBlank(), new \Symfony\Component\Validator\Constraints\Email());
        $programas = $options['em']->getRepository('AppBundle:Programas')->findAll();
        $hoy = new \DateTime();
        $builder
                ->add('solicitudfecha', DateType::class, array(
                    'widget' => 'single_text',
                    'constraints' => $constraint,
                    "label" => "Fecha",
                    'format' => 'yyyy-MM-dd',
                    'empty_value' => "",
                    'data' => $hoy,
                    'attr' => array('class' => 'form-control',
                    )
                ))
                ->add('idseccional', null, ['constraints' => $constraint, "placeholder" => "Seleccione", "label" => "Seccional", 'attr' => array('class' => 'form-control')])
                ->add('idtiposolicitud', null, ['constraints' => $constraint, "placeholder" => "Seleccione", "label" => "Tipo de Solicitud", 'attr' => array('class' => 'form-control', 'onchange' => 'mostrarFormulario()')])
                ->add('solicitudcedulasolicita', null, ['constraints' => $constraint, "label" => "Cedula del Solicitante", 'attr' => array('class' => 'form-control ', 'onkeyup'=> "soloNumeros(this)", 'placeholder' => "Documento de identidad")])
                ->add('emailSolicitante', null, ['constraints' => $constraintEmail, "label" => "Correo Electrónico", 'attr' => array('class' => 'form-control ', 'placeholder' => "Correo electrónico")])
                ->add('documentoBeneficiarioFinal', null, ["label" => "Documento del beneficiario final", 'attr' => array('onkeyup'=> "soloNumeros(this)",'class' => 'form-control ', 'placeholder' => "Documento de identidad")])
                ->add('nombreBeneficiarioFinal', null, ["label" => "Nombre  del beneficiario final", 'attr' => array('class' => 'form-control ', 'placeholder' => "Nombre beneficiario")])
                ->add('solicitudnombresolicita', null, ['constraints' => $constraint, "label" => "Nombres y Apellidos del Solicitante", 'attr' => array('class' => 'form-control', 'placeholder' => "Digita Nombres y Apellidos del Solicitante")])
                ->add('antiguedad', null, ['constraints' => $constraint, "placeholder" => "Seleccione", "label" => "Antiguedad Funcionario", 'attr' => array('class' => 'form-control')])
                ->add('idparentesco', null, ['constraints' => $constraint, "placeholder" => "Seleccione", "label" => "Parentesco con el Solicitante", 'attr' => array('class' => 'form-control')])
                ->add('solicitudcedulafuncionario', null, ['constraints' => $constraint, 'constraints' => $constraint, "label" => "Cedula Funcionario Policial", 'attr' => array('onkeyup'=> "soloNumeros(this)",'class' => 'form-control', 'placeholder' => "Digita Cedula Funcionario Policial")])
                ->add('idgrado', null, ['constraints' => $constraint, "placeholder" => "Seleccione", "label" => "Grado Funcionario Policial", 'attr' => array('class' => 'form-control')])
                ->add('unidad', null, ['constraints' => $constraint, "placeholder" => "Seleccione", "label" => "unidad", 'attr' => array('class' => 'form-control')])
                ->add('solicitudnombrefuncionario', null, ['constraints' => $constraint, "label" => "Nombre del Funcionario Policial", 'attr' => array('class' => 'form-control', 'placeholder' => "Digita Nombre Completo del Funcionario")])
                ->add('solicituddireccionfuncionario', null, ['constraints' => $constraint, "label" => "Direccion Funcionario", 'attr' => array('class' => 'form-control', 'placeholder' => "Digita Direccion del Funcionario")])
                ->add('solicitudtelefonosfuncionario', null, ['constraints' => $constraint, "label" => "Telefono Funcionario", 'attr' => array('onkeyup'=> "soloNumeros(this)",'class' => 'form-control', 'placeholder' => "Digita Telefono del Funcionario")])
                ->add('programas', ChoiceType::class, ['constraints' => $constraint, "choices" => $programas, "placeholder" => "Seleccione", "mapped" => false, "multiple" => true, "label" => "Programa", 'attr' => array('class' => 'form-control')])
                ->add('solicituddescripcion', null, ['constraints' => $constraint, "label" => "Descripcion de la Solicitud", 'attr' => array('class' => 'form-control', 'placeholder' => "Digita una descripcion para su Solicitud")])
                ->add('idestadocivil', null, [ "placeholder" => "Seleccione", "label" => "Estado Civil", 'attr' => array('class' => 'form-control')])
                ->add('idingreso', null, ["placeholder" => "Seleccione", "label" => "Ingresos", 'attr' => array('class' => 'form-control')])
                ->add('idpersonacargo', null, ["placeholder" => "Seleccione", "label" => "Personas a Cargo", 'attr' => array('class' => 'form-control')])
                ->add('idsituacionvivienda', null, ["placeholder" => "Seleccione", "label" => "Situacion de Vivienda", 'attr' => array('class' => 'form-control')])
                ->add('idmotivodeuda', null, ["placeholder" => "Seleccione", "label" => "Dificultad", 'attr' => array('class' => 'form-control')])
                ->add('cantidadesbeneficio', null, ["placeholder" => "Seleccione", "label" => "Cantidad Beneficios Recibidos AOS", 'attr' => array('class' => 'form-control', 'placeholder' => "Digita la cantidad de Beneficios Recibidos")])
                ->add('idconceptovisita', null, ["placeholder" => "Seleccione", "label" => "Concepto Visita Domiciliaria", 'attr' => array('class' => 'form-control')])
                ->add('idafiliadodibie', null, ["placeholder" => "Seleccione", "label" => "Afiliado a DIBIE?", 'attr' => array('class' => 'form-control')])
                ->add('idpoblacionbeneficia', null, ['constraints' => $constraint, "placeholder" => "Seleccione", "label" => "Cantidad de Poblacion a Beneficiar", 'attr' => array('class' => 'form-control')])
                ->add('idviabilidadplaneacion', null, ['constraints' => $constraint, "placeholder" => "Seleccione", "label" => "Viabilidad Planeacion", 'attr' => array('class' => 'form-control')])
                ->add('idzonaubicacion', null, ['constraints' => $constraint, "placeholder" => "Seleccione", "label" => "Zona de Ubicacion", 'attr' => array('class' => 'form-control')])
                ->add('idcantidadesbeneficioinst', null, ['constraints' => $constraint, "placeholder" => "Seleccione", "label" => "Cantidad Beneficio Institucionales", 'attr' => array('class' => 'form-control')])
                ->add('curriculum', FileType::class, array('label' => 'Adjunte Documentación en formato .pdf', 'required' => false))
                ->add('fotoFile', FileType::class, array('label' => 'Fotografía del beneficiario (3x4)', 'required' => false))
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

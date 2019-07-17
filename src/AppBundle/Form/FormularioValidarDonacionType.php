<?php

namespace AppBundle\Form;

use AppBundle\Entity\Donacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormularioValidarDonacionType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $opciones = [
            'mapped' => false,
            "label" => "label.apobar.donacion",
            'required' => false,
            'choices' => [
                1 => 'Si',
                0 => 'No'
            ],
            'attr' => array(
                'class' => 'form-control',
            ),
            'empty_value' => 'label.seleccion',
            'expanded' => false,
            'multiple' => false,
        ];
        $builder
            ->add("aprobada", ChoiceType::class, $opciones)//dificultad
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Donacion::class,
            'crearResultadoDeportista' => null,
            'idUser' => null,
            'tipoIdentificacion' => null,
            'cedula' => null,
            'nombre' => null,
        ));
    }

}

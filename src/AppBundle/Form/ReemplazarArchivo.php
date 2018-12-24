<?php

namespace AppBundle\Form;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReemplazarArchivo extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', array(
                'data_class' => null,
                'label' => 'label.file',
                'constraints' => [
                    new NotBlank(),
                    new Assert\File([
                        'mimeTypes' => array(
                            "image/png",
                            "image/jpeg",
                            "image/jpg",
                            "application/pdf",
                            "application/x-pdf"
                        ),
                        'maxSize' => ini_get('upload_max_filesize'),
                        'mimeTypesMessage' => "Solo es posible cargar archivos pdf o imágenes"
                    ])
                ],
                'attr' => [
                    'accept' => '.png, .jpeg, .jpg, .pdf'
                ]
            ))
            ->add('template', 'hidden', array(
                'attr' => [
                    'value' => ""
                ]
            ));
    }

    public function getName()
    {
        parent::getName();

        return 'reemplazar_archivo';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null
        ));
    }

}

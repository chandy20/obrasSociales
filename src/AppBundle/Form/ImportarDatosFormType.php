<?php

namespace AppBundle\Form;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

class ImportarDatosFormType extends AbstractType {

  

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('file', 'file', array(
                    'data_class' => null,
                    'label' => 'label.file',
                    'constraints' => [
                        new NotBlank(),
                        new Assert\File([
                            'mimeTypes' => array(
                                'application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel',
                                'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel',
                                'application/xls', 'application/x-xls',
                                'application/*',
                                'text/csv'
                            ),
                            'maxSize' => ini_get('upload_max_filesize'),
                            'mimeTypesMessage' => "Solo es posible cargar archivos de excel (xls)"
                                ])
                    ],
                    'attr' => [
                        'accept' => '.xlsx, .xls'
                    ]
                ))
                ->add('template', 'hidden', array(
                    'attr' => [
                        'value' => ""
                    ]
                ))
        ;
    }

    public function getName() {
        parent::getName();

        return 'importar_datos';
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => null
        ));
    }

}

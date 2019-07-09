<?php

namespace AppBundle\Admin;

use DateTime;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\NotBlank;

class EventoAdmin extends AbstractAdmin
{

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
        $collection->remove('show');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombre')
            ->add('direccion')
            ->add('fecha');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('nombre')
            ->add('direccion')
            ->add('fecha')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $constraint = array(new NotBlank());
        $hoy = new DateTime();
        $formMapper
            ->add('nombre')
            ->add('ciudad', null, ['empty_value' => 'label.seleccion'])
            ->add('direccion', null, ['label' => 'label.direccion'])
            ->add('fecha', DateType::class, array(
                'widget' => 'single_text',
                'constraints' => $constraint,
                "label" => "Fecha",
                'format' => 'yyyy-MM-dd',
                'empty_value' => "",
                'data' => $hoy,
                'attr' => array('class' => 'form-control')
            ));
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nombre')
            ->add('direccion')
            ->add('fecha');
    }
}

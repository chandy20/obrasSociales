<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class DonadorAdmin extends AbstractAdmin
{

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombre')
            ->add('documento')
            ->add('representanteLegal')
            ->add('cargo')
            ->add('direccion')
            ->add('telefonoContacto1')
            ->add('telefonoContacto2')
            ->add('email')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('nombre')
            ->add('documento')
            ->add('representanteLegal')
            ->add('cargo')
            ->add('seccional')
            ->add('ciudad')
            ->add('direccion', null, ['label' => 'label.direccion'])
            ->add('telefonoContacto1', null, ['label' => 'label.tel1'])
            ->add('telefonoContacto2', null, ['label' => 'label.tel2'])
            ->add('email')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre')
            ->add('documento', null, ['label' => 'label.documento'])
            ->add('representanteLegal')
            ->add('cargo')
            ->add('ciudad', null, ['empty_value' => 'label.seleccion'])
            ->add('direccion', null, ['label' => 'label.direccion'])
            ->add('telefonoContacto1', null, ['label' => 'label.tel1'])
            ->add('telefonoContacto2', null, ['label' => 'label.tel2'])
            ->add('email')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nombre')
            ->add('documento')
            ->add('representanteLegal')
            ->add('cargo')
            ->add('direccion')
            ->add('telefonoContacto1')
            ->add('telefonoContacto2')
            ->add('email')
        ;
    }
}

<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class IngresosAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('ingresonombre', null, ["label" => "Ingresos"])
            ->add('ingresopuntaje', null, ["label" => "Puntaje"])
            ->add('ingresosestado', null, ["label" => "Estado"])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('ingresonombre', null, ["label" => "Ingresos"])
            ->add('ingresopuntaje', null, ["label" => "Puntaje"])
            ->add('ingresosestado', null, ["label" => "Estado"])
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('ingresonombre', null, ["label" => "Ingresos"])
            ->add('ingresopuntaje', null, ["label" => "Puntaje"])
            ->add('ingresosestado', null, ["label" => "Estado"])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('idingreso', null, ["label" => "Id"])
            ->add('ingresonombre', null, ["label" => "Ingresos"])
            ->add('ingresopuntaje', null, ["label" => "Puntaje"])
            ->add('ingresosestado', null, ["label" => "Estado"])
        ;
    }
}

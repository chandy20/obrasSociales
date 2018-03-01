<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PresupuestosAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('presupuestoanio', null, ["label" => "Presupuesto Anual"])
            ->add('presupuestomonto', null, ["label" => "Monto"])
            ->add('idarea')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('presupuestoanio', null, ["label" => "Presupuesto Anual"])
            ->add('presupuestomonto', null, ["label" => "Monto"])
            ->add('idarea')
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
            ->add('presupuestoanio', null, ["label" => "Presupuesto Anual"])
            ->add('presupuestomonto', null, ["label" => "Monto"])
            ->add('idarea')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('idpresupuestos')
            ->add('presupuestoanio', null, ["label" => "Presupuesto Anual"])
            ->add('presupuestomonto', null, ["label" => "Monto"])
            ->add('idarea')
        ;
    }
}

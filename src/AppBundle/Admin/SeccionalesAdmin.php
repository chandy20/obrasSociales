<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SeccionalesAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            
            ->add('seccionalnombre', null, ["label" => "Seccional"])
            ->add('SeccionalPresupuesto', null, ["label" => "Seccional Presupuesto"])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper

            ->add('seccionalnombre', null, ["label" => "Seccional"])
            ->add('SeccionalPresupuesto', null, ["label" => "Seccional Presupuesto"])
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
            ->add('seccionalnombre', null, ["label" => "Seccional"])
            ->add('SeccionalPresupuesto', null, ["label" => "Seccional Presupuesto"])
            

        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('idseccional')
            ->add('seccionalnombre', null, ["label" => "Seccional"])
            ->add('SeccionalPresupuesto', null, ["label" => "Seccional Presupuesto"])
        ;
    }
}

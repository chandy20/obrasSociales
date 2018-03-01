<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ViabilidadplaneacionAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('viabilidadplaneacionconcepto', null, ["label" => "Concepto Viabilidad Planeación"])
            ->add('viabilidadplaneacionpuntaje')
            ->add('viabilidadplaneacionestado')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('viabilidadplaneacionconcepto', null, ["label" => "Concepto Viabilidad Planeación"])
            ->add('viabilidadplaneacionpuntaje')
            ->add('viabilidadplaneacionestado')
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
            ->add('viabilidadplaneacionconcepto', null, ["label" => "Concepto Viabilidad Planeación"])
            ->add('viabilidadplaneacionpuntaje')
            ->add('viabilidadplaneacionestado')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('idviabilidadplaneacion')
            ->add('viabilidadplaneacionconcepto', null, ["label" => "Concepto Viabilidad Planeación"])
            ->add('viabilidadplaneacionpuntaje')
            ->add('viabilidadplaneacionestado')
        ;
    }
}

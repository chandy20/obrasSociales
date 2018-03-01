<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SituacionesviviendaAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('situacionviviendanombre', null, ["label" => "Situacion Vivienda"])
            ->add('situacionesviviendapuntaje')
            ->add('situacionesviviendaestado')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('situacionviviendanombre', null, ["label" => "Situacion Vivienda"])
            ->add('situacionesviviendapuntaje')
            ->add('situacionesviviendaestado')
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
            ->add('situacionviviendanombre', null, ["label" => "Situacion Vivienda"])
            ->add('situacionesviviendapuntaje')
            ->add('situacionesviviendaestado')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('idsituacionvivienda')
            ->add('situacionviviendanombre', null, ["label" => "Situacion Vivienda"])
            ->add('situacionesviviendapuntaje')
            ->add('situacionesviviendaestado')
        ;
    }
}

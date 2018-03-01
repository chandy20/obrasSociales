<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ConceptosvisitaAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('conceptovisitanombre', null, ["label" => "Concepto Visita Domicialiaria"])
            ->add('conceptosvisitapuntaje', null, ["label" => "Puntaje Visita"])
            ->add('conceptosvisitaestado', null, ["label" => "Estado Visita Domicialiaria"])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('conceptovisitanombre', null, ["label" => "Concepto Visita Domicialiaria"])
            ->add('conceptosvisitapuntaje', null, ["label" => "Puntaje Visita"])
            ->add('conceptosvisitaestado', null, ["label" => "Estado Visita Domicialiaria"])
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
            ->add('conceptovisitanombre', null, ["label" => "Concepto Visita Domicialiaria"])
            ->add('conceptosvisitapuntaje', null, ["label" => "Puntaje Visita"])
            ->add('conceptosvisitaestado', null, ["label" => "Estado Visita Domicialiaria"])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('conceptovisitanombre', null, ["label" => "Concepto Visita Domicialiaria"])
            ->add('conceptosvisitapuntaje', null, ["label" => "Puntaje Visita"])
            ->add('conceptosvisitaestado', null, ["label" => "Estado Visita Domicialiaria"])
        ;
    }
}

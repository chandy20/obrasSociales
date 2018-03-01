<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PersonascargoAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('personacargonombre', null, ["label" => "N° Personas a Cargo"])
            ->add('personascargopuntaje')
            ->add('personascargoestado')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('personacargonombre', null, ["label" => "N° Personas a Cargo"])
            ->add('personascargopuntaje')
            ->add('personascargoestado')
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
            ->add('personacargonombre', null, ["label" => "N° Personas a Cargo"])
            ->add('personascargopuntaje')
            ->add('personascargoestado')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('idpersonacargo')
            ->add('personacargonombre', null, ["label" => "N° Personas a Cargo"])
            ->add('personascargopuntaje')
            ->add('personascargoestado')
        ;
    }
}

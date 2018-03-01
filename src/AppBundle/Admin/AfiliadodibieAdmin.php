<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class AfiliadodibieAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('afiliadodibiedesc', null, ["label" => "Descripcion"])
            ->add('afiliadodibieporcentaje', null, ["label" => "Porcentaje"])
            ->add('afiliadodibieestado', null, ["label" => "Estado"])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('afiliadodibiedesc', null, ["label" => "Descripcion"])
            ->add('afiliadodibieporcentaje', null, ["label" => "Porcentaje"])
            ->add('afiliadodibieestado', null, ["label" => "Estado"])
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
            ->add('afiliadodibiedesc', null, ["label" => "Descripcion"])
            ->add('afiliadodibieporcentaje', null, ["label" => "Porcentaje"])
            ->add('afiliadodibieestado', null, ["label" => "Estado"])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('idafiliadodibie', null, ["label" => "Id"])
            ->add('afiliadodibiedesc', null, ["label" => "Descripcion"])
            ->add('afiliadodibieporcentaje', null, ["label" => "Porcentaje"])
            ->add('afiliadodibieestado', null, ["label" => "Estado"])
        ;
    }
}

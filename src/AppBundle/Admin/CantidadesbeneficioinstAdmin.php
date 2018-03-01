<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CantidadesbeneficioinstAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('cantidadesbeneficiodesc', null, ["label" => "Descripcion"])
            ->add('cantidadesbeneficioinstpuntaje', null, ["label" => "Puntanje"])
            ->add('cantidadesbeneficioinstestado', null, ["label" => "Estado"])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('cantidadesbeneficiodesc', null, ["label" => "Descripcion"])
            ->add('cantidadesbeneficioinstpuntaje', null, ["label" => "Puntanje"])
            ->add('cantidadesbeneficioinstestado', null, ["label" => "Estado"])
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
            ->add('cantidadesbeneficiodesc', null, ["label" => "Descripcion"])
            ->add('cantidadesbeneficioinstpuntaje', null, ["label" => "Puntanje"])
            ->add('cantidadesbeneficioinstestado', null, ["label" => "Estado"])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('idcantidadesbeneficioinst', null, ["label" => "ID"])
            ->add('cantidadesbeneficiodesc', null, ["label" => "Descripcion"])
            ->add('cantidadesbeneficioinstpuntaje', null, ["label" => "Puntanje"])
            ->add('cantidadesbeneficioinstestado', null, ["label" => "Estado"])
        ;
    }
}

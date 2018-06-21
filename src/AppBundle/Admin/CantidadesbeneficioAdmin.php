<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CantidadesbeneficioAdmin extends AbstractAdmin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('cantidadbeneficionombre', null, ["label" => "Nombre"])
                ->add('cantidadbeneficiopuntaje', null, ["label" => "Puntaje"])
                ->add('cantidadesbeneficioestado', null, ["label" => "Estado"])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('cantidadbeneficionombre', null, ["label" => "Nombre"])
                ->add('cantidadbeneficiopuntaje', null, ["label" => "Puntaje"])
                ->add('cantidadesbeneficioestado', null, ["label" => "Estado"])
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
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('cantidadbeneficionombre', null, ["label" => "Nombre"])
                ->add('cantidadbeneficiopuntaje', null, ["label" => "Puntaje"])
                ->add('cantidadesbeneficioestado', null, ["label" => "Estado"])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id')
                ->add('cantidadbeneficionombre', null, ["label" => "Nombre"])
                ->add('cantidadbeneficiopuntaje', null, ["label" => "Puntaje"])
                ->add('cantidadesbeneficioestado', null, ["label" => "Estado"])
        ;
    }

}

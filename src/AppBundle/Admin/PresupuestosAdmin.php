<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class PresupuestosAdmin extends AbstractAdmin {

    protected function configureRoutes(RouteCollection $collection) {
        $collection->remove('delete');
        $collection->remove('show');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('presupuestomonto', null, ["label" => "label.monto"])
                ->add('seccional', null, ["lable" => "label.seccional"])
                ->add('idarea', null, ["lable" => "label.area"])
                ->add('saldo', null, ["label" => "label.saldo"])
                ->add('desde', null, ["label" => "label.desde"])
                ->add('hasta', null, ["label" => "label.hasta"])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('presupuestomonto', null, ["label" => "label.monto"])
                ->add('seccional', null, ["label" => "label.seccional"])
                ->add('idarea', null, ["label" => "label.area"])
                ->add('saldo', null, ["label" => "label.saldo"])
                ->add('desde', null, ["label" => "label.desde"])
                ->add('hasta', null, ["label" => "label.hasta"])
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
                ->add('presupuestomonto', null, ["label" => "label.monto"])
                ->add('idarea', null, ["label" => "label.area"])
                ->add('seccional', null, ["label" => "label.seccional"])
                ->add('desde', 'sonata_type_date_picker', [
                    'widget' => 'single_text',
                    "label" => "label.desde",
                    'attr' => [
                    'format' => 'yyyy-MM-dd',
                        'class' => 'form-control input-inline datepicker',
                        'data-provide' => 'datepicker',
                        'data-date-format' => 'yyyy-mm-dd'
                    ]
                ])
                ->add('hasta', 'sonata_type_date_picker', [
                    "label" => "label.hasta",
                    'widget' => 'single_text',
                    'attr' => [
                    'format' => 'yyyy-MM-dd',
                        'class' => 'form-control input-inline datepicker',
                        'data-provide' => 'datepicker',
                        'data-date-format' => 'yyyy-mm-dd'
                    ]
                ]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('presupuestomonto', null, ["label" => "label.monto"])
                ->add('saldo', null, ["label" => "label.saldo"])
                ->add('desde', null, ["label" => "label.desde"])
                ->add('hasta', null, ["label" => "label.hasta"])
                ->add('idarea', null, ["label" => "label.area"])
        ;
    }

}

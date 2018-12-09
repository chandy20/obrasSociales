<?php

namespace AppBundle\Admin;

use AppBundle\Form\EventListener\Programa\AddAreaFieldSubscriber;
use AppBundle\Form\EventListener\Programa\AddProgramasFieldSubscriber;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProgramasAdmin extends AbstractAdmin {

    protected function configureRoutes(RouteCollection $collection) {
        $collection->add('ajax_programas_por_area', 'programasPorArea');
        $collection->add('ajax_programas_por_programa_padre', 'programasPorProgramaPadre');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('programanombre', null, ["label" => "Programa"])
                ->add('valorMes')
                ->add('idarea')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('programanombre', null, ["label" => "Nombre"])
                ->add('valorMes', null, ["label" => "Valor unidad"])
                ->add('idarea', null, ["label" => "Area"])
                ->add('programa', null, ["label" => "Programa"])
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
                ->add('programanombre', null, ["label" => "Nombre"])
                ->add('valorMes', null, ["label" => "Valor unidad"])
                ->add('idarea', EntityType::class, [
                    "class" => "AppBundle:Areas"
                ])
                ->add('programa', null, ["label" => "programa"])
                ->getFormBuilder()
                ->addEventSubscriber(new AddAreaFieldSubscriber())
                ->addEventSubscriber(new AddProgramasFieldSubscriber())
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('idprogramas')
                ->add('programanombre', null, ["label" => "Programa"])
                ->add('idarea')
        ;
    }

}

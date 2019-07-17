<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class DonacionAdmin extends AbstractAdmin
{

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
        $collection->remove('show');
        $collection->add('downloadPDF', $this->getRouterIdParameter() . '/pdf/download');
        $collection->add('validate', $this->getRouterIdParameter() . '/validate');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('monto');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('donador')
            ->add('evento')
            ->add('monto')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                    'validar' => [
                        'template' => 'AppBundle:Donate/btn:validate.html.twig'
                    ],
                    'pdf' => [
                        'template' => 'AppBundle:Donate/btn:pdf.html.twig'
                    ],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('donador', null, ['empty_value' => 'label.seleccion'])
            ->add('evento', null, ['empty_value' => 'label.seleccion'])
            ->add('monto');
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('monto');
    }
}

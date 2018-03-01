<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PoblacionbeneficiaAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('poblacionbeneficiadesc', null, ["label" => "Cantidad de Poblacion a Beneficiar"])
            ->add('poblacionbeneficiapuntaje')
            ->add('poblacionbeneficiaestado')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('poblacionbeneficiadesc', null, ["label" => "Cantidad de Poblacion a Beneficiar"])
            ->add('poblacionbeneficiapuntaje')
            ->add('poblacionbeneficiaestado')
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
            ->add('poblacionbeneficiadesc', null, ["label" => "Cantidad de Poblacion a Beneficiar"])
            ->add('poblacionbeneficiapuntaje')
            ->add('poblacionbeneficiaestado')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('idpoblacionbeneficia')
            ->add('poblacionbeneficiadesc', null, ["label" => "Cantidad de Poblacion a Beneficiar"])
            ->add('poblacionbeneficiapuntaje')
            ->add('poblacionbeneficiaestado')
        ;
    }
}

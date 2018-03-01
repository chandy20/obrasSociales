<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ConceptosjuntaAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('conceptojuntavalorb', null, ["label" => "Valor del Beneficio"])
            ->add('conceptojuntatiempo', null, ["label" => "Tiempo del Beneficio"])
            ->add('conceptojuntavalortotalb', null, ["label" => "Valor Total del Beneficio"])
            ->add('conceptosjuntadesc', null, ["label" => "Descripcion Junta"])
            ->add('conceptosjuntaotorgada', null, ["label" => "Otorga Beneficio?"])
            ->add('conceptosjuntanumacta', null, ["label" => "Numero Acta Aprobacion"])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('conceptojuntavalorb', null, ["label" => "Valor del Beneficio"])
            ->add('conceptojuntatiempo', null, ["label" => "Tiempo del Beneficio"])
            ->add('conceptojuntavalortotalb', null, ["label" => "Valor Total del Beneficio"])
            ->add('conceptosjuntadesc', null, ["label" => "Descripcion Junta"])
            ->add('conceptosjuntaotorgada', null, ["label" => "Otorga Beneficio?"])
            ->add('conceptosjuntanumacta', null, ["label" => "Numero Acta Aprobacion"])
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
            ->add('conceptojuntavalorb', null, ["label" => "Valor del Beneficio"])
            ->add('conceptojuntatiempo', null, ["label" => "Tiempo del Beneficio"])
            ->add('conceptojuntavalortotalb', null, ["label" => "Valor Total del Beneficio"])
            ->add('conceptosjuntadesc', null, ["label" => "Descripcion Junta"])
            ->add('conceptosjuntaotorgada', null, ["label" => "Otorga Beneficio?"])
            ->add('conceptosjuntanumacta', null, ["label" => "Numero Acta Aprobacion"])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('conceptojuntavalorb', null, ["label" => "Valor del Beneficio"])
            ->add('conceptojuntatiempo', null, ["label" => "Tiempo del Beneficio"])
            ->add('conceptojuntavalortotalb', null, ["label" => "Valor Total del Beneficio"])
            ->add('conceptosjuntadesc', null, ["label" => "Descripcion Junta"])
            ->add('conceptosjuntaotorgada', null, ["label" => "Otorga Beneficio?"])
            ->add('conceptosjuntanumacta', null, ["label" => "Numero Acta Aprobacion"])
        ;
    }
}

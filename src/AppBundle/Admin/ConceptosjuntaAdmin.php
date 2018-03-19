<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Movimiento;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\Pool;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

class ConceptosjuntaAdmin extends AbstractAdmin {

    protected $em;

    public function setConfigurationPool(Pool $configurationPool) {
        parent::setConfigurationPool($configurationPool);
        $this->em = $this->getConfigurationPool()->getContainer()->get("doctrine")->getManager();
    }

    protected function configureRoutes(RouteCollection $collection) {
        $collection->remove('delete');
        $collection->remove('create');
        $collection->add('reporte', 'reporte');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('solicitud.solicitudfecha', null, ["label" => "Fecha"])
                ->add('solicitud.concepto', null, ["label" => "Concepto previo"])
                ->add('solicitud.solicitudnombresolicita', null, ["label" => "Solicitante"])
                ->add('solicitud.solicitudcedulasolicita', null, ["label" => "Documento"])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('solicitud.solicitudfecha', null, ["label" => "Fecha"])
                ->add('solicitud.concepto', null, ["label" => "Concepto previo"])
                ->add('solicitud.solicitudnombresolicita', null, ["label" => "Solicitante"])
                ->add('solicitud.solicitudcedulasolicita', null, ["label" => "Documento"])
                ->add('aprobado', null, ["label" => "¿Aprobado?"])
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
                ->add('programasConcepto', null, ["label" => "programas"])
                ->add('conceptojuntatiempo', null, ["label" => "Tiempo del Beneficio (Meses)"])
                ->add('conceptosjuntadesc', null, ["label" => "Descripcion Junta"])
                ->add('conceptosjuntanumacta', null, ["label" => "Numero Acta Aprobación"])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
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

    public function validate(ErrorElement $errorElement, $object) {
        parent::validate($errorElement, $object);
        if (!$object->getConceptojuntatiempo()) {
            return $errorElement
                            ->with("conceptojuntatiempo")
                            ->addViolation('Este valor no debería estar vacío')
                            ->end();
        }
    }

}

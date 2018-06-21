<?php

namespace AppBundle\Admin;

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

    public function createQuery($context = 'list') {
        $query = parent::createQuery($context);
        $em = $this->getConfigurationPool()->getContainer()->get("doctrine")->getEntityManager();

        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($user->hasRole('ROLE_CONSULTOR')) {
            $query->join($query->getRootAliases()[0] . ".solicitud", "s")
                    ->where("s.idseccional = :seccional")
                    ->setParameter("seccional", $user->getSeccional());
        }
        return $query;
    }

    public function setConfigurationPool(Pool $configurationPool) {
        parent::setConfigurationPool($configurationPool);
        $this->em = $this->getConfigurationPool()->getContainer()->get("doctrine")->getManager();
    }

    protected function configureRoutes(RouteCollection $collection) {
        $collection->remove('delete');
        $collection->remove('create');
        $collection->add('reporte', 'reporte');
        $collection->add('dataReporte', 'dataReporte');
        $collection->add('downloadArchivo', $this->getRouterIdParameter() . '/downloadArchivo');
        $collection->add('downloadPDF', $this->getRouterIdParameter() . '/downloadPDF');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('solicitud.solicitudfecha', 'doctrine_orm_date', array('input_type' => 'date', "label" => "Fecha de la Solicitud"))
                ->add('solicitud.concepto', null, ["label" => "Concepto previo"])
                ->add('solicitud.solicitudnombresolicita', null, ["label" => "Solicitante"])
                ->add('solicitud.solicitudcedulasolicita', null, ["label" => "Documento"])
                ->add('solicitud.programas.programa.idarea', null, ["label" => "Área"])
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
                ->add('aprobado', null, ["label" => "¿Aprobado?"]);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($user->hasRole("ROLE_ADMIN") || $user->hasRole("ROLE_SUPER_ADMIN")) {
            $listMapper
                    ->add('_action', null, array(
                        'actions' => array(
                            'show' => array(),
                            'edit' => array(),
                            'delete' => array(),
                            'archivo' => array(
                                'template' => 'AppBundle:Solicitudes/btn:archivo.html.twig'
                            ),
//                            'pdf' => array(
//                                'template' => 'AppBundle:Solicitudes/btn:pdf.html.twig'
//                            ),
                        ),
                    ))
            ;
        }
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
                ->add('aprobado', null, ["label" => "¿Aprueba solicitud?"])
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

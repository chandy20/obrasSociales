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
use Sonata\AdminBundle\Form\Type\CollectionType;

class ConceptosjuntaAdmin extends AbstractAdmin
{

    protected $em;

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $em = $this->getConfigurationPool()->getContainer()->get("doctrine")->getEntityManager();

        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($user->hasRole('ROLE_CONSULTOR') && $user->getArea()) {
            $query
                ->join($query->getRootAliases()[0] . ".solicitud", "s")
                ->join("s.programas", "ps")
                ->join("ps.programa", "p")
                ->where("p.idarea = :area")
                ->andWhere("s.idseccional = :seccional")
                ->setParameter("seccional", $user->getSeccional())
                ->setParameter("area", $user->getArea());

        } else if ($user->hasRole('ROLE_CONSULTOR')) {
            $query->where($query->getRootAliases()[0] . ".idseccional = :seccional")
                ->setParameter("seccional", $user->getSeccional());
        }else if ($user->hasROle('ROLE_LIDER')) {
            $query->join($query->getRootAliases()[0] . ".solicitud", "s")
                ->join('s.programas', 'ps')
                ->join("ps.programa", "p")
                ->where("p.idarea = :area")
                ->setParameter("area", $user->getArea());
        }

        return $query;
    }

    public function setConfigurationPool(Pool $configurationPool)
    {
        parent::setConfigurationPool($configurationPool);
        $this->em = $this->getConfigurationPool()->getContainer()->get("doctrine")->getManager();
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
        $collection->remove('create');
        $collection->add('reporte', 'reporte');
        $collection->add('dataReporte', 'dataReporte');
        $collection->add('exportarReporteAgrupaciones', 'exportarReporteAgrupaciones');
        $collection->add('downloadArchivo', $this->getRouterIdParameter() . '/downloadArchivo');
        $collection->add('downloadPDF', $this->getRouterIdParameter() . '/downloadPDF');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('solicitud.solicitudfecha', 'doctrine_orm_date_range', [
                "label" => "Fecha de la Solicitud",
                'field_type' => 'sonata_type_date_range_picker',
                'field_options' => [
                    'field_options' => [
                        'format' => 'yyyy-MM-dd'
                    ],
                ]
            ])
            ->add('solicitud.concepto', null, ["label" => "Concepto previo"])
            ->add('solicitud.solicitudnombresolicita', null, ["label" => "Solicitante"])
            ->add('solicitud.solicitudcedulasolicita', null, ["label" => "Documento"])
            ->add('solicitud.programas.programa.idarea', null, ["label" => "Área"])
            ->add('solicitud.programas.programa', null, ["label" => "Programa"])
            ->add('solicitud.idseccional', null, ["label" => "Seccional"]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('solicitud.solicitudfecha', null, ["label" => "Fecha"])
            ->add('solicitud.concepto', null, ["label" => "Concepto previo"])
            ->add('solicitud.solicitudnombresolicita', null, ["label" => "Solicitante"])
            ->add('solicitud.solicitudcedulasolicita', null, ["label" => "Documento"])
            ->add('conceptosjuntadesc', null, ["label" => "Descripcion Junta"])
            ->add('conceptosjuntanumacta', null, ["label" => "Número Acta Aprobación"])
            ->add('aprobado', null, [
                'template' => 'AppBundle:ConceptoJunta:aprobado.html.twig',
                'label' => '¿Aprobado?'
            ]);
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($user->hasRole("ROLE_ADMIN") || $user->hasRole("ROLE_SUPER_ADMIN") || $user->hasRole("ROLE_LIDER")) {
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
                ));
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $object = $this->getSubject();
        $formMapper
            ->add('programasConcepto', 'sonata_type_collection', [
                'btn_add' => false,
                'type_options' => array(
                    // Prevents the "Delete" option from being displayed
                    'delete' => false,
                    'delete_options' => array(
                        // You may otherwise choose to put the field but hide it
                        'type' => 'hidden',
                        // In that case, you need to fill in the options as well
                        'type_options' => array(
                            'mapped' => false,
                            'required' => false,
                        )
                    )
                )
            ], [
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ])
            ->add('conceptosjuntadesc', null, ["label" => "Descripcion Junta"])
            ->add('conceptosjuntanumacta', null, ["label" => "Número Acta Aprobación"])
            ->add('aprobado', null, [
                "label" => "¿Aprueba solicitud?",
                'data' => $object->getAprobado()
            ]);
        if ($object->getEditado()) {
            $formMapper
                ->add('numeroActaModificacion', null, ["label" => "Número Acta Modificación"]);
        }
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
            ->add('conceptosjuntanumacta', null, ["label" => "Número Acta Aprobacion"]);
    }

}

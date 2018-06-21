<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SolicitudesAdmin extends AbstractAdmin {
    
    public function createQuery($context = 'list') {

        $query = parent::createQuery($context);
        $em = $this->getConfigurationPool()->getContainer()->get("doctrine")->getEntityManager();

        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($user->hasRole('ROLE_CONSULTOR')) {
            $query->where($query->getRootAliases()[0] . ".idseccional = :seccional")
                    ->setParameter("seccional", $user->getSeccional());
        }
        return $query;
    }

    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) {
        $collection->remove('delete');
        $collection->remove('create');
        $collection->remove('edit');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('solicitudfecha', 'doctrine_orm_date', array('input_type' => 'date', "label" => "Fecha de la Solicitud"))
                ->add('solicitudcedulasolicita', null, ["label" => "Cedula del Solicitante"])
                ->add('idparentesco', null, ["label" => "Parentesco con el Solicitante"])
                ->add('solicitudcedulafuncionario', null, ["label" => "Cedula Funcionario Policial"])
                ->add('idgrado', null, ["label" => "Grado Funcionario Policial"])
                ->add('antiguedad', null, ["label" => "Antiguedad Funcionario"])
                ->add('idtiposolicitud', null, ["label" => "Tipo de Solicitud"])
                ->add('idestadocivil', null, ["label" => "Estado Civil"])
                ->add('idingreso', null, ["label" => "Ingresos"])
                ->add('idsituacionvivienda', null, ["label" => "Situacion de Vivienda"])
                ->add('idmotivodeuda', null, ["label" => "Motivo Deuda"])
                ->add('idafiliadodibie', null, ["label" => "Afiliado a DIBIE?"])
                ->add('idviabilidadplaneacion', null, ["label" => "Viabilidad Planeacion"])
                ->add('idseccional', null, ["label" => "Seccional"])
                ->add('totalPuntaje', null, ["label" => "Puntaje total"])
                ->add('concepto', null, ["label" => "Concepto Previo"])
                ->add('conceptoFinal', null, ["label" => "Concepto Junta"])
                ->add('otorga', null, ["label" => "Otorga Beneficio"])
                ->add('programas.programa.idarea', null, ["label" => "Área"])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('solicitudfecha', null, ["label" => "Fecha de la Solicitud"])
                ->add('solicitudcedulasolicita', null, ["label" => "Cedula del Solicitante"])
                ->add('solicitudnombresolicita', null, ["label" => "Nombre del Solicitante"])
                ->add('idparentesco', null, ["label" => "Parentesco con el Solicitante"])
                ->add('solicitudcedulafuncionario', null, ["label" => "Cedula Funcionario Policial"])
                ->add('idgrado', null, ["label" => "Grado Funcionario Policial"])
                ->add('solicituddireccionfuncionario', null, ["label" => "Direccion Funcionario"])
                ->add('solicitudtelefonosfuncionario', null, ["label" => "Telefono Funcionario"])
                ->add('solicitudnombrefuncionario', null, ["label" => "Nombre del Funcionario"])
                ->add('antiguedad', null, ["label" => "Antiguedad Funcionario:"])
                ->add('solicituddescripcion', null, ["label" => "Descripcion de la Solicitud"])
                ->add('idtiposolicitud', null, ["label" => "Tipo de Solicitud"])
                ->add('idestadocivil', null, ["label" => "Estado Civil"])
                ->add('idingreso', null, ["label" => "Ingresos"])
                ->add('idpersonacargo', null, ["label" => "Cantidad de Personas a Cargo"])
                ->add('idsituacionvivienda', null, ["label" => "Situacion de Vivienda"])
                ->add('idmotivodeuda', null, ["label" => "Motivo Deuda"])
                ->add('idcantidadesbeneficioinst', null, ["label" => "Cantidad de beneficios recibidos por AOS - UNIDAD"])
                ->add('idafiliadodibie', null, ["label" => "Afiliado a DIBIE?"])
                ->add('idpoblacionbeneficia', null, ["label" => "Cantidad de Poblacion a Beneficiar"])
                ->add('idviabilidadplaneacion', null, ["label" => "Viabilidad Planeacion"])
                ->add('idzonaubicacion', null, ["label" => "Zona de Ubicacion"])
                ->add('idconceptovisita', null, ["label" => "Concepto Visita Domiciliaria"])
                ->add('idseccional', null, ["label" => "Seccional"])
                ->add('totalPuntaje', null, ["label" => "Puntaje total", 'required' => false])
                ->add('concepto', null, ["label" => "Concepto Previo"])
                ->add('conceptoFinal', null, ["label" => "Concepto Junta"])
                ->add('cantidadSolicitada', null, ["label" => "Cantidad solicitada (Mes)", 'required' => false])
                ->add('cantidadAprobada', null, ["label" => "Cantidad Aprobada", 'required' => false])
                ->add('programas', null, ["label" => "Programas", 'required' => false])
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
                ->add('solicitudfecha', null, ["label" => "Fecha de la Solicitud"])
                ->add('solicitudcedulasolicita', null, ["label" => "Cedula del Solicitante"])
                ->add('solicitudnombresolicita', null, ["label" => "Nombre del Solicitante"])
                ->add('idparentesco', null, ["label" => "Parentesco con el Solicitante"])
                ->add('solicitudcedulafuncionario', null, ["label" => "Cedula Funcionario Policial"])
                ->add('idgrado', null, ["label" => "Grado Funcionario Policial"])
                ->add('solicituddireccionfuncionario', null, ["label" => "Direccion Funcionario"])
                ->add('solicitudtelefonosfuncionario', null, ["label" => "Telefono Funcionario"])
                ->add('solicitudnombrefuncionario', null, ["label" => "Nombre del Funcionario"])
                ->add('antiguedad', null, ["label" => "Antiguedad Funcionario:"])
                ->add('solicituddescripcion', null, ["label" => "Descripcion de la Solicitud"])
                ->add('idtiposolicitud', null, ["label" => "Tipo de Solicitud"])
                ->add('idestadocivil', null, ["label" => "Estado Civil"])
                ->add('idingreso', null, ["label" => "Ingresos"])
                ->add('idpersonacargo', null, ["label" => "Cantidad de Personas a Cargo"])
                ->add('idsituacionvivienda', null, ["label" => "Situacion de Vivienda"])
                ->add('idmotivodeuda', null, ["label" => "Motivo Deuda"])
                ->add('idcantidadesbeneficioinst', null, ["label" => "Cantidad de beneficios recibidos por AOS - UNIDAD"])
                ->add('idafiliadodibie', null, ["label" => "Afiliado a DIBIE?"])
                ->add('idpoblacionbeneficia', null, ["label" => "Cantidad de Poblacion a Beneficiar"])
                ->add('idviabilidadplaneacion', null, ["label" => "Viabilidad Planeacion"])
                ->add('idzonaubicacion', null, ["label" => "Zona de Ubicacion"])
                ->add('idconceptovisita', null, ["label" => "Concepto Visita Domiciliaria"])
                ->add('idseccional', null, ["label" => "Seccional"])
                ->add('totalPuntaje', null, ["label" => "Puntaje total", 'required' => false])
                ->add('concepto', null, ["label" => "Concepto Previo"])
                ->add('conceptoFinal', null, ["label" => "Concepto Junta"])
                ->add('cantidadSolicitada', null, ["label" => "Cantidad solicitada", 'required' => false])
                ->add('cantidadAprobada', null, ["label" => "Cantidad Aprobada", 'required' => false])
                ->add('programas', null, ["label" => "Programas", 'required' => false])
        ;
    }

    public function getExportFields() {
        return array(
            "Fecha de la Solicitud" => 'solicitudfecha',
            "Cédula del Solicitante" => 'solicitudcedulasolicita',
            "Nombre del Solicitante" => 'solicitudnombresolicita',
            "Parentesco con el Solicitante" => 'idparentesco',
            "Cédula Funcionario Policial" => 'solicitudcedulafuncionario',
            "Grado Funcionario Policial" => 'idgrado',
            "Dirección Funcionario" => 'solicituddireccionfuncionario',
            "Teléfono Funcionario" => 'solicitudtelefonosfuncionario',
            "Nombre del Funcionario" => 'solicitudnombrefuncionario',
            "Antiguedad Funcionario" => 'antiguedad',
            "Descripción de la Solicitud" => 'solicituddescripcion',
            "Tipo de Solicitud" => 'idtiposolicitud',
            "Estado Civil" => 'idestadocivil',
            "Ingresos" => 'idingreso',
            "Cantidad de Personas a Cargo" => 'idpersonacargo',
            "Situación de Vivienda" => 'idsituacionvivienda',
            "Motivo Deuda" => 'idmotivodeuda',
            "Cantidad de beneficios recibidos por AOS - UNIDAD" => 'idcantidadesbeneficioinst',
            "Afiliado a DIBIE?" => 'idafiliadodibie',
            "Cantidad de Poblacion a Beneficiar" => 'idpoblacionbeneficia',
            "Viabilidad Planeación" => 'idviabilidadplaneacion',
            "Zona de Ubicacion" => 'idzonaubicacion',
            "Concepto Visita Domiciliaria" => 'idconceptovisita',
            "Seccional" => 'idseccional',
            "Puntaje total" => 'totalPuntaje',
            "Concepto Previo" => 'concepto',
            "Concepto Junta" => 'conceptoFinal',
            "Cantidad solicitada" => 'cantidadSolicitada',
            "Cantidad Aprobada" => 'cantidadAprobada',
            "Programas" => 'programasArray',
        );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('solicitudfecha', null, ["label" => "Fecha de la Solicitud"])
                ->add('solicitudcedulasolicita', null, ["label" => "Cedula del Solicitante"])
                ->add('solicitudnombresolicita', null, ["label" => "Nombre del Solicitante"])
                ->add('idparentesco', null, ["label" => "Parentesco con el Solicitante"])
                ->add('solicitudcedulafuncionario', null, ["label" => "Cedula Funcionario Policial"])
                ->add('idgrado', null, ["label" => "Grado Funcionario Policial"])
                ->add('solicituddireccionfuncionario', null, ["label" => "Direccion Funcionario"])
                ->add('solicitudtelefonosfuncionario', null, ["label" => "Telefono Funcionario"])
                ->add('solicitudnombrefuncionario', null, ["label" => "Nombre del Funcionario"])
                ->add('antiguedad', null, ["label" => "Antiguedad Funcionario:"])
                ->add('solicituddescripcion', null, ["label" => "Descripcion de la Solicitud"])
                ->add('idtiposolicitud', null, ["label" => "Tipo de Solicitud"])
                ->add('idestadocivil', null, ["label" => "Estado Civil"])
                ->add('idingreso', null, ["label" => "Ingresos"])
                ->add('idpersonacargo', null, ["label" => "Cantidad de Personas a Cargo"])
                ->add('idsituacionvivienda', null, ["label" => "Situacion de Vivienda"])
                ->add('idmotivodeuda', null, ["label" => "Motivo Deuda"])
                ->add('idcantidadesbeneficioinst', null, ["label" => "Cantidad de beneficios recibidos por AOS - UNIDAD"])
                ->add('idafiliadodibie', null, ["label" => "Afiliado a DIBIE?"])
                ->add('idpoblacionbeneficia', null, ["label" => "Cantidad de Poblacion a Beneficiar"])
                ->add('idviabilidadplaneacion', null, ["label" => "Viabilidad Planeacion"])
                ->add('idzonaubicacion', null, ["label" => "Zona de Ubicacion"])
                ->add('idconceptovisita', null, ["label" => "Concepto Visita Domiciliaria"])
                ->add('idseccional', null, ["label" => "Seccional"])
                ->add('totalPuntaje', null, ["label" => "Puntaje total", 'required' => false])
                ->add('concepto', null, ["label" => "Concepto Previo"])
                ->add('conceptoFinal', null, ["label" => "Concepto Junta"])
                ->add('cantidadSolicitada', null, ["label" => "Cantidad solicitada", 'required' => false])
                ->add('cantidadAprobada', null, ["label" => "Cantidad Aprobada", 'required' => false])
                ->add('programas', null, ["label" => "Programas", 'required' => false]);
    }
    
    public function getTemplate($name) {
        switch ($name) {
            case 'show':
                return 'AppBundle:Solicitudes:base_show.html.twig';
            default:
                return parent::getTemplate($name);
        }
    }

}

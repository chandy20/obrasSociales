<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SolicitudesAdmin extends AbstractAdmin {

    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) {
         $collection->remove('delete'); 
         $collection->remove('create'); 
    }
    
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
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
                ->add('otorga', null, ["label" => "Otorga Beneficio"])
                ->add('cantidadSolicitada', null, ["label" => "Cantidad solicitada", 'required' => false])
                ->add('cantidadAprobada', null, ["label" => "Cantidad Aprobada", 'required' => false])
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
                ->add('cantidadSolicitada', null, ["label" => "Cantidad solicitada", 'required' => false])
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
                ->add('otorga', null, ["label" => "Otorga Beneficio?"])
                ->add('ValorBeneficio', null, ["label" => "valor beneficio:", 'required' => false])
                ->add('TiempoBeneficio', null, ["label" => "Tiempo del Beneficio"])
                ->add('Acta', null, ["label" => "Numero de Acta:"])

        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id')
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
                ->add('solicitudconceptopre', null, ["label" => "Concepto Previo"])
                ->add('otorga', null, ["label" => "Otorga Beneficio?:"])
                ->add('ValorBeneficio', null, ["label" => "valor beneficio:", 'required' => false])
                ->add('TiempoBeneficio', null, ["label" => "Tiempo del Beneficio:"])
                ->add('Acta', null, ["label" => "Numero de Acta:"])
        ;
    }

}

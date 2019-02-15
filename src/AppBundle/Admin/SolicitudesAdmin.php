<?php

namespace AppBundle\Admin;

use AppBundle\Form\EventListener\AddAreaFieldSubscriber;
use AppBundle\Form\EventListener\AddProgramaPadreFieldSubscriber;
use AppBundle\Form\EventListener\AddProgramasFieldSubscriber;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\DateRangeType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class SolicitudesAdmin extends AbstractAdmin
{

    public function createQuery($context = 'list')
    {

        $query = parent::createQuery($context);
        $em = $this->getConfigurationPool()->getContainer()->get("doctrine")->getEntityManager();

        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($user->hasRole('ROLE_CONSULTOR') && $user->getArea()) {
            $query
                ->join($query->getRootAliases()[0] . ".programas", "ps")
                ->join("ps.programa", "p")
                ->where("p.idarea = :area")
                ->andWhere($query->getRootAliases()[0] . ".idseccional = :seccional")
                ->setParameter("seccional", $user->getSeccional())
                ->setParameter("area", $user->getArea());

        } else if ($user->hasRole('ROLE_CONSULTOR')) {
            $query->where($query->getRootAliases()[0] . ".idseccional = :seccional")
                ->setParameter("seccional", $user->getSeccional());
        }else if ($user->hasROle('ROLE_LIDER')) {
            $query->join($query->getRootAliases()[0] . ".programas", "ps")
                ->join("ps.programa", "p")
                ->where("p.idarea = :area")
                ->setParameter("area", $user->getArea());
        }
        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
//        $collection->remove('edit');
        $collection->add('importar', 'importar');
        $collection->add('consultar', 'consultar');
        $collection->add('replaceFile', $this->getRouterIdParameter() . '/sustituir/archivo');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('solicitudfecha', 'doctrine_orm_date_range', [
                "label" => "Fecha de la Solicitud",
                'field_type' => 'sonata_type_date_range_picker',
                'field_options' => [
                    'field_options' => [
                        'format' => 'yyyy-MM-dd'
                    ],
                ]
            ])
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
            ->add('programas.programa.idarea', null, ["label" => "Área"]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('solicitudfecha', null, ["label" => "Fecha de la Solicitud"])
            ->add('solicitudcedulasolicita', null, ["label" => "Cedula del Solicitante"])
            ->add('solicitudnombresolicita', null, ["label" => "Nombre del Solicitante"])
            ->add('solicitudcedulafuncionario', null, ["label" => "Cedula Funcionario Policial"])
            ->add('idgrado', null, ["label" => "Grado Funcionario Policial"])
            ->add('solicitudnombrefuncionario', null, ["label" => "Nombre del Funcionario"])
            ->add('idtiposolicitud', null, ["label" => "Tipo de Solicitud"])
            ->add('idseccional', null, ["label" => "Seccional"])
            ->add('concepto', null, ["label" => "Concepto Previo"])
            ->add('conceptoFinal', null, ["label" => "Concepto Junta"])
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                    'archivo' => array(
                        'template' => 'AppBundle:Solicitudes/btn:reemplazar.archivo.html.twig'
                    ),
                ),
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $usuario = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $seccional = null;
        $readOnlySeccional = false;
        if ($usuario->getSeccional()) {
            $seccional = $usuario->getSeccional();
            $readOnlySeccional = true;
        }
        $constraint = array(new NotBlank());
        $constraintEmail = array(new NotBlank(), new Email());
        $hoy = new DateTime();
        $formMapper
            ->add('solicitudfecha', DateType::class, array(
                'widget' => 'single_text',
                'constraints' => $constraint,
                "label" => "Fecha",
                'format' => 'yyyy-MM-dd',
                'empty_value' => "",
                'data' => $hoy,
                'attr' => array('class' => 'form-control', 'readonly' => true)
            ))
            ->add('idseccional', null, [
                    'constraints' => $constraint,
                    "placeholder" => "Seleccione",
                    "label" => "Seccional",
                    "data" => $seccional,
                    'attr' => array('class' => 'form-control',
                        'onmouseover' => "this.disabled=" . $readOnlySeccional,
                        'onmouseout' => "this.disabled=" . $readOnlySeccional)
                ]
            )
            ->add('idtiposolicitud', null, [
                'constraints' => $constraint,
                "placeholder" => "Seleccione",
                "label" => "Tipo de Solicitud",
                'attr' =>
                    [
                        'onchange' => 'mostrarFormulario()',
                        'class' => 'tipo_solicitud',
                    ]
            ])
            ->add('solicitudcedulasolicita', null, [
                    'required' => false,
                    'constraints' => $constraint,
                    "label" => "Cédula del Solicitante",
                    'attr' => array('class' => 'form-control ', 'onkeyup' => "soloNumeros(this)", 'placeholder' => "Documento de identidad")]
            )
            ->add('emailSolicitante', null, [
                    'required' => false,
                    'constraints' => $constraintEmail,
                    "label" => "Correo Electrónico",
                    'attr' => array('class' => 'form-control ', 'placeholder' => "Correo electrónico")]
            )
            ->add('documentoBeneficiarioFinal', null, [
                    "label" => "Documento del beneficiario final",
                    'required' => false,
                    'attr' => array('onkeyup' => "soloNumeros(this)",
                        'class' => 'form-control ',
                        'placeholder' => "Documento de identidad")]
            )
            ->add('nombreBeneficiarioFinal', null, [
                    'required' => false,
                    "label" => "Nombre  del beneficiario final",
                    'attr' => array('class' => 'form-control ', 'placeholder' => "Nombre beneficiario")]
            )
            ->add('solicitudnombresolicita', null, [
                    'required' => false,
                    'constraints' => $constraint,
                    "label" => "Nombres y Apellidos del Solicitante",
                    'attr' => array('class' => 'form-control', 'placeholder' => "Digita Nombres y Apellidos del Solicitante")]
            )
            ->add('antiguedad', null, [
                    "placeholder" => "Seleccione",
                    "label" => "Antigüedad Funcionario",
                    'attr' => array('class' => 'form-control  fallecido')]
            )
            ->add('idparentesco', null, [
                    "placeholder" => "Seleccione",
                    "label" => "Parentesco con el Solicitante",
                    'attr' => array('class' => 'form-control')]
            )
            ->add('solicitudcedulafuncionario', null, [
                    'required' => false,
                    "label" => "Cédula Funcionario Policial",
                    'attr' => array('onkeyup' => "soloNumeros(this)", 'class' => 'form-control', 'placeholder' => "Digita Cedula Funcionario Policial")]
            )
            ->add('idgrado', null, [
                    "placeholder" => "Seleccione",
                    "label" => "Grado Funcionario Policial",
                    'attr' => array('class' => 'form-control gradoFuncionario')]
            )
            ->add('unidad', null, [
                    "placeholder" => "Seleccione",
                    "label" => "unidad", 'attr' => array('class' => 'form-control fallecido')]
            )
            ->add('solicitudnombrefuncionario', null, [
                    'required' => false,
                    "label" => "Nombre del Funcionario Policial",
                    'attr' => array('class' => 'form-control  fallecido',
                        'placeholder' => "Digita Nombre Completo del Funcionario")]
            )
            ->add('direccionSolicitante', null, [
                    'required' => false,
                    "label" => "Dirección",
                    'attr' => array('class' => 'form-control')
                ]
            )
            ->add('telefonoSolicitante', null, [
                    'required' => false,
                    "label" => "Teléfono",
                    'attr' => array('onkeyup' => "soloNumeros(this)",
                        'class' => 'form-control')]
            )
            ->add('telefonoSolicitante2', null, [
                    'required' => false,
                    "label" => "Teléfono alterno",
                    'attr' => array('onkeyup' => "soloNumeros(this)",
                        'class' => 'form-control')]
            )
            ->add('programas', null, [
                    'class' => "AppBundle:Programas",
                    'label' => "Seleccione los programas para los cuales necesita asistencia",
                    'constraints' => $constraint,
                    'query_builder' => function (EntityRepository $repository) {
                        return $repository->createQueryBuilder('p')->orderBy('p.programanombre', 'ASC');
                    },
                    "placeholder" => "Seleccione",
                    'required' => false,
                    "mapped" => false,
                    "multiple" => true,
                    "expanded" => true]
            )
            ->add('solicituddescripcion', null, [
                    'required' => false,
                    'constraints' => $constraint,
                    "label" => "Descripción breve de la solicitud y de la situación económica",
                    'attr' => array('class' => 'form-control',
                        'placeholder' => "Digite una descripción para su Solicitud")]
            )
            ->add('idestadocivil', null, [
                    "placeholder" => "Seleccione",
                    "label" => "Estado Civil",
                    'attr' => array('class' => 'form-control')]
            )
            ->add('idingreso', null, [
                    "placeholder" => "Seleccione",
                    "label" => "Ingresos",
                    'attr' => array('class' => 'form-control')]
            )
            ->add('idpersonacargo', null, [
                    "placeholder" => "Seleccione",
                    "label" => "Personas a Cargo",
                    'attr' => array('class' => 'form-control')]
            )
            ->add('idsituacionvivienda', null, [
                    "placeholder" => "Seleccione",
                    "label" => "Situación de Vivienda",
                    'attr' => array('class' => 'form-control')]
            )
            ->add('idmotivodeuda', null, [
                    "placeholder" => "Seleccione",
                    "label" => "Dificultad",
                    'attr' => array('class' => 'form-control')]
            )
            ->add('cantidadesbeneficio', null, [
                    "placeholder" => "Seleccione",
                    "label" => "Cantidad Beneficios Recibidos AOS",
                    'attr' => array('class' => 'form-control',
                        'placeholder' => "Digita la cantidad de Beneficios Recibidos")]
            )
            ->add('idconceptovisita', null, [
                    "placeholder" => "Seleccione",
                    "label" => "Concepto Visita Domiciliaria",
                    'attr' => array('class' => 'form-control')]
            )
            ->add('idafiliadodibie', null, [
                    "placeholder" => "Seleccione",
                    "label" => "Afiliado a DIBIE?",
                    'attr' => array('class' => 'form-control')]
            )
            ->add('idpoblacionbeneficia', null, [
                    "placeholder" => "Seleccione",
                    "label" => "Cantidad de Poblacion a Beneficiar",
                    'attr' => array('class' => 'form-control')]
            )
            ->add('idviabilidadplaneacion', null, [
                    "placeholder" => "Seleccione",
                    "label" => "Viabilidad Planeación",
                    'attr' => array('class' => 'form-control')]
            )
            ->add('idzonaubicacion', null, [
                    "placeholder" => "Seleccione",
                    "label" => "Zona de Ubicación",
                    'attr' => array('class' => 'form-control')]
            )
            ->add('idcantidadesbeneficioinst', null, [
                    "placeholder" => "Seleccione",
                    "label" => "Cantidad Beneficios Institucionales",
                    'attr' => array('class' => 'form-control')]
            )
            ->add('curriculum', FileType::class, [
                    'label' => 'Documentación anexa',
                    'required' => false]
            )
            ->add('fotoFile', FileType::class, [
                    'label' => 'Adjunte fotografía 3*4',
                    'required' => false]
            )
            ->getFormBuilder()
            ->addEventSubscriber(new AddAreaFieldSubscriber())
            ->addEventSubscriber(new AddProgramaPadreFieldSubscriber(false, $em))
            ->addEventSubscriber(new AddProgramasFieldSubscriber());
    }

    public function getDataSourceIterator()
    {
        $datasourceit = parent::getDataSourceIterator();
        $datasourceit->setDateTimeFormat('Y-m-d');
        return $datasourceit;
    }

    public function getExportFields()
    {
        return array(
            "Fecha de la Solicitud" => 'solicitudfecha',
            "Seccional" => 'idseccional',
            "Tipo de Solicitud" => 'idtiposolicitud',
            "Cédula del Solicitante" => 'solicitudcedulasolicita',
            "Nombre del Solicitante" => 'solicitudnombresolicita',
            "Correo electrónico de solicitante" => 'emailSolicitante',
            "Dirección Solicitante" => 'direccionSolicitante',
            "Teléfono Solicitante" => 'telefonoSolicitante',
            "Teléfono alterno Solicitante" => 'telefonoSolicitante2',
            "Cédula Funcionario Policial" => 'solicitudcedulafuncionario',
            "Grado Funcionario Policial" => 'idgrado',
            "Unidad" => 'unidad',
            "Nombre del Funcionario" => 'solicitudnombrefuncionario',
            "Antiguedad Funcionario" => 'antiguedad',
            "Parentesco con el Solicitante" => 'idparentesco',
            "Estado Civil" => 'idestadocivil',
            "Ingresos" => 'idingreso',
            "Cantidad de Personas a Cargo" => 'idpersonacargo',
            "Situación de Vivienda" => 'idsituacionvivienda',
            "Motivo Deuda" => 'idmotivodeuda',
            "Cantidad de beneficios recibidos por AOS" => 'idcantidadesbeneficioinst',
            "Concepto Visita Domiciliaria" => 'idconceptovisita',
            "Afiliado a DIBIE?" => 'idafiliadodibie',
            "Documento beneficiario final" => 'documentoBeneficiarioFinal',
            "Beneficiario final" => 'nombreBeneficiarioFinal',
            "Cantidad de Poblacion a Beneficiar" => 'idpoblacionbeneficia',
            "Viabilidad Planeación" => 'idviabilidadplaneacion',
            "Zona de Ubicacion" => 'idzonaubicacion',
            "Cantidad de beneficios institucionales" => 'idcantidadesbeneficioinst',
            "Puntaje total" => 'totalPuntaje',
            "Concepto Previo" => 'concepto',
            "Concepto Junta" => 'conceptoFinal',
            "Descripción de la Solicitud" => 'solicituddescripcion',
            "Programas" => 'programasArray',
        );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('solicitudfecha', null, ["label" => "Fecha de la Solicitud"])
            ->add('solicitudcedulasolicita', null, ["label" => "Cedula del Solicitante"])
            ->add('solicitudnombresolicita', null, ["label" => "Nombre del Solicitante"])
            ->add('idparentesco', null, ["label" => "Parentesco con el Solicitante"])
            ->add('solicitudcedulafuncionario', null, ["label" => "Cedula Funcionario Policial"])
            ->add('idgrado', null, ["label" => "Grado Funcionario Policial"])
            ->add('direccionSolicitante', null, ["label" => "Direccion Solicitante"])
            ->add('telefonoSolicitante', null, ["label" => "Telefono Solicitante"])
            ->add('telefonoSolicitante2', null, ["label" => "Telefono alterno Solicitante"])
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

    public function getTemplate($name)
    {
        switch ($name) {
            case 'show':
                return 'AppBundle:Solicitudes:base_show.html.twig';
                break;
            case "importar";
                return 'AppBundle:Solicitudes:importar.datos.html.twig';
                break;
            case 'edit':
                return 'AppBundle:Solicitudes:base_edit.html.twig';
                break;
            case 'replaceFile':
                return 'AppBundle:Solicitudes:cargar.archivo.html.twig';
                break;
            default:
                return parent::getTemplate($name);
        }
    }

}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProgramaSolicitud;
use AppBundle\Entity\Solicitudes;
use DateTime;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\ImportarDatosFormType;
use AppBundle\ValidData\Validaciones;
use AppBundle\ValidData\ValidacionesFamiliares;
use AppBundle\ValidData\ValidacionesInstitucionales;
use AppBundle\ValidData\ValidarDatos;

class SolicitudesAdminController extends CRUDController
{
    protected $em;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->em = $container->get("doctrine")->getManager();
    }

    public function importarAction()
    {
        $request = $this->getRequest();
        $form = $this->createForm(ImportarDatosFormType::class, null);
        $form->handleRequest($request);
        $titulo = 'label.importar';
        $validar = new ValidarDatos($this->container);
        $validaciones = new Validaciones($this->container);
        $validacionesFamiliares = new ValidacionesFamiliares($this->container);
        $validacionesInstitucionales = new ValidacionesInstitucionales($this->container);
        $errores = false;

        if ($form->isSubmitted()) {
            $isFormValid = $form->isValid();

            if ($isFormValid) {
                $datos = $validar->getDatos($form->get('file')->getData());
                if (key_exists("error", $datos)) {
                    $request->getSession()->getFlashBag()->add('sonata_flash_error', $datos["error"]);
                    return $this->renderWithExtraParams($this->admin->getTemplate("importar"), [
                        'titulo' => $titulo,
                        'form' => $form->createView(),
                    ], null);
                }

                $validate = $validar->validar($datos, $validaciones->getValidacion());
                if (is_array($validate)) {
                    $errores = true;
                    foreach ($validate as $mensaje) {
                        $request->getSession()->getFlashBag()->add('sonata_flash_error', $mensaje);
                    }

                }
                $init = 4;
                foreach ($datos as $dato) {
                    $tipoSolicitud = $this->em->getRepository("AppBundle:Tipossolicitud")->findOneByTiposolicitudnombre($dato["TIPO_SOLICITUD"]["valor"]);
                    $data[$init] = $dato;
                    if ($tipoSolicitud) {
                        if ($tipoSolicitud->getId() == 1) {
                            $validate = $validar->validar($data, $validacionesFamiliares->getValidacion());
                            if (is_array($validate)) {
                                $errores = true;
                                foreach ($validate as $mensaje) {
                                    $request->getSession()->getFlashBag()->add('sonata_flash_error', $mensaje);
                                }

                            }
                        } else {
                            $validate = $validar->validar($data, $validacionesInstitucionales->getValidacion());
                            if (is_array($validate)) {
                                $errores = true;
                                foreach ($validate as $mensaje) {
                                    $request->getSession()->getFlashBag()->add('sonata_flash_error', $mensaje);
                                }

                            }
                        }
                    }
                    $init++;
                }
                if ($errores) {
                    return $this->renderWithExtraParams($this->admin->getTemplate("importar"), [
                        'titulo' => $titulo,
                        'form' => $form->createView(),
                    ], null);
                }

                try {
                    $this->guardarDatos($datos);
                    $request->getSession()->getFlashBag()->add('sonata_flash_success', $this->admin->trans('mensaje.datos.cargados'));
                } catch (Exception $e) {
                    $request->getSession()->getFlashBag()->add('sonata_flash_error', $this->admin->trans('error.importando.datos'));
                }
            }
        }

        return $this->renderWithExtraParams($this->admin->getTemplate("importar"), [
            'titulo' => $titulo,
            'form' => $form->createView(),
        ], null);
    }

    public function guardarDatos($datos)
    {
        foreach ($datos as $dato) {
            $solicitud = new Solicitudes();
            $solicitud->setSolicitudfecha(DateTime::createFromFormat('Y-m-d', $dato['FECHA_DE_SOLICITUD']['valor']));
            $solicitud->setIdseccional($this->em->getRepository("AppBundle:Seccionales")->findOneBySeccionalnombre($dato['SECCIONAL']['valor']));
            $solicitud->setIdtiposolicitud($this->em->getRepository("AppBundle:Tipossolicitud")->findOneByTiposolicitudnombre($dato['TIPO_SOLICITUD']['valor']));
            $solicitud->setSolicitudcedulasolicita($dato['CEDULA_SOLICITANTE']['valor']);
            $solicitud->setSolicitudnombresolicita($dato['NOMBRE_Y_APELLIDO_SOLICITANTE']['valor']);
            $solicitud->setEmailSolicitante($dato['EMAIL']['valor']);
            $solicitud->setSolicituddireccionfuncionario($dato['DIRECCION']['valor']);
            $solicitud->setSolicitudtelefonosfuncionario($dato['TELEFONO']['valor']);
            $solicitud->setSolicitudcedulafuncionario($dato['CEDULA_FUNCIONARIO_POLICIAL']['valor']);
            $solicitud->setIdgrado($this->em->getRepository("AppBundle:Grados")->findOneByGradonombre($dato['GRADO_FUNCIONARIO_POLICIAL']['valor']));
            $solicitud->setUnidad($this->em->getRepository("AppBundle:unidad")->findOneByNombre($dato['UNIDAD']['valor']));
            $solicitud->setSolicitudnombrefuncionario($dato['NOMBRE_FUNCIONARIO_POLICIAL']['valor']);
            $solicitud->setAntiguedad($this->em->getRepository("AppBundle:antiguedad")->findOneByTiempo($dato['ANTIGUEDAD_FUNCIONARIO']['valor']));
            $solicitud->setIdpoblacionbeneficia($this->em->getRepository("AppBundle:Poblacionbeneficia")->findOneByPoblacionbeneficiadesc($dato['CANTIDAD_POBLACION_BENEFICIAR']['valor']));
            $solicitud->setIdviabilidadplaneacion($this->em->getRepository("AppBundle:Viabilidadplaneacion")->findOneByViabilidadplaneacionconcepto($dato['VIABILIDAD_PLANEACION']['valor']));
            $solicitud->setIdzonaubicacion($this->em->getRepository("AppBundle:Zonasubicacion")->findOneByZonasubicacionnombre($dato['ZONA_UBICACION']['valor']));
            $solicitud->setIdcantidadesbeneficioinst($this->em->getRepository("AppBundle:Cantidadesbeneficioinst")->findOneByCantidadesbeneficiodesc($dato['CANTIDAD_BENEFICIOS_INSTITUCIONALES']['valor']));
            $solicitud->setIdparentesco($this->em->getRepository("AppBundle:Parentescos")->findOneByParentesconombre($dato['PARENTESCO_SOLICITANTE']['valor']));
            $solicitud->setIdestadocivil($this->em->getRepository("AppBundle:Estadosciviles")->findOneByEstadocivilnombre($dato['ESTADO_CIVIL']['valor']));
            $solicitud->setIdingreso($this->em->getRepository("AppBundle:Ingresos")->findOneByIngresonombre($dato['INGRESOS']['valor']));
            $solicitud->setIdpersonacargo($this->em->getRepository("AppBundle:Personascargo")->findOneByPersonacargonombre($dato['PERSONAS_A_CARGO']['valor']));
            $solicitud->setIdsituacionvivienda($this->em->getRepository("AppBundle:Situacionesvivienda")->findOneBySituacionviviendanombre($dato['SITUACION_VIVIENDA']['valor']));
            $solicitud->setIdmotivodeuda($this->em->getRepository("AppBundle:Motivosdeuda")->findOneByMotivodeudanombre($dato['DIFICULTAD']['valor']));
            $solicitud->setCantidadesbeneficio($this->em->getRepository("AppBundle:Cantidadesbeneficio")->findOneByCantidadbeneficionombre($dato['CANTIDAD_BENEFICIOS_AOS']['valor']));
            $solicitud->setIdconceptovisita($this->em->getRepository("AppBundle:Conceptosvisita")->findOneByConceptovisitanombre($dato['CONCEPTO_VISITA_DOMICILIARIA']['valor']));
            $solicitud->setIdafiliadodibie($this->em->getRepository("AppBundle:Afiliadodibie")->findOneByAfiliadodibiedesc($dato['AFILIADO_DIBIE']['valor']));
            $solicitud->setDocumentoBeneficiarioFinal($dato['DOCUMENTO_BENEFICIARIO_FINAL']['valor']);
            $solicitud->setDocumentoBeneficiarioFinal($dato['NOMBRE_BENEFICIARIO_FINAL']['valor']);
            $programas = explode(";", $dato['PROGRAMAS']['valor']);
            foreach ($programas as $prog) {
                $programaSolicitud = new ProgramaSolicitud($this->em->getRepository("AppBundle:Programas")->findOneByProgramanombre($prog), $solicitud);
                $solicitud->addPrograma($programaSolicitud);
                $this->em->persist($programaSolicitud);
            }
            $this->em->persist($solicitud);
        }
        $this->em->flush();
    }
}

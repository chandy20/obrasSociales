<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Conceptosjunta;
use AppBundle\Entity\Movimiento;
use AppBundle\Entity\Solicitudes;
use AppBundle\Form\FormularioReportesType;
use DateTime;
use Doctrine\ORM\Query\ResultSetMapping;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Exception\LockException;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Bridge\Twig\AppVariable;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bundle\TwigBundle\Command\DebugCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ConceptosjuntaAdminController extends CRUDController
{

    protected $em;
    public $presupuesto;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->presupuesto = [];
        $this->em = $container->get("doctrine")->getManager();
    }

    public function editAction($id = null)
    {
        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'edit';

        $id = $request->get($this->admin->getIdParameter());
        $existingObject = $this->admin->getObject($id);
        $securityContext = $this->container->get('security.context');
        $form = $this->admin->getForm();
        $form->setData($existingObject);
        if (!$existingObject) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        } else if (!$securityContext->isGranted('ROLE_SUPER_ADMIN')) {
            if ($existingObject->getEditado()) {
                $this->addFlash('sonata_flash_error', $this->trans('El concepto junta ya fue editado, solo es posible realizar el proceso una vez.'));
                return $this->redirect($this->generateUrl('admin_app_conceptosjunta_list'));
            }
        }

        $this->admin->checkAccess('edit', $existingObject);

        $preResponse = $this->preEdit($request, $existingObject);
        if (null !== $preResponse) {
            return $preResponse;
        }

        $this->admin->setSubject($existingObject);
        $objectId = $this->admin->getNormalizedIdentifier($existingObject);

        /** @var $form Form */
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if (method_exists($this->admin, 'preValidate')) {
                $this->admin->preValidate($existingObject);
            }
            $isFormValid = $form->isValid();
            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
//                $this->validar($existingObject, $form);
                $isFormValid = $form->isValid();
                if ($isFormValid) {
                    $submittedObject = $form->getData();
                    $submittedObject->setEditado(true);
                    $solicitud = $submittedObject->getSolicitud();
                    $solicitud->setCantidadAprobada($submittedObject->getConceptojuntavalortotalb());
                    $concepto = $this->em->getRepository("AppBundle:Concepto")->findOneById(4);
                    if ($submittedObject->getAprobado()) {
                        $concepto = $this->em->getRepository("AppBundle:Concepto")->findOneById(1);
                    } else {
                        $submittedObject->setAprobado(false);
                    }
                    $solicitud->setConceptoFinal($concepto);
                    $this->admin->setSubject($submittedObject);
                    try {
                        $existingObject = $this->admin->update($submittedObject);
                        if ($existingObject->getAprobado()) {
                            foreach ($form->get("programasConcepto")->getData() as $programa) {
                                $programa->setAprobado(true);
                                $this->em->persist($programa);
                            }
                        }
//                    $this->em->flush();

                        if ($this->isXmlHttpRequest()) {
                            return $this->renderJson([
                                'result' => 'ok',
                                'objectId' => $objectId,
                                'objectName' => $this->escapeHtml($this->admin->toString($existingObject)),
                            ], 200, []);
                        }
                        $this->sendMail($submittedObject);
                        if ($submittedObject->getAprobado()) {
                            foreach ($this->presupuesto as $presupuesto) {
                                if (intval($presupuesto->getSaldo()) < 1000001) {
                                    $this->addFlash(
                                        'sonata_flash_error', "El saldo del presupuesto de la seccional " . $presupuesto->getSeccional()->getSeccionalnombre() . " del área " . $presupuesto->getIdarea()->getAreanombre() . " es de " . $presupuesto->getSaldo()
                                    );
                                }
                            }
                        }
                        $this->addFlash(
                            'sonata_flash_success', $this->trans(
                            'flash_edit_success', ['%name%' => $this->escapeHtml($this->admin->toString($existingObject))], 'SonataAdminBundle'
                        )
                        );

                        // redirect to edit mode
                        return $this->redirectTo($existingObject);
                    } catch (ModelManagerException $e) {
                        $this->handleModelManagerException($e);

                        $isFormValid = false;
                    } catch (LockException $e) {
                        $this->addFlash('sonata_flash_error', $this->trans('flash_lock_error', [
                            '%name%' => $this->escapeHtml($this->admin->toString($existingObject)),
                            '%link_start%' => '<a href="' . $this->admin->generateObjectUrl('edit', $existingObject) . '">',
                            '%link_end%' => '</a>',
                        ], 'SonataAdminBundle'));
                    }
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                        'sonata_flash_error', $this->trans(
                        'flash_edit_error', ['%name%' => $this->escapeHtml($this->admin->toString($existingObject))], 'SonataAdminBundle'
                    )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // enable the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $formView = $form->createView();
        // set the theme for the current Admin Form
        $this->setFormTheme($formView, $this->admin->getFormTheme());

        return $this->renderWithExtraParams($this->admin->getTemplate($templateKey), [
            'action' => 'edit',
            'form' => $formView,
            'object' => $existingObject,
            'objectId' => $objectId,
        ], null);
    }

    private function setFormTheme(FormView $formView, $theme)
    {
        $twig = $this->get('twig');

        // BC for Symfony < 3.2 where this runtime does not exists
        if (!method_exists(AppVariable::class, 'getToken')) {
            $twig->getExtension(FormExtension::class)->renderer->setTheme($formView, $theme);

            return;
        }

        // BC for Symfony < 3.4 where runtime should be TwigRenderer
        if (!method_exists(DebugCommand::class, 'getLoaderPaths')) {
            $twig->getRuntime(TwigRenderer::class)->setTheme($formView, $theme);

            return;
        }

        $twig->getRuntime(FormRenderer::class)->setTheme($formView, $theme);
    }

    function validar(Conceptosjunta $concepto, Form $form)
    {
        if ($form->getData()->getAprobado()) {
            if (!$form->getData()->getConceptosjuntanumacta()) {
                $form->addError(new FormError("Por favor agregue el número de acta de aprobación"));
            } else {

                $hoy = new DateTime();
                $totalBeneficio = 0;
                foreach ($concepto->getProgramasConcepto() as $key => $programaConcepto) {
                    $presupuesto = $this->em->getRepository("AppBundle:Presupuestos")->createQueryBuilder('p')
                        ->where("p.seccional = :seccional")
                        ->andWhere(":hoy BETWEEN p.desde AND p.hasta")
                        ->andWhere("p.idarea = :area")
                        ->andWhere("p.programa = :programa")
                        ->setParameter("seccional", $concepto->getSolicitud()->getIdseccional())
                        ->setParameter("area", $programaConcepto->getPrograma()->getPrograma()->getIdarea())
                        ->setParameter("programa", $programaConcepto->getPrograma())
                        ->setParameter("hoy", $hoy)->getQuery()->getResult();
                    if (!$presupuesto) {
                        $form->addError(new FormError("No existe presupuesto vigente disponible para la seccional selecional " . $concepto->getSolicitud()->getIdseccional()->getSeccionalnombre() . " para el área de " . $programaConcepto->getPrograma()->getPrograma()->getIdarea() . " - " . $programaConcepto->getPrograma()->getPrograma() . " - " . $programaConcepto->getPrograma()));
                    } else {
                        $presupuesto = $presupuesto[0];
                        $totalMovimiento = $programaConcepto->getPrograma()->getValorMes() * $programaConcepto->getUnidadesAprobadas();
                        $totalBeneficio += $totalMovimiento;
                        $movimiento = $this->em->getRepository("AppBundle:Movimiento")->createQueryBuilder('m')
                            ->where("m.seccional = :seccional")
                            ->andWhere("m.concepto = :concepto")
                            ->andWhere("m.valor = :valor")
                            ->andWhere("m.presupuesto = :presupuesto")
                            ->setParameter("seccional", $concepto->getSolicitud()->getIdseccional())
                            ->setParameter("concepto", $concepto)
                            ->setParameter("valor", $totalMovimiento)
                            ->setParameter("presupuesto", $presupuesto)->getQuery()->getResult();
                        if (!$movimiento) {
                            $movimiento = new Movimiento();
                        } else {
                            $movimiento = $movimiento[0];
                        }
                        $em = $this->getDoctrine()->getManager();
                        $stmt = $em->getConnection()->prepare('SELECT unidades_aprobadas FROM programa_concepto WHERE id =' . $programaConcepto->getId());
                        $stmt->execute();
                        $resultado = $stmt->fetchAll();
                        $unidadesAntiguas = null;
                        if ($resultado[0]['unidades_aprobadas']) {
                            $unidadesAntiguas = $resultado[0]['unidades_aprobadas'];
                        }
                        $errorForm = false;
                        if ($unidadesAntiguas != null && $unidadesAntiguas != $programaConcepto->getUnidadesAprobadas()) {
                            if ($unidadesAntiguas < $programaConcepto->getUnidadesAprobadas()) {
                                $nuevoSaldo = $presupuesto->getSaldo() - $totalMovimiento;
                                if ($presupuesto->getSaldo() < $nuevoSaldo) {
                                    $errorForm = true;
                                    $form->addError(new FormError("El saldo del presupuesto de la seccional " . $concepto->getSolicitud()->getIdseccional()->getSeccionalnombre() . " para el area de " . $programaConcepto->getPrograma()->getPrograma()->getIdarea() . " - " . $programaConcepto->getPrograma()->getPrograma() . " - " . $programaConcepto->getPrograma() . ", es inferior al monto de la transacción."));
                                }
                            } else {
                                $nuevoSaldo = $presupuesto->getSaldo() + $totalMovimiento;
                            }
                            if ($programaConcepto->getUnidadesAprobadas() == 0) {
                                $nuevoSaldo = $presupuesto->getPresupuestomonto();
                            }
                        } else {
                            if ($unidadesAntiguas == $programaConcepto->getUnidadesAprobadas()) {
                                $nuevoSaldo = $presupuesto->getSaldo();
                            } else {
                                $nuevoSaldo = $presupuesto->getSaldo() - $totalMovimiento;
                            }
                        }
                        if (!$errorForm) {

                            $presupuesto->setSaldo($nuevoSaldo);
                            $movimiento->setValor($totalMovimiento);
                            $movimiento->setTipo("Débito");
                            $movimiento->setSeccional($concepto->getSolicitud()->getIdseccional());
                            $movimiento->setPresupuesto($presupuesto);
                            $movimiento->setConcepto($concepto);
                            $this->em->persist($presupuesto);
                            $this->em->persist($movimiento);
                        }
                    }
                    if (!in_array($presupuesto, $this->presupuesto)) {
                        $this->presupuesto[] = $presupuesto;
                    }
                }
                $concepto->setConceptojuntavalortotalb($totalBeneficio);

                $this->em->persist($concepto);
            }
        }
    }

    public function reporteAction()
    {
        $concepto = new Conceptosjunta();
        $form = $this->createForm(FormularioReportesType::class, $concepto, []);
        $form->handleRequest($this->getRequest());
        return $this->renderWithExtraParams("AppBundle:Reporte:base_reporte.html.twig", [
            'action' => 'edit',
            'form' => $form->createView(),
            'object' => $concepto
        ], null);
    }

    public function dataReporteAction(Request $request)
    {
        $form = (array)json_decode($request->request->get('form'));

        $pestana = json_decode($request->request->get('pestana'));
        switch ($pestana) {
            case 1:
                $html = $this->cargarDatosCantidades($form["formulario_reportes"]);
                break;
            case 2;
                $html = $this->cargarDatosInscritos($form["formulario_reportes"]);
                break;
            case 3:
                $html = $this->cargarDatosPresupuesto($form["formulario_reportes"]);
                break;
            case 4:
                $html = $this->cargarDatosMovimientos($form["formulario_reportes"]);
                break;
            default:
                $html = $this->cargarDatosGeneral($form["formulario_reportes"], $pestana);
                break;
        }
        $respuesta['html'] = $html;
        return new JsonResponse($respuesta);
    }

    public function cargarDatosGeneral($form, $pestana)
    {
        $parametros = $this->obtenerDatos($form, $pestana);
        $query = $this->em->getRepository("AppBundle:Solicitudes")->createQueryBuilder('s')
            ->where("s.solicitudfecha BETWEEN :inicio AND :fin")
            ->setParameter("inicio", $parametros["inicio"])
            ->setParameter("fin", $parametros['fin']);
        if ($parametros["extra"]) {
            $query->andWhere($parametros["campo"] . "= :" . $parametros["alias"])
                ->setParameter($parametros["alias"], $parametros["valor"]);
        }
        $user = $this->getUser();
        if ($user->hasRole('ROLE_CONSULTOR')) {
            $query->join("s.idseccional", "se")
                ->andWhere("se.id = :seccional")
                ->setParameter("seccional", $user->getSeccional());
        }
        $solicitudes = $query->getQuery()->getResult();
        $datos = [];

        foreach ($solicitudes as $solicitud) {
            $padre = $solicitud->{$parametros['ordenamiento']};
            if ($padre != null) {
                foreach ($solicitud->getProgramas() as $programa) {
                    if (!array_key_exists('"' . $padre->getNombre() . '"', $datos)) {
                        $datos['"' . $padre->getNombre() . '"']["total"] = 1;
                        $datos['"' . $padre->getNombre() . '"']["aprobadas"] = 0;
                        $datos['"' . $padre->getNombre() . '"']["rechazadas"] = 0;
                    } else {
                        $datos['"' . $padre->getNombre() . '"']["total"]++;
                    }
                }
            }
        }
        $queryAprobadas = $query;
        $queryAprobadas->join("s.conceptoJunta", "cj")
            ->andWhere("cj.editado = :editado");
        $queryAprobadas->setParameter("editado", true);
        $solicitudesAprobadas = $queryAprobadas->getQuery()->getResult();
        foreach ($solicitudesAprobadas as $solicitud) {
            $padre = $solicitud->{$parametros['ordenamiento']};
            foreach ($solicitud->getConceptoJunta() as $concepto) {
                foreach ($concepto->getProgramasConcepto() as $programaConcepto) {
                    if ($programaConcepto->getAprobado()) {
                        $datos['"' . $padre->getNombre() . '"']["aprobadas"]++;
                    } else if (!$programaConcepto->getAprobado()) {
                        $datos['"' . $padre->getNombre() . '"']["rechazadas"]++;
                    }
                }
            }
        }

        $html = $this->renderView('AppBundle:Reporte:reporte_general.html.twig', [
            'datos' => $datos,
            'columna' => $parametros["columna"]
        ]);

        return $html;
    }

    public function cargarDatosCantidades($form)
    {
        $query = $this->em->getRepository("AppBundle:Solicitudes")->createQueryBuilder('s')
            ->where("s.solicitudfecha BETWEEN :inicio AND :fin")
            ->setParameter("inicio", $form->fechaInicial)
            ->setParameter("fin", $form->fechaFinal);
        $user = $this->getUser();
        if ($user->hasRole('ROLE_CONSULTOR')) {
            $query->join("s.idseccional", "se")
                ->andWhere("se.id = :seccional")
                ->setParameter("seccional", $user->getSeccional());
        }
        if ($form->seccional != "") {
            $query->join("s.idseccional", "se")
                ->andWhere("se.id = :seccional")
                ->setParameter("seccional", $form->seccional);
        }
        if ($form->concepto != "") {
            $query->join("s.concepto", "co")
                ->andWhere("co.id = :concepto")
                ->setParameter("concepto", $form->concepto);
        }
        if ($form->parentesco != "") {
            $query->join("s.idparentesco", "pa")
                ->andWhere("pa.id = :parentesco")
                ->setParameter("parentesco", $form->parentesco);
        }
        if ($form->grado != "") {
            $query->join("s.idgrado", "g")
                ->andWhere("g.id = :grado")
                ->setParameter("grado", $form->grado);
        }
        if ($form->tipoSolicitud != "") {
            $query->join("s.idtiposolicitud", "ts")
                ->andWhere("ts.id = :tipoSolicitud")
                ->setParameter("tipoSolicitud", $form->tipoSolicitud);
        }
        if ($form->estadoCivil != "") {
            $query->join("s.idestadocivil", "es")
                ->andWhere("es.id = :estadoCivil")
                ->setParameter("estadoCivil", $form->estadoCivil);
        }
        if ($form->ingreso != "") {
            $query->join("s.idingreso", "i")
                ->andWhere("i.id = :ingreso")
                ->setParameter("ingreso", $form->ingreso);
        }
        if ($form->personasCargo != "") {
            $query->join("s.idpersonacargo", "pc")
                ->andWhere("pc.id = :personasCargo")
                ->setParameter("personasCargo", $form->personasCargo);
        }
        if ($form->situacionVivienda != "") {
            $query->join("s.idsituacionvivienda", "sv")
                ->andWhere("sv.id = :situacionVivienda")
                ->setParameter("situacionVivienda", $form->situacionVivienda);
        }
        if ($form->motivoDeuda != "") {
            $query->join("s.idmotivodeuda", "md")
                ->andWhere("md.id = :motivoDeuda")
                ->setParameter("motivoDeuda", $form->motivoDeuda);
        }
        if ($form->cantidadBeneficio != "") {
            $query->join("s.cantidadesbeneficio", "cb")
                ->andWhere("cb.cantidadesbeneficio_id = :cantidadBeneficio")
                ->setParameter("cantidadBeneficio", $form->cantidadBeneficio);
        }
        if ($form->conceptoVisita != "") {
            $query->join("s.idconceptovisita", "cv")
                ->andWhere("cv.idconceptovisita = :conceptoVisita")
                ->setParameter("conceptoVisita", $form->conceptoVisita);
        }
        if ($form->afiliadoDibie != "") {
            $query->join("s.idafiliadodibie", "ad")
                ->andWhere("ad.idafiliadodibie = :afiliadoDibie")
                ->setParameter("afiliadoDibie", $form->afiliadoDibie);
        }
        if ($form->poblacionBeneficiada != "") {
            $query->join("s.idpoblacionbeneficia", "pb")
                ->andWhere("pb.id = :poblacionBeneficiada")
                ->setParameter("poblacionBeneficiada", $form->poblacionBeneficiada);
        }
        if ($form->viabilidadPlaneacion != "") {
            $query->join("s.idviabilidadplaneacion", "vp")
                ->andWhere("vp.id = :viabilidadPlaneacion")
                ->setParameter("viabilidadPlaneacion", $form->viabilidadPlaneacion);
        }
        if ($form->zonaUbicacion != "") {
            $query->join("s.idzonaubicacion", "z")
                ->andWhere("z.id = :zonaUbicacion")
                ->setParameter("zonaUbicacion", $form->zonaUbicacion);
        }
        if ($form->programa != "") {
            $query->join("s.programas", "sp")
                ->join("sp.programa", "p")
                ->andWhere("p.id = :programa")
                ->setParameter("programa", $form->programa);
        }
        if ($form->area != "") {
            $query->join("s.programas", "sp")
                ->join("sp.programa", "p")
                ->join("p.idarea", "a")
                ->andWhere("a.idArea = :area")
                ->setParameter("area", $form->area);
        }
        $solicitudes = $query->getQuery()->getResult();
        $datos = [];
        foreach ($solicitudes as $solicitud) {
            foreach ($solicitud->getProgramas() as $programa) {
                if (!array_key_exists($solicitud->getIdseccional()->getSeccionalnombre(), $datos)) {
                    $datos[$solicitud->getIdseccional()->getSeccionalnombre()]["total"] = 1;
                    $datos[$solicitud->getIdseccional()->getSeccionalnombre()]["aprobadas"] = 0;
                    $datos[$solicitud->getIdseccional()->getSeccionalnombre()]["rechazadas"] = 0;
                } else if ($form->programa != "") {
                    if ($programa->getPrograma()->getId() == $form->programa) {
                        $datos[$solicitud->getIdseccional()->getSeccionalnombre()]["total"]++;
                    }
                } else {
                    $datos[$solicitud->getIdseccional()->getSeccionalnombre()]["total"]++;
                }
            }
        }
        $query->join("s.conceptoJunta", "cj")
            ->andWhere("cj.editado = :editado");
        $queryAprobadas = $query;
        $queryAprobadas->setParameter("editado", true);
        $solicitudesAprobadas = $queryAprobadas->getQuery()->getResult();
        foreach ($solicitudesAprobadas as $solicitud) {
            foreach ($solicitud->getConceptoJunta() as $concepto) {
                foreach ($concepto->getProgramasConcepto() as $programaConcepto) {
                    if ($programaConcepto->getAprobado()) {
                        if ($form->programa != "") {
                            if ($programaConcepto->getPrograma()->getId() == $form->programa) {
                                $datos[$solicitud->getIdseccional()->getSeccionalnombre()]["aprobadas"]++;
                            }
                        } else {
                            $datos[$solicitud->getIdseccional()->getSeccionalnombre()]["aprobadas"]++;
                        }
                    } else {
                        if ($form->programa != "") {
                            if ($programaConcepto->getPrograma()->getId() == $form->programa) {
                                $datos[$solicitud->getIdseccional()->getSeccionalnombre()]["rechazadas"]++;
                            }
                        } else {
                            $datos[$solicitud->getIdseccional()->getSeccionalnombre()]["rechazadas"]++;
                        }
                    }
                }
            }
        }

        $html = $this->renderView('AppBundle:Reporte:reporte_cantidades.html.twig', [
            'datos' => $datos
        ]);

        return $html;
    }

    public function cargarDatosInscritos($form)
    {
        $query = $this->em->getRepository("AppBundle:Solicitudes")->createQueryBuilder('s')
            ->where("s.solicitudfecha BETWEEN :inicio AND :fin")
            ->setParameter("inicio", $form->fechaInicial2)
            ->setParameter("fin", $form->fechaFinal2);

        $user = $this->getUser();
        if ($user->hasRole('ROLE_CONSULTOR')) {
            $query->join("s.idseccional", "se")
                ->andWhere("se.id = :seccional")
                ->setParameter("seccional", $user->getSeccional());
        }

        if ($form->documentoSolicitante != "") {
            $query->andWhere("s.solicitudcedulasolicita = :documento")
                ->setParameter("documento", $form->documentoSolicitante);
        }
        if ($form->documentoTitular != "") {
            $query->andWhere("s.solicitudcedulafuncionario = :documentoTitular")
                ->setParameter("documentoTitular", $form->documentoTitular);
        }
        if ($form->documentoTitular != "") {
            $query->andWhere("s.solicitudcedulafuncionario = :documentoTitular")
                ->setParameter("documentoTitular", $form->documentoTitular);
        }
        if ($form->programa3 != "") {
            $query->join("s.programas", "sp")
                ->join("sp.programa", "p")
                ->andWhere("p.id = :programa")
                ->setParameter("programa", $form->programa3);
        }
        if ($form->area2 != "") {
            $query->join("s.programas", "sp")
                ->join("sp.programa", "p")
                ->join("p.idarea", "a")
                ->andWhere("a.idArea = :area")
                ->setParameter("area", $form->area2);
        }
        $solicitudes = $query->getQuery()->getResult();
        $datos = [];
        foreach ($solicitudes as $solicitud) {
            foreach ($solicitud->getProgramas() as $programa) {

            }
            if (!array_key_exists($solicitud->getSolicitudnombrefuncionario(), $datos) && $solicitud->getNombreBeneficiarioFinal()) {
                if ($programa->getPrograma()->getId() == $form->programa) {
                    $datos[$solicitud->getSolicitudnombrefuncionario()]["beneficiarios"]["datos"]["nombre"][] = $solicitud->getDocumentoBeneficiarioFinal() . " - " . $solicitud->getNombreBeneficiarioFinal();
                    $datos[$solicitud->getSolicitudnombrefuncionario()]["beneficiarios"]["datos"]["seccional"][] = $solicitud->getIdseccional()->getSeccionalnombre();
                } else {
                    $datos[$solicitud->getSolicitudnombrefuncionario()]["beneficiarios"]["datos"]["nombre"][] = $solicitud->getDocumentoBeneficiarioFinal() . " - " . $solicitud->getNombreBeneficiarioFinal();
                    $datos[$solicitud->getSolicitudnombrefuncionario()]["beneficiarios"]["datos"]["seccional"][] = $solicitud->getIdseccional()->getSeccionalnombre();
                }
            }
        }
        $html = $this->renderView('AppBundle:Reporte:reporte_inscritos.html.twig', [
            'datos' => $datos
        ]);
        return $html;
    }

    public function cargarDatosPresupuesto($form)
    {
        $query = $this->em->getRepository("AppBundle:Movimiento")->createQueryBuilder('m')
            ->join("m.seccional", "s")
            ->join("m.concepto", "c")
            ->join("c.solicitud", "so")
            ->where("so.solicitudfecha BETWEEN :inicio AND :fin")
            ->setParameter("inicio", $form->fechaInicial3)
            ->setParameter("fin", $form->fechaFinal3);

        $user = $this->getUser();
        if ($user->hasRole('ROLE_CONSULTOR')) {
            $query->join("s.idseccional", "se")
                ->andWhere("se.id = :seccional")
                ->setParameter("seccional", $user->getSeccional());
        }

        if ($form->seccional3) {
            $query->andWhere("s.id = :seccional")
                ->setParameter("seccional", $form->seccional3);
        }
        if ($form->area3 != "") {
            $query->join("so.programas", "sp")
                ->join("sp.programa", "p")
                ->join("p.idarea", "a")
                ->andWhere("a.idArea = :area")
                ->setParameter("area", $form->area3);
        }
        $movimientos = $query->getQuery()->getResult();
        $datos = [];
        $totales = [];
        foreach ($movimientos as $movimiento) {
            if (!array_key_exists($movimiento->getSeccional()->getSeccionalnombre(), $datos)) {
                $presupuestos = $this->em->getRepository("AppBundle:Presupuestos")->createQueryBuilder('p')
                    ->where("p.desde <= :inicio OR p.hasta >= :fin")
                    ->andWhere("p.seccional = :seccional")
                    ->setParameter("inicio", $form->fechaInicial3)
                    ->setParameter("fin", $form->fechaFinal3)
                    ->setParameter("seccional", $movimiento->getSeccional());
                if ($form->area3) {
                    $presupuestos->join("p.idarea", "a")
                        ->andWhere("a.idArea = :area")
                        ->setParameter("area", $form->area3);
                }
                $presupuestos = $presupuestos->getQuery()->getResult();
                $totalValor = 0;
                if ($presupuestos) {
                    foreach ($presupuestos as $presupuesto) {
                        if (!in_array($presupuesto->getIdarea()->getAreanombre(), $totales)) {
                            $totales[$presupuesto->getIdarea()->getAreanombre()] = $presupuesto->getPresupuestomonto();
                        } else {
                            $totales[$presupuesto->getIdarea()->getAreanombre()] += $presupuesto->getPresupuestomonto();
                        }
                    }
                }
                $datos[$movimiento->getSeccional()->getSeccionalnombre() . " " . $movimiento->getPresupuesto()->getIdarea()]["valor"] = $totales[$movimiento->getPresupuesto()->getIdarea()->getAreanombre()];
                $datos[$movimiento->getSeccional()->getSeccionalnombre() . " " . $movimiento->getPresupuesto()->getIdarea()]["movimientos"] = $movimiento->getValor();
            } else {
                $datos[$movimiento->getSeccional()->getSeccionalnombre() . " " . $movimiento->getPresupuesto()->getIdarea()]["movimientos"] += $movimiento->getValor();
            }
        }
        $html = $this->renderView('AppBundle:Reporte:reporte_presupuesto.html.twig', [
            'datos' => $datos
        ]);
        return $html;
    }

    public function cargarDatosMovimientos($form)
    {
        $query = $this->em->getRepository("AppBundle:Movimiento")->createQueryBuilder('m')
            ->join("m.seccional", "s")
            ->join("m.concepto", "c")
            ->join("c.solicitud", "so")
            ->where("so.solicitudfecha BETWEEN :inicio AND :fin")
            ->setParameter("inicio", $form->fechaInicial4)
            ->setParameter("fin", $form->fechaFinal4);
        if ($form->documentoSolicitante2) {
            $query->andWhere("so.solicitudcedulasolicita = :cedula")
                ->setParameter("cedula", $form->documentoSolicitante2);
        }
        if ($form->documentoTitular2) {
            $query->andWhere("so.solicitudcedulafuncionario = :cedulaTitular")
                ->setParameter("cedulaTitular", $form->documentoTitular2);
        }
        $user = $this->getUser();
        if ($user->hasRole('ROLE_CONSULTOR')) {
            $query->join("s.idseccional", "se")
                ->andWhere("se.id = :seccional")
                ->setParameter("seccional", $user->getSeccional());
        }
        if ($form->seccional4) {
            $query->andWhere("s.id = :seccional")
                ->setParameter("seccional", $form->seccional4);
        }
        if ($form->programa2) {
            $query->join("so.programas", "sp")
                ->join("sp.programa", "p")
                ->andWhere("p.id = :programa")
                ->setParameter("programa", $form->programa2);
        }
        $movimientos = $query->getQuery()->getResult();
        $html = $this->renderView('AppBundle:Reporte:reporte_movimientos.html.twig', [
            'movimientos' => $movimientos
        ]);
        return $html;
    }

    public function downloadArchivoAction($id)
    {
        $solicitud = $this->em->getRepository("AppBundle:Solicitudes")->findOneById($id);
        $path = "/home/obrasso1/public_html/web/upload/";
        $content = file_get_contents($path . $solicitud->getArchivo());

        $response = new Response();

        //set headers
        $response->headers->set('Content-Type', 'mime/type');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $solicitud->getArchivo());

        $response->setContent($content);
        return $response;
    }

    public function downloadPDFAction($id)
    {
        $solicitud = $this->em->getRepository("AppBundle:Solicitudes")->findOneById($id);
        $html = $this->renderView('AppBundle:Solicitudes:pdf.html.twig', array(
            'solicitud' => $solicitud
        ));
        $session = $this->getRequest()->getSession();
        $session->save();
        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html, [
                'encoding' => 'utf-8',
            ]), 'solicitud.pdf'
        );
    }

    public function obtenerDatos($form, $pestana)
    {
        $datos = [];
        $datos["extra"] = 0;
        switch ($pestana) {
            case 5:
                $datos["inicio"] = $form->fechaInicial5;
                $datos["fin"] = $form->fechaFinal5;
                $datos["ordenamiento"] = "idparentesco";
                $datos["columna"] = "Parentesco";
                if ($form->parentesco2) {
                    $datos["extra"] = 1;
                    $datos["campo"] = "s.idparentesco";
                    $datos["alias"] = "parentesco";
                    $datos["valor"] = $form->parentesco2;
                }
                break;
            case 6:
                $datos["inicio"] = $form->fechaInicial6;
                $datos["fin"] = $form->fechaFinal6;
                $datos["ordenamiento"] = "idgrado";
                $datos["columna"] = "Grado";
                if ($form->grado2) {
                    $datos["extra"] = 1;
                    $datos["campo"] = "s.idgrado";
                    $datos["alias"] = "grado";
                    $datos["valor"] = $form->grado2;
                }
                break;
            case 7:
                $datos["inicio"] = $form->fechaInicial7;
                $datos["fin"] = $form->fechaFinal7;
                $datos["ordenamiento"] = "idestadocivil";
                $datos["columna"] = "Estado civil";
                if ($form->estadoCivil2) {
                    $datos["extra"] = 1;
                    $datos["campo"] = "s.idestadocivil";
                    $datos["alias"] = "estado";
                    $datos["valor"] = $form->estadoCivil2;
                }
                break;
            case 8:
                $datos["inicio"] = $form->fechaInicial8;
                $datos["fin"] = $form->fechaFinal8;
                $datos["ordenamiento"] = "idingreso";
                $datos["columna"] = "Estado civil";
                if ($form->ingreso2) {
                    $datos["extra"] = 1;
                    $datos["campo"] = "s.idingreso";
                    $datos["alias"] = "ingresos";
                    $datos["valor"] = $form->ingreso2;
                }
                break;
            case 9:
                $datos["inicio"] = $form->fechaInicial9;
                $datos["fin"] = $form->fechaFinal9;
                $datos["ordenamiento"] = "idpersonacargo";
                $datos["columna"] = "Personas a cargo";
                if ($form->personasCargo2) {
                    $datos["extra"] = 1;
                    $datos["campo"] = "s.idpersonacargo";
                    $datos["alias"] = "personas";
                    $datos["valor"] = $form->personasCargo2;
                }
                break;
            case 10:
                $datos["inicio"] = $form->fechaInicial10;
                $datos["fin"] = $form->fechaFinal10;
                $datos["ordenamiento"] = "idsituacionvivienda";
                $datos["columna"] = "Situación de la vivienda";
                if ($form->situacionVivienda2) {
                    $datos["extra"] = 1;
                    $datos["campo"] = "s.idsituacionvivienda";
                    $datos["alias"] = "situacion";
                    $datos["valor"] = $form->situacionVivienda2;
                }
                break;
            case 11:
                $datos["inicio"] = $form->fechaInicial11;
                $datos["fin"] = $form->fechaFinal11;
                $datos["ordenamiento"] = "idmotivodeuda";
                $datos["columna"] = "Motivo de la deuda";
                if ($form->motivoDeuda2) {
                    $datos["extra"] = 1;
                    $datos["campo"] = "s.idmotivodeuda";
                    $datos["alias"] = "motivo";
                    $datos["valor"] = $form->motivoDeuda2;
                }
                break;
            case 12:
                $datos["inicio"] = $form->fechaInicial12;
                $datos["fin"] = $form->fechaFinal12;
                $datos["ordenamiento"] = "idtiposolicitud";
                $datos["columna"] = "Tipo de solicitud";
                if ($form->tipoSolicitud2) {
                    $datos["extra"] = 1;
                    $datos["campo"] = "s.idtiposolicitud";
                    $datos["alias"] = "tipo";
                    $datos["valor"] = $form->tipoSolicitud2;
                }
                break;
        }
        return $datos;
    }

    function sendMail($conceptoJunta)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Saldo insuficiente en caja menor')
            ->setTo($conceptoJunta->getSolicitud()->getEmailSolicitante())
            ->setBody($this->container->get('templating')->render(
                'AppBundle:Solicitudes:plantilla_mail.html.twig'
            ), 'text/html');

        try {
            $this->container->get('mailer')->send($message);
        } catch (\Exception $ex) {
        }
    }

}

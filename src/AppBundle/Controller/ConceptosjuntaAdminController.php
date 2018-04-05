<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Conceptosjunta;
use AppBundle\Entity\Movimiento;
use AppBundle\Form\FormularioReportesType;
use DateTime;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Exception\LockException;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Bridge\Twig\AppVariable;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bundle\TwigBundle\Command\DebugCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ConceptosjuntaAdminController extends CRUDController {

    protected $em;

    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);

        $this->em = $container->get("doctrine")->getManager();
    }

    public function editAction($id = null) {
        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'edit';

        $id = $request->get($this->admin->getIdParameter());
        $existingObject = $this->admin->getObject($id);

        if (!$existingObject) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        } else {
            $form = $this->admin->getForm();
            $form->setData($existingObject);
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
            $this->validar($existingObject, $form);
            //TODO: remove this check for 4.0
            if (method_exists($this->admin, 'preValidate')) {
                $this->admin->preValidate($existingObject);
            }
            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                $submittedObject = $form->getData();
                $submittedObject->setEditado(true);
                $solicitud = $submittedObject->getSolicitud();
                $solicitud->setCantidadAprobada($submittedObject->getConceptojuntavalortotalb());
                $concepto = $this->em->getRepository("AppBundle:Concepto")->findOneById(4);
                if ($submittedObject->getAprobado()) {
                    $concepto = $this->em->getRepository("AppBundle:Concepto")->findOneById(1);
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
                    $this->em->flush();

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson([
                                    'result' => 'ok',
                                    'objectId' => $objectId,
                                    'objectName' => $this->escapeHtml($this->admin->toString($existingObject)),
                                        ], 200, []);
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

    private function setFormTheme(FormView $formView, $theme) {
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

    function validar(Conceptosjunta $concepto, $form) {
        $hoy = new DateTime();
        $totalBeneficio = 0;
        foreach ($concepto->getProgramasConcepto() as $programaConcepto) {
            $presupuesto = $this->em->getRepository("AppBundle:Presupuestos")->createQueryBuilder('p')
                            ->where("p.seccional = :seccional")
                            ->andWhere(":hoy BETWEEN p.desde AND p.hasta")
                            ->andWhere("p.idarea = :area")
                            ->setParameter("seccional", $concepto->getSolicitud()->getIdseccional())
                            ->setParameter("area", $programaConcepto->getPrograma()->getIdarea())
                            ->setParameter("hoy", $hoy)->getQuery()->getResult();
            if (!$presupuesto) {
                $form->addError(new FormError("No existe presupuesto vigente disponible para la seccional selecional " . $concepto->getSolicitud()->getIdseccional()->getSeccionalnombre() . " para el area de " . $programaConcepto->getPrograma()->getIdarea()));
            } else {
                $presupuesto = $presupuesto[0];
                $totalMovimiento = $programaConcepto->getPrograma()->getValorMes() * $concepto->getConceptojuntatiempo();
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
                    if ($presupuesto->getSaldo() < $totalMovimiento) {
                        $form->addError(new FormError("El saldo del presupuesto de la seccional " . $concepto->getSolicitud()->getIdseccional()->getSeccionalnombre() . " para el area de " . $programaConcepto->getPrograma()->getIdarea() . ", es inferior al monto de la transacción."));
                    } else {
                        $presupuesto->setSaldo($presupuesto->getSaldo() - $totalMovimiento);
                        $movimiento = new Movimiento();
                        $movimiento->setValor($totalMovimiento);
                        $movimiento->setTipo("Débito");
                        $movimiento->setSeccional($concepto->getSolicitud()->getIdseccional());
                        $movimiento->setPresupuesto($presupuesto);
                        $movimiento->setConcepto($concepto);
                        $this->em->persist($presupuesto);
                        $this->em->persist($movimiento);
                    }
                }
            }
        }
        $concepto->setConceptojuntavalortotalb($totalBeneficio);
        $this->em->persist($concepto);
    }

    public function reporteAction() {
        $concepto = new Conceptosjunta();
        $form = $this->createForm(FormularioReportesType::class, $concepto, []);
        $form->handleRequest($this->getRequest());
        return $this->renderWithExtraParams("AppBundle:Reporte:base_reporte.html.twig", [
                    'action' => 'edit',
                    'form' => $form->createView(),
                    'object' => $concepto
                        ], null);
    }

    public function dataReporteAction(Request $request) {
        $form = (array) json_decode($request->request->get('form'));
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
        }
        $respuesta['html'] = $html;
        return new JsonResponse($respuesta);
    }

    public function cargarDatosCantidades($form) {
        $query = $this->em->getRepository("AppBundle:Solicitudes")->createQueryBuilder('s')
                ->where("s.solicitudfecha BETWEEN :inicio AND :fin")
                ->setParameter("inicio", $form->fechaInicial)
                ->setParameter("fin", $form->fechaFinal);
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
                        $datos[$solicitud->getIdseccional()->getSeccionalnombre()]["total"] ++;
                    }
                } else {
                    $datos[$solicitud->getIdseccional()->getSeccionalnombre()]["total"] ++;
                }
            }
        }
        $query->join("s.conceptoJunta", "cj")
                ->andWhere("cj.editado = :editado");
        $queryAprobadas = $query;
        $queryRechazadas = $query;
        $queryAprobadas->setParameter("editado", true);
        $solicitudesAprobadas = $queryAprobadas->getQuery()->getResult();
        foreach ($solicitudesAprobadas as $solicitud) {
            foreach ($solicitud->getConceptoJunta() as $concepto) {
                foreach ($concepto->getProgramasConcepto() as $programaConcepto) {
                    if ($programaConcepto->getAprobado()) {
                        if ($form->programa != "") {
                            if ($programaConcepto->getPrograma()->getId() == $form->programa) {
                                $datos[$solicitud->getIdseccional()->getSeccionalnombre()]["aprobadas"] ++;
                            }
                        } else {
                            $datos[$solicitud->getIdseccional()->getSeccionalnombre()]["aprobadas"] ++;
                        }
                    } else {
                        if ($form->programa != "") {
                            if ($programaConcepto->getPrograma()->getId() == $form->programa) {
                                $datos[$solicitud->getIdseccional()->getSeccionalnombre()]["rechazadas"] ++;
                            }
                        } else {
                            $datos[$solicitud->getIdseccional()->getSeccionalnombre()]["rechazadas"] ++;
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

    public function cargarDatosInscritos($form) {
        $query = $this->em->getRepository("AppBundle:Solicitudes")->createQueryBuilder('s')
                ->where("s.solicitudfecha BETWEEN :inicio AND :fin")
                ->setParameter("inicio", $form->fechaInicial)
                ->setParameter("fin", $form->fechaFinal);
        if ($form->documentoSolicitante != "") {
            $query->andWhere("s.solicitudcedulasolicita = :documento")
                    ->setParameter("documento", $form->documentoSolicitante);
        }
        if ($form->documentoTitular != "") {
            $query->andWhere("s.solicitudcedulafuncionario = :documentoTitular")
                    ->setParameter("documentoTitular", $form->documentoTitular);
        }
        $solicitudes = $query->getQuery()->getResult();
        $datos = [];
        foreach ($solicitudes as $solicitud) {
            if (!array_key_exists($solicitud->getSolicitudnombrefuncionario(), $datos) && $solicitud->getNombreBeneficiarioFinal()) {
                $datos[$solicitud->getSolicitudnombrefuncionario()]["beneficiarios"]["datos"]["nombre"][] = $solicitud->getDocumentoBeneficiarioFinal() . " - " . $solicitud->getNombreBeneficiarioFinal();
                $datos[$solicitud->getSolicitudnombrefuncionario()]["beneficiarios"]["datos"]["seccional"][] = $solicitud->getIdseccional()->getSeccionalnombre();
            }
        }
        $html = $this->renderView('AppBundle:Reporte:reporte_inscritos.html.twig', [
            'datos' => $datos
        ]);
        return $html;
    }

    public function cargarDatosPresupuesto($form) {
        $query = $this->em->getRepository("AppBundle:Movimiento")->createQueryBuilder('m')
                ->join("m.seccional", "s")
                ->join("m.concepto", "c")
                ->join("c.solicitud", "so")
                ->where("so.solicitudfecha BETWEEN :inicio AND :fin")
                ->setParameter("inicio", $form->fechaInicial3)
                ->setParameter("fin", $form->fechaFinal3);
        if ($form->seccional3) {
            $query->andWhere("s.id = :seccional")
                    ->setParameter("seccional", $form->seccional3);
        }
        $movimientos = $query->getQuery()->getResult();
        $datos = [];
        foreach ($movimientos as $movimiento) {
            if (!array_key_exists($movimiento->getSeccional()->getSeccionalnombre(), $datos)) {
                $presupuestos = $this->em->getRepository("AppBundle:Presupuestos")->createQueryBuilder('p')
                                ->where("p.desde <= :inicio OR p.hasta >= :fin")
                                ->andWhere("p.seccional = :seccional")
                                ->setParameter("inicio", $form->fechaInicial3)
                                ->setParameter("fin", $form->fechaFinal3)
                                ->setParameter("seccional", $movimiento->getSeccional())
                                ->getQuery()->getResult();
                $totalValor = 0;
                foreach ($presupuestos as $presupuesto) {
                    $totalValor += $presupuesto->getPresupuestomonto();
                }
                $datos[$movimiento->getSeccional()->getSeccionalnombre()]["valor"] = $totalValor;
                $datos[$movimiento->getSeccional()->getSeccionalnombre()]["movimientos"] = $movimiento->getValor();
            } else {
                $datos[$movimiento->getSeccional()->getSeccionalnombre()]["movimientos"] += $movimiento->getValor();
            }
        }
        $html = $this->renderView('AppBundle:Reporte:reporte_presupuesto.html.twig', [
            'datos' => $datos
        ]);
        return $html;
    }

    public function cargarDatosMovimientos($form) {
        $query = $this->em->getRepository("AppBundle:Movimiento")->createQueryBuilder('m')
                ->join("m.seccional", "s")
                ->join("m.concepto", "c")
                ->join("c.solicitud", "so")
                ->where("so.solicitudfecha BETWEEN :inicio AND :fin")
                ->setParameter("inicio", $form->fechaInicial3)
                ->setParameter("fin", $form->fechaFinal3);
        if ($form->documentoSolicitante2) {
            $query->andWhere("so.solicitudcedulasolicita = :cedula")
                    ->setParameter("cedula", $form->documentoSolicitante2);
        }
        if ($form->documentoTitular2) {
            $query->andWhere("so.solicitudcedulafuncionario = :cedulaTitular")
                    ->setParameter("cedulaTitular", $form->documentoTitular2);
        }
        if ($form->seccional4) {
            $query->andWhere("s.idseccional = :seccional")
                    ->setParameter("seccional", $form->seccional4);
        }
        if ($form->programa2) {
            $query->join("s.programas", "sp")
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

}

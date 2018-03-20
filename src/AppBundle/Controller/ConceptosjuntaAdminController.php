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
        }

        $this->admin->checkAccess('edit', $existingObject);

        $preResponse = $this->preEdit($request, $existingObject);
        if (null !== $preResponse) {
            return $preResponse;
        }

        $this->admin->setSubject($existingObject);
        $objectId = $this->admin->getNormalizedIdentifier($existingObject);

        /** @var $form Form */
        $form = $this->admin->getForm();
        $form->setData($existingObject);
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
                $this->admin->setSubject($submittedObject);

                try {
                    $existingObject = $this->admin->update($submittedObject);

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
                            ->setParameter("hoy", $hoy)->getQuery()->getOneOrNullResult();
            if (!$presupuesto) {
                $form->addError(new FormError("No existe presupuesto vigente disponible para la seccional selecional " . $concepto->getSolicitud()->getIdseccional()->getSeccionalnombre() . " para el area de " . $programaConcepto->getPrograma()->getIdarea()));
            } else {
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
        if ($form->isSubmitted()) {
            
        }

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
                if (!array_key_exists($programa->getPrograma()->getProgramanombre(), $datos)) {
                    $datos[$programa->getPrograma()->getProgramanombre()]["total"] = 1;
                } else {
                    $datos[$programa->getPrograma()->getProgramanombre()]["total"] ++;
                }
            }
        }
        $html = $this->renderView('AppBundle:Reporte:reporte_cantidades.html.twig', [
            'datos' => $datos
        ]);

        return $html;
    }

    public function cargarDatosInscritos($form) {
        
    }

    public function cargarDatosPresupuesto($form) {
        
    }

    public function cargarDatosMovimientos($form) {
        
    }

}

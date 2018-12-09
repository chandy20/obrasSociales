<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Conceptosjunta;
use AppBundle\Entity\ProgramaConcepto;
use AppBundle\Entity\ProgramaSolicitud;
use ReflectionClass;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Bridge\Twig\AppVariable;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bundle\TwigBundle\Command\DebugCommand;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AppBundle\Form\ImportarDatosFormType;
use AppBundle\ValidData\Validaciones;
use AppBundle\ValidData\ValidarDatos;

class SolicitudesAdminController extends CRUDController {

    /**
     * Create action.
     *
     * @throws AccessDeniedException If access is not granted
     *
     * @return Response
     */
    public function createAction() {
        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'edit';

        $this->admin->checkAccess('create');

        $class = new ReflectionClass($this->admin->hasActiveSubClass() ? $this->admin->getActiveSubClass() : $this->admin->getClass());

        if ($class->isAbstract()) {
            return $this->renderWithExtraParams(
                            '@SonataAdmin/CRUD/select_subclass.html.twig', [
                        'base_template' => $this->getBaseTemplate(),
                        'admin' => $this->admin,
                        'action' => 'create',
                            ], null
            );
        }

        $newObject = $this->admin->getNewInstance();

        $preResponse = $this->preCreate($request, $newObject);
        if (null !== $preResponse) {
            return $preResponse;
        }

        $this->admin->setSubject($newObject);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($newObject);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $this->validaciones($form);
            $isFormValid = $form->isValid();
            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                $enviado = $request->request->all();
                $em = $this->container->get('doctrine')->getManager();
                $puntaje = 0;
                $concepto = '';
                try {
                    $entity = $submittedObject = $form->getData();
                    $entity->setProgramas(null);
                    foreach ($enviado[$form->getName()]['programas'] as $prog) {
                        $programa = $em->getRepository('AppBundle:Programas')->findOneById($prog);
                        $programaSolicitud = new ProgramaSolicitud($programa, $entity);
                        $em->persist($programaSolicitud);
                        $entity->addPrograma($programaSolicitud);
                    }
                    if ($entity->getIdingreso() != null) {
                        $puntaje += $entity->getIdingreso()->getIngresopuntaje();
                    }
                    if ($entity->getIdpoblacionbeneficia() != null) {
                        $puntaje += $entity->getIdpoblacionbeneficia()->getPoblacionBeneficiaPuntaje();
                    }
                    if ($entity->getIdzonaubicacion() != null) {
                        $puntaje += $entity->getIdzonaubicacion()->getZonasUbicacionPuntaje();
                    }
                    if ($entity->getIdviabilidadplaneacion() != null) {
                        $puntaje += $entity->getIdviabilidadplaneacion()->getViabilidadPlaneacionPuntaje();
                    }
                    if ($entity->getIdcantidadesbeneficioinst() != null) {
                        $puntaje += $entity->getIdcantidadesbeneficioinst()->getCantidadesBeneficioInstPuntaje();
                    }
                    if ($entity->getIdafiliadodibie() != null) {
                        $puntaje += $entity->getIdafiliadodibie()->getAfiliadoDibiePorcentaje();
                    }
                    if ($entity->getIdsituacionvivienda() != null) {
                        $puntaje += $entity->getIdsituacionvivienda()->getSituacionesViviendaPuntaje();
                    }
                    if ($entity->getIdpersonacargo() != null) {
                        $puntaje += $entity->getIdpersonacargo()->getPersonasCargoPuntaje();
                    }
                    if ($entity->getIdmotivodeuda() != null) {
                        $puntaje += $entity->getIdmotivodeuda()->getMotivoDeudaPuntaje();
                    }
                    if ($entity->getIdconceptovisita() != null) {
                        $puntaje += $entity->getIdconceptovisita()->getConceptosVisitaPuntaje();
                    }
                    $file = $entity->getCurriculum();

                    if ($file) {
                        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                        $entity->setArchivo($fileName);
                        $file->move(
                                $this->getParameter('uploads_directory'), $fileName
                        );
                    }
                    $foto = $entity->getFotoFile();
                    if ($foto) {
                        $fileName = md5(uniqid()) . '.' . $foto->guessExtension();
                        $entity->setFoto($fileName);
                        $foto->move(
                                $this->getParameter('uploads_directory'), $fileName
                        );
                    }
                    $entity->setTotalPuntaje($puntaje);


                    if ($puntaje >= 60) {
                        $concepto = $em->getRepository("AppBundle:Concepto")->findOneBy(["id" => 2]);
                    } else if ($puntaje <= 40) {
                        $concepto = $em->getRepository("AppBundle:Concepto")->findOneBy(["id" => 4]);
                    } else if ($puntaje <= 59 and $puntaje >= 45) {
                        $concepto = $em->getRepository("AppBundle:Concepto")->findOneBy(["id" => 3]);
                    }
                    $entity->setConcepto($concepto);
                    $conceptoJunta = new Conceptosjunta();
                    $conceptoJunta->setSolicitud($entity);
                    $em->persist($conceptoJunta);
                    $em->flush();
                    $cantidadSolicitada = 0;
                    foreach ($entity->getProgramas() as $programaSolicitud) {
                        $programaConcepto = new ProgramaConcepto();
                        $programaConcepto->setConceptoJunta($conceptoJunta);
                        $programaConcepto->setPrograma($programaSolicitud->getPrograma());
                        $programaConcepto->setAprobado(false);
                        $em->persist($programaConcepto);
                        $cantidadSolicitada += $programaSolicitud->getPrograma()->getValorMes();
                    }
                    $entity->setCantidadSolicitada($cantidadSolicitada);
                    $em->persist($entity);
                    $em->flush();

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson([
                                    'result' => 'ok',
                                    'objectId' => $this->admin->getNormalizedIdentifier($newObject),
                                        ], 200, []);
                    }

                    $this->addFlash(
                            'sonata_flash_success', $this->trans(
                                    'flash_create_success', ['%name%' => $this->escapeHtml($this->admin->toString($newObject))], 'SonataAdminBundle'
                            )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($newObject);
                } catch (ModelManagerException $e) {
                    $this->handleModelManagerException($e);

                    $isFormValid = false;
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                            'sonata_flash_error', $this->trans(
                                    'flash_create_error', ['%name%' => $this->escapeHtml($this->admin->toString($newObject))], 'SonataAdminBundle'
                            )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $formView = $form->createView();
        // set the theme for the current Admin Form
        $this->setFormTheme($formView, $this->admin->getFormTheme());

        // NEXT_MAJOR: Remove this line and use commented line below it instead
        $template = $this->admin->getTemplate($templateKey);
        // $template = $this->templateRegistry->getTemplate($templateKey);

        return $this->renderWithExtraParams($template, [
                    'action' => 'create',
                    'form' => $formView,
                    'object' => $newObject,
                    'objectId' => null,
                        ], null);
    }

    public function validaciones($form) {
        $tipoDeSolicitud = $form->get("idtiposolicitud")->getData();
        if ($tipoDeSolicitud) {
            if ($tipoDeSolicitud->getTiposolicitudnombre() == "Familiar y personal") {
                if (!$form->get("idestadocivil")->getdata()) {
                    $form->get("idestadocivil")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("idingreso")->getdata()) {
                    $form->get("idingreso")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("idpersonacargo")->getdata()) {
                    $form->get("idpersonacargo")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("idsituacionvivienda")->getdata()) {
                    $form->get("idsituacionvivienda")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("idmotivodeuda")->getdata()) {
                    $form->get("idmotivodeuda")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("cantidadesbeneficio")->getdata()) {
                    $form->get("cantidadesbeneficio")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("idconceptovisita")->getdata()) {
                    $form->get("idconceptovisita")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("idafiliadodibie")->getdata()) {
                    $form->get("idafiliadodibie")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("documentoBeneficiarioFinal")->getdata()) {
                    $form->get("documentoBeneficiarioFinal")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("nombreBeneficiarioFinal")->getdata()) {
                    $form->get("nombreBeneficiarioFinal")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("antiguedad")->getdata()) {
                    $form->get("antiguedad")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("solicitudcedulafuncionario")->getdata()) {
                    $form->get("solicitudcedulafuncionario")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("idgrado")->getdata()) {
                    $form->get("idgrado")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("unidad")->getdata()) {
                    $form->get("unidad")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("solicitudnombrefuncionario")->getdata()) {
                    $form->get("solicitudnombrefuncionario")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("solicituddireccionfuncionario")->getdata()) {
                    $form->get("solicituddireccionfuncionario")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("solicitudtelefonosfuncionario")->getdata()) {
                    $form->get("solicitudtelefonosfuncionario")->addError(new FormError("Este valor no debería estar vacío"));
                }
            } else if ($tipoDeSolicitud->getTiposolicitudnombre() == "Institucional") {
                if (!$form->get("idpoblacionbeneficia")->getdata()) {
                    $form->get("idpoblacionbeneficia")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("idviabilidadplaneacion")->getdata()) {
                    $form->get("idviabilidadplaneacion")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("idzonaubicacion")->getdata()) {
                    $form->get("idzonaubicacion")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("idcantidadesbeneficioinst")->getdata()) {
                    $form->get("idcantidadesbeneficioinst")->addError(new FormError("Este valor no debería estar vacío"));
                }
            }
            if (!$form->get("curriculum")->getdata()) {
                $form->get("curriculum")->addError(new FormError("Por favor adjunte la documentación"));
            }
            if (count($form->get("programas")->getdata()) == 0) {
                $form->get("programas")->addError(new FormError("Seleccióne al menos un programa del listado"));
            }
            $fotoFormulario = $form->get("fotoFile")->getdata();
            if ($fotoFormulario) {
                $imagen = getimagesize($fotoFormulario);    //Sacamos la información
                $ancho = $imagen[0];              //Ancho
                $alto = $imagen[1];               //Alto
            }
        }
    }

    /**
     * Sets the admin form theme to form view. Used for compatibility between Symfony versions.
     *
     * @param string $theme
     */
    public function setFormTheme(FormView $formView, $theme) {
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

    public function importarAction() {
        $request = $this->getRequest();
        $form = $this->createForm(ImportarDatosFormType::class, null);
        $form->handleRequest($request);
        $titulo = 'label.importar';
        $validar = new ValidarDatos($this->container);
        $validaciones = new Validaciones($this->container);

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

                $validar = $validar->validar($datos, $validaciones->getValidacionInventario());
                if (is_array($validar)) {
                    foreach ($validar as $mensaje) {
                        $request->getSession()->getFlashBag()->add('sonata_flash_error', $mensaje);
                    }
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

}

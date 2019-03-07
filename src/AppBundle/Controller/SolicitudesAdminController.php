<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Concepto;
use AppBundle\Entity\Conceptosjunta;
use AppBundle\Entity\ProgramaConcepto;
use AppBundle\Entity\ProgramaSolicitud;
use AppBundle\Entity\Solicitudes;
use AppBundle\Form\ImportarDatosFormType;
use AppBundle\Form\ReemplazarArchivo;
use AppBundle\ValidData\Validaciones;
use AppBundle\ValidData\ValidacionesFamiliares;
use AppBundle\ValidData\ValidacionesInstitucionales;
use AppBundle\ValidData\ValidarDatos;
use DateTime;
use ReflectionClass;
use Sonata\AdminBundle\Controller\CRUDController;
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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SolicitudesAdminController extends CRUDController
{

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->em = $container->get("doctrine")->getManager();
    }

    /**
     * Create action.
     *
     * @throws AccessDeniedException If access is not granted
     *
     * @return Response
     */
    public function createAction()
    {
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
                    $this->getPuntaje($entity);
                    $puntaje = $entity->getTotalPuntaje();
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
                    $entity->setUsuario($this->getUser());
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

    /**
     * Edit action.
     *
     * @param int|string|null $id
     *
     * @throws NotFoundHttpException If the object does not exist
     * @throws AccessDeniedException If access is not granted
     *
     * @return Response|RedirectResponse
     */
    public function editAction($id = null)
    {
        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'edit';

        $id = $request->get($this->admin->getIdParameter());
        $existingObject = $this->admin->getObject($id);

        $em = $this->container->get('doctrine')->getManager();

        $concepto = $em->getRepository('AppBundle:Conceptosjunta')->findOneBySolicitud($existingObject);
        if ($concepto && !is_null($concepto->getAprobado())) {
            $this->addFlash(
                'sonata_flash_error',
                "Esta solicitud ya fue revisada. No es posible editarla"
            );
            return $this->redirect($this->generateUrl('admin_app_solicitudes_list'));
        }

        if (!$existingObject) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }

        $this->checkParentChildAssociation($request, $existingObject);

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
            $this->validaciones($form);
            $isFormValid = $form->isValid();
            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                $enviado = $request->request->all();
                $puntaje = 0;
                $concepto = '';
                try {
                    $entity = $submittedObject = $form->getData();
                    $em = $this->getDoctrine()->getManager();
                    $stmt = $em->getConnection()->prepare('SELECT * FROM programa_solicitud WHERE solicitud_id =' . $entity->getId());
                    $stmt->execute();
                    $programasSolcitud = $stmt->fetchAll();
                    foreach ($programasSolcitud as $programaSolicitud) {
                        $programaSolicitud = $em->getRepository('AppBundle:ProgramaSolicitud')->find($programaSolicitud['id']);
                        if ($programaSolicitud) {
                            $em->remove($programaSolicitud);
                        }
                    }
                    $entity->setProgramas(null);
                    $em->flush();
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
                    $conceptosExistente = $em->getRepository('AppBundle:Conceptosjunta')->findBy(['solicitud' => $entity]);
                    foreach ($conceptosExistente as $concepto) {
                        $em->remove($concepto);
                    }
                    $em->flush();
                    $conceptoJunta = new Conceptosjunta();
                    $conceptoJunta->setSolicitud($entity);
                    $em->persist($conceptoJunta);
                    $em->persist($entity);
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
                            'objectId' => $objectId,
                            'objectName' => $this->escapeHtml($this->admin->toString($existingObject)),
                        ], 200, []);
                    }

                    $this->addFlash(
                        'sonata_flash_success',
                        $this->trans(
                            'flash_edit_success',
                            ['%name%' => $this->escapeHtml($this->admin->toString($existingObject))],
                            'SonataAdminBundle'
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
                        'sonata_flash_error',
                        $this->trans(
                            'flash_edit_error',
                            ['%name%' => $this->escapeHtml($this->admin->toString($existingObject))],
                            'SonataAdminBundle'
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

        // NEXT_MAJOR: Remove this line and use commented line below it instead
        $template = $this->admin->getTemplate($templateKey);
        // $template = $this->templateRegistry->getTemplate($templateKey);

        return $this->renderWithExtraParams($template, [
            'action' => 'edit',
            'form' => $formView,
            'object' => $existingObject,
            'objectId' => $objectId,
        ], null);
    }

    private function checkParentChildAssociation(Request $request, $object)
    {
        if (!($parentAdmin = $this->admin->getParent())) {
            return;
        }

        // NEXT_MAJOR: remove this check
        if (!$this->admin->getParentAssociationMapping()) {
            return;
        }

        $parentId = $request->get($parentAdmin->getIdParameter());

        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $propertyPath = new PropertyPath($this->admin->getParentAssociationMapping());

        if ($parentAdmin->getObject($parentId) !== $propertyAccessor->getValue($object, $propertyPath)) {
            // NEXT_MAJOR: make this exception
            @trigger_error("Accessing a child that isn't connected to a given parent is deprecated since 3.34"
                . " and won't be allowed in 4.0.",
                E_USER_DEPRECATED
            );
        }
    }

    public function validaciones($form)
    {
        $tipoDeSolicitud = $form->get("idtiposolicitud")->getData();

        if (!$form->get("direccionSolicitante")->getdata()) {
            $form->get("direccionSolicitante")->addError(new FormError("Este valor no debería estar vacío"));
        }
        if (!$form->get("telefonoSolicitante")->getdata()) {
            $form->get("telefonoSolicitante")->addError(new FormError("Este valor no debería estar vacío"));
        }
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
                if (!$form->get("solicitudcedulafuncionario")->getdata()) {
                    $form->get("solicitudcedulafuncionario")->addError(new FormError("Este valor no debería estar vacío"));
                }
                if (!$form->get("idgrado")->getdata()) {
                    $form->get("idgrado")->addError(new FormError("Este valor no debería estar vacío"));
                } else if ($form->get("idgrado")->getdata()->getId() != 30 && $form->get("idgrado")->getdata()->getId() != 31) {
                    if (!$form->get("antiguedad")->getdata()) {
                        $form->get("antiguedad")->addError(new FormError("Este valor no debería estar vacío"));
                    }
                    if (!$form->get("unidad")->getdata()) {
                        $form->get("unidad")->addError(new FormError("Este valor no debería estar vacío"));
                    }
                    if (!$form->get("solicitudnombrefuncionario")->getdata()) {
                        $form->get("solicitudnombrefuncionario")->addError(new FormError("Este valor no debería estar vacío"));
                    }
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
            if (!$form->getData()->getId()) {
                if (!$form->get("curriculum")->getdata()) {
                    $form->get("curriculum")->addError(new FormError("Por favor adjunte la documentación"));
                }
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
    public function setFormTheme(FormView $formView, $theme)
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
            $solicitud->setSolicitudfecha(DateTime::createFromFormat('d/m/Y', $dato['FECHA_DE_SOLICITUD']['valor']));
            $solicitud->setIdseccional($this->em->getRepository("AppBundle:Seccionales")->findOneBySeccionalnombre($dato['SECCIONAL']['valor']));
            $solicitud->setIdtiposolicitud($this->em->getRepository("AppBundle:Tipossolicitud")->findOneByTiposolicitudnombre($dato['TIPO_SOLICITUD']['valor']));
            $solicitud->setSolicitudcedulasolicita($dato['CEDULA_SOLICITANTE']['valor']);
            $solicitud->setSolicitudnombresolicita($dato['NOMBRE_Y_APELLIDO_SOLICITANTE']['valor']);
            $solicitud->setEmailSolicitante($dato['EMAIL']['valor']);
            $solicitud->setDireccionSolicitante($dato['DIRECCION']['valor']);
            $solicitud->setTelefonoSolicitante($dato['TELEFONO']['valor']);
            $solicitud->setTelefonoSolicitante2($dato['TELEFONO_ALTERNO']['valor']);
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
            $solicitud->setNombreBeneficiarioFinal($dato['NOMBRE_BENEFICIARIO_FINAL']['valor']);
            $programas = explode(";", $dato['MODALIDADES']['valor']);
            $conceptoJunta = new Conceptosjunta();
            $conceptoJunta->setSolicitud($solicitud);
            foreach ($programas as $prog) {
                $programa = $this->em->getRepository("AppBundle:Programas")->findOneByProgramanombre($prog);
                $programaConcepto = new ProgramaConcepto();
                $programaConcepto->setConceptoJunta($conceptoJunta);
                $programaConcepto->setPrograma($programa);
                $programaConcepto->setAprobado(false);
                $conceptoJunta->addProgramasConcepto($programaConcepto);
                $programaSolicitud = new ProgramaSolicitud($programa, $solicitud);
                $solicitud->addPrograma($programaSolicitud);
                $this->em->persist($programaSolicitud);
                $this->em->persist($programaConcepto);
            }

            $this->getPuntaje($solicitud);
            $puntaje = $solicitud->getTotalPuntaje();
            if ($puntaje >= 60) {
                $concepto = $this->em->getRepository("AppBundle:Concepto")->findOneBy(["id" => 2]);
            } else if ($puntaje <= 40) {
                $concepto = $this->em->getRepository("AppBundle:Concepto")->findOneBy(["id" => 4]);
            } else if ($puntaje <= 59 and $puntaje >= 45) {
                $concepto = $this->em->getRepository("AppBundle:Concepto")->findOneBy(["id" => 3]);
            }
            $solicitud->setConcepto($concepto);
            $solicitud->setUsuario($this->getUser());
            $this->em->persist($solicitud);
            $fechaActual = new DateTime();
            if($solicitud->getSolicitudfecha()->format("Y") < $fechaActual->format('Y')){
                $conceptoJunta->setAprobado(true);
                $conceptoJunta->setConceptosjuntadesc("Aprobado por cargue de archivo plano");
            }
            $this->em->persist($conceptoJunta);
        }
        $this->em->flush();
    }

    public function consultarAction()
    {
        $request = $this->getRequest();
        $solicitud = $this->em->getRepository("AppBundle:Solicitudes")->findOneBySolicitudcedulasolicita($request->get("documento"));
        $solicitudes = $this->em->getRepository("AppBundle:Conceptosjunta")->createQueryBuilder('c')
            ->join('c.solicitud', 's')
            ->where('c.aprobado = :aprobado')
            ->andWhere('s.solicitudcedulasolicita = :documento')
            ->setParameters(['aprobado' => true, 'documento' => $request->get("documento")])
            ->getQuery()
            ->getResult();
        $response = [];
        if ($solicitud) {
            $response["beneficios"] = count($solicitudes);
            $response["seccional"] = $solicitud->getIdseccional()->getId();
            $response["tipoSoliciutd"] = $solicitud->getIdtiposolicitud()->getId();
            $response["cedulaSolicitante"] = $solicitud->getSolicitudcedulasolicita();
            $response["nombreSolicitante"] = $solicitud->getSolicitudnombresolicita();
            $response["email"] = $solicitud->getEmailSolicitante();
            $response["direccion"] = $solicitud->getSolicituddireccionfuncionario();
            $response["telefono"] = $solicitud->getSolicitudtelefonosfuncionario();
            $response["documentoPolicia"] = $solicitud->getSolicitudcedulafuncionario();
            $grado = $solicitud->getIdgrado();
            if ($grado) {
                $response["grado"] = $grado->getid();
            }
            $unidad = $solicitud->getUnidad();
            if ($grado) {
                $response["unidad"] = $unidad->getid();
            }
            $response["nombrePolicia"] = $solicitud->getSolicitudnombrefuncionario();
            $antiguedad = $solicitud->getAntiguedad();
            if ($antiguedad) {
                $response["antiguedad"] = $antiguedad->getid();
            }
            $poblacion = $solicitud->getIdpoblacionbeneficia();
            if ($poblacion) {
                $response["poblacion"] = $poblacion->getid();
            }
            $viabilidad = $solicitud->getIdviabilidadplaneacion();
            if ($viabilidad) {
                $response["viabilidad"] = $viabilidad->getid();
            }
            $zona = $solicitud->setIdzonaubicacion();
            if ($zona) {
                $response["zona"] = $zona->getid();
            }
            $beneficioIns = $solicitud->getIdcantidadesbeneficioinst();
            if ($beneficioIns) {
                $response["beneficioIns"] = $beneficioIns->getid();
            }
            $parentesco = $solicitud->getIdparentesco();
            if ($parentesco) {
                $response["parentesco"] = $parentesco->getid();
            }
            $estadoCivil = $solicitud->getIdestadocivil();
            if ($estadoCivil) {
                $response["estadoCivil"] = $estadoCivil->getid();
            }
            $ingreso = $solicitud->getIdingreso();
            if ($ingreso) {
                $response["ingreso"] = $ingreso->getid();
            }
            $personasCargo = $solicitud->getIdpersonacargo();
            if ($personasCargo) {
                $response["personasCargo"] = $personasCargo->getid();
            }
            $situacionVivienda = $solicitud->getIdsituacionvivienda();
            if ($situacionVivienda) {
                $response["situacionVivienda"] = $situacionVivienda->getid();
            }
            $dificultad = $solicitud->getIdmotivodeuda();
            if ($dificultad) {
                $response["dificultad"] = $dificultad->getid();
            }
            $cantidadBeneficios = $solicitud->getCantidadesbeneficio();
            if ($cantidadBeneficios) {
                $response["cantidadBeneficios"] = $cantidadBeneficios->getCantidadesbeneficioId();
            }
            $conceptoVisita = $solicitud->getIdconceptovisita();
            if ($conceptoVisita) {
                $response["conceptoVisita"] = $conceptoVisita->getIdconceptovisita();
            }
            $afiliado = $solicitud->getIdafiliadodibie();
            if ($afiliado) {
                $response["afiliado"] = $afiliado->getIdafiliadodibie();
            }
            $response["documentoBeneficiario"] = $solicitud->getDocumentoBeneficiarioFinal();
            $response["nombreBeneficiario"] = $solicitud->getNombreBeneficiarioFinal();

            return new JsonResponse($response);
        }
        return new JsonResponse($response);

    }

    public function replaceFileAction($id)
    {
        $request = $this->getRequest();
        $form = $this->createForm(ReemplazarArchivo::class, null);
        $form->handleRequest($request);
        $titulo = 'label.reemplazar';
        $directory = $this->getParameter('uploads_directory');

        if ($form->isSubmitted()) {
            $isFormValid = $form->isValid();

            if ($isFormValid) {
                $file = $request->files->all()['reemplazar_archivo']['file'];
                $solicitud = $this->em->getRepository("AppBundle:Solicitudes")->findOneById($id);
                try {
                    unlink($directory . "/" . $solicitud->getArchivo());
                } catch (\Exception $e) {

                }
                try {
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                    $solicitud->setArchivo($fileName);
                    $this->em->persist($solicitud);
                    $this->em->flush();
                    $file->move(
                        $this->getParameter('uploads_directory'), $fileName
                    );
                    $request->getSession()->getFlashBag()->add('sonata_flash_success', $this->admin->trans('mensaje.datos.reemplazados'));
                } catch (Exception $e) {
                    $request->getSession()->getFlashBag()->add('sonata_flash_error', $this->admin->trans('error.importando.datos'));
                }
            }
        }

        return $this->renderWithExtraParams($this->admin->getTemplate("replaceFile"), [
            'titulo' => $titulo,
            'form' => $form->createView(),
        ], null);

    }

    public function getPuntaje($entity){
        $puntaje = 0;
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
        $entity->setTotalPuntaje($puntaje);
    }
}

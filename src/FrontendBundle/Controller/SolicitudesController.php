<?php

namespace FrontendBundle\Controller;

use AppBundle\Entity\Conceptosjunta;
use AppBundle\Entity\ProgramaConcepto;
use AppBundle\Entity\ProgramaSolicitud;
use AppBundle\Entity\Solicitudes;
use FrontendBundle\Form\SolicitudesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Solicitudes controller.
 *
 * @Route("/solicitudes")
 */
class SolicitudesController extends Controller {

    /**
     * Lists all Solicitudes entities.
     *
     * @Route("/", name="solicitudes")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Solicitudes')->findAll();

        return array(
            'entities' => $entities
        );
    }

    /**
     * Creates a new Solicitudes entity.
     *
     * @Route("/create", name="solicitudes_create")
     * @Method("POST")
     * @Template("FrontendBundle:Solicitudes:new.html.twig")
     */
    public function createAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $entity = new Solicitudes();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $puntaje = 0;
        $concepto = '';
        $enviado = $request->request->all();
        $this->validaciones($form);
        if ($form->isValid()) {
            foreach ($enviado['frontendbundle_solicitudes']['programas'] as $prog) {
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
            $em = $this->getDoctrine()->getManager();
            $entity->setTotalPuntaje($puntaje);


            if ($puntaje >= 60) {
                $concepto = $em->getRepository("AppBundle:Concepto")->findOneBy(["nombre" => "Pre aprovado"]);
            } else if ($puntaje <= 40) {
                $concepto = $em->getRepository("AppBundle:Concepto")->findOneBy(["nombre" => "Rechazado"]);
            } else if ($puntaje <= 59 and $puntaje >= 45) {
                $concepto = $em->getRepository("AppBundle:Concepto")->findOneBy(["nombre" => "Análisis junta"]);
            }
            $entity->setConcepto($concepto);
            $conceptoJunta = new Conceptosjunta();
            $conceptoJunta->setSolicitud($entity);
            $em->persist($conceptoJunta);
            foreach ($entity->getProgramas() as $programaSolicitud) {
                $programaConcepto = new ProgramaConcepto();
                $programaConcepto->setConceptoJunta($conceptoJunta);
                $programaConcepto->setPrograma($programaSolicitud->getPrograma());
                $programaConcepto->setAprobado(false);
                $em->persist($programaConcepto);
            }
            $em->persist($entity);
            $em->flush();


            return $this->redirect($this->generateUrl('solicitudes_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Solicitudes entity.
     *
     * @param Solicitudes $entity The entity
     *
     * @return Form The form
     */
    private function createCreateForm(Solicitudes $entity) {
        $form = $this->createForm(new SolicitudesType(), $entity, array(
            'action' => $this->generateUrl('solicitudes_create'),
            'method' => 'POST',
            'em' => $em = $this->getDoctrine()->getManager(),
        ));

        $form->add('submit', 'submit', array('label' => 'Enviar'));


        return $form;
    }

    /**
     * Displays a form to create a new Solicitudes entity.
     *
     * @Route("/new", name="solicitudes_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Solicitudes();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Solicitudes entity.
     *
     * @Route("/{id}", name="solicitudes_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Solicitudes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitudes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Solicitudes entity.
     *
     * @Route("/{id}/edit", name="solicitudes_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Solicitudes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitudes entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $createEditForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Solicitudes entity.
     *
     * @param Solicitudes $entity The entity
     *
     * @return Form The form
     */
    private function createEditForm(Solicitudes $entity) {
        $form = $this->createForm(new SolicitudesType(), $entity, array(
            'action' => $this->generateUrl('solicitudes_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }

    /**
     * Edits an existing Solicitudes entity.
     *
     * @Route("/{id}", name="solicitudes_update")
     * @Method("PUT")
     * @Template("FrontendBundle:Solicitudes:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Solicitudes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitudes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('solicitudes_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Solicitudes entity.
     *
     * @Route("/{id}", name="solicitudes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Solicitudes')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Solicitudes entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('solicitudes'));
    }

    /**
     * Creates a form to delete a Solicitudes entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('solicitudes_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Eliminar Registro'))
                        ->getForm()
        ;
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

}

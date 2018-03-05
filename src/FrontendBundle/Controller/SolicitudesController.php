<?php

namespace FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Solicitudes;
use FrontendBundle\Form\SolicitudesType;
use AppBundle\Entity\ProgramaSolicitud;

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
        $no = 'NO APROBADO';
        $si = 'APROBADO';
        $analisis = 'ANALISIS JUNTA';
        $enviado = $request->request->all();
        if ($form->isValid()) {
            foreach ($enviado['programas'] as $prog) {
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

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $entity->setArchivo($fileName);
            // Move the file to the directory where brochures are stored
            $file->move(
                    $this->getParameter('uploads_directory'), $fileName
            );
            $em = $this->getDoctrine()->getManager();
            $entity->setTotalPuntaje($puntaje);
            $entity->setconcepto($concepto);
            $entity->setsolicitudconceptopre($concepto);


            if ($puntaje >= 60) {
                $entity->setsolicitudconceptopre($si);
            } else if ($puntaje <= 40) {
                $entity->setsolicitudconceptopre($no);
            } else if ($puntaje <= 59 and $puntaje >= 45) {
                $entity->setsolicitudconceptopre($analisis);
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
     * @return \Symfony\Component\Form\Form The form
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
     * @return \Symfony\Component\Form\Form The form
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
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('solicitudes_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Eliminar Registro'))
                        ->getForm()
        ;
    }

}

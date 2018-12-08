<?php

namespace AppBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\ImportarDatosFormType;
use AppBundle\ValidData\Validaciones;
use AppBundle\ValidData\ValidarDatos;

class SolicitudesAdminController extends CRUDController
{

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

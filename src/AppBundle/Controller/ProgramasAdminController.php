<?php

namespace AppBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProgramasAdminController extends CRUDController {

    public function ajaxProgramasPorAreaAction(Request $request) {
        $area = $request->request->get('area_id');
        $area = $area != "" ? $area : 0;
        $em = $this->container->get('doctrine')->getManager();
        $programas = $em->getRepository('AppBundle:Programas')->findBy(array('idarea' => $area), array('programanombre' => 'ASC'));
        $respuesta = array();
        foreach ($programas as $programa) {
            array_push($respuesta, array('id' => $programa->getId(), 'nombre' => $programa->getProgramanombre()));
        }
        return $this->json($respuesta);
    }

    public function ajaxProgramasPorProgramaPadreAction(Request $request) {
        $programaPadre = $request->request->get('programa_id');
        $programaPadre = $programaPadre != "" ? $programaPadre : 0;
        $em = $this->container->get('doctrine')->getManager();
        $programas = $em->getRepository('AppBundle:Programas')->findBy(array('programa' => $programaPadre), array('programanombre' => 'ASC'));
        $respuesta = array();
        foreach ($programas as $programa) {
            array_push($respuesta, array('id' => $programa->getId(), 'nombre' => $programa->getProgramanombre()));
        }
        return $this->json($respuesta);
    }

    protected function json($data, $status = 200, $headers = array(), $context = array()) {
        if ($this->container->has('serializer')) {
            $json = $this->container->get('serializer')->serialize($data, 'json', array_merge(array(
                'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
                            ), $context));

            return new JsonResponse($json, $status, $headers, true);
        }

        return new JsonResponse($data, $status, $headers);
    }

}

<?php

namespace AppBundle\Form\EventListener;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AddProgramasFieldSubscriber implements EventSubscriberInterface {

    public $presupuesto = false;

    public function __construct($presupuesto = false) {
        $this->presupuesto = $presupuesto;
    }

    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }

    private function addProgramasForm($form, $padre, $multiple, $valores) {

        $formOptions = array(
            "class" => "AppBundle:Programas",
            "label" => "label.programas",
            "empty_value" => 'label.seleccion',
            "required" => true,
            'mapped' => true,
            'multiple' => $multiple,
            'query_builder' => function (EntityRepository $repository) use ($padre) {
                $padre = $padre ?: 0;
                $qb = $repository->createQueryBuilder('p')
                        ->join('p.programa', 'pp')
                        ->where('pp.id IN (:padre)')
                        ->orderBy("pp.programanombre", 'DESC')
                        ->setParameter('padre', $padre);
                return $qb;
            },
        );
        if ($multiple) {
            if ($valores) {
                $programas = [];
                foreach ($valores as $valor) {
                    $programas[] = $valor->getPrograma();
                }
                $formOptions['data'] = $programas;
            }
            $form->add('programas', EntityType::class, $formOptions);
        } else {
            if ($valores) {
                $formOptions['data'] = $valores;
            }
            $form->add('programa', EntityType::class, $formOptions);
        }
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }
        if (property_exists($data, 'programas')) {
            $padres = null;
            if (count($data->getProgramas()) > 0) {
                foreach ($data->getProgramas() as $padre) {
                    if ($padre->getPrograma()->getPrograma()) {
                        $padres[] = $padre->getPrograma()->getPrograma()->getId();
                    }
                }
            }
            $valores = $data->getProgramas();
        } else {
            $padres = $data->getPrograma() ? $data->getPrograma()->getPrograma() : null;
            $valores = $data->getPrograma();
        }
        $this->addProgramasForm($form, $padres, property_exists($data, 'programas'), $valores);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();
        if (null === $data) {
            return;
        }
        $padre = array_key_exists('programaPadre', $data) ? $data['programaPadre'] : null;
        $multiple = false;
        try {
            $multiple = $form->get('programas') ? true : false;
        } catch (\Exception $e) {
            $multiple = false;
        }
        $this->addProgramasForm($form, $padre, $multiple, null);
    }

}

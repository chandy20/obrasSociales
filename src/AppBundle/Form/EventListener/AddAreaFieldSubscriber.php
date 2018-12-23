<?php

namespace AppBundle\Form\EventListener;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AddAreaFieldSubscriber implements EventSubscriberInterface {

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

    private function addAreaForm($form, $area) {
        $formOptions = array(
            "class" => "AppBundle:Areas",
            "label" => "label.area",
            "required" => true,
            "empty_value" => 'label.seleccion',
            'mapped' => $this->presupuesto,
            'attr' => [
                'onchange' => 'actualizarProgramasPadres(this);',
            ],
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('a')
                                ->orderBy('a.areanombre', 'ASC');
            },
        );

        if ($area) {
            $formOptions['data'] = $area;
        }
        $nombreCampo = 'area';
        if ($this->presupuesto) {
            $nombreCampo = 'idarea';
        }
        $form->add($nombreCampo, EntityType::class, $formOptions);
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }
        if (property_exists($data, 'programas')) {
            $area = count($data->getProgramas()) > 0 ? $data->getProgramas()[0]->getPrograma()->getIdarea() : null;
        } else {
            $area = $data->getPrograma() ? $data->getPrograma()->getPrograma()->getIdarea() : null;
        }
        $this->addAreaForm($form, $area);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $nombreCampo = 'area';
        if ($this->presupuesto) {
            $nombreCampo = 'idarea';
        }
        $area = array_key_exists($nombreCampo, $data) ? $data[$nombreCampo] : null;
        $this->addAreaForm($form, $area);
    }

}

<?php

namespace AppBundle\Form\EventListener\Programa;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AddAreaFieldSubscriber implements EventSubscriberInterface {

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
            "required" => false,
            "empty_value" => 'label.seleccion',
            'mapped' => true,
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

        $form->add('idarea', EntityType::class, $formOptions);
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }
        $area = $data->getPrograma() ? $data->getPrograma()->getIdarea() : null;
        $this->addAreaForm($form, $area);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $area = array_key_exists('idarea', $data) ? $data['idarea'] : null;
        $this->addAreaForm($form, $area);
    }

}

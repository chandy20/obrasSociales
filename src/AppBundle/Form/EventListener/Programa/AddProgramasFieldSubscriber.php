<?php

namespace AppBundle\Form\EventListener\Programa;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AddProgramasFieldSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }

    private function addProgramasForm($form, $area) {

        $formOptions = array(
            "class" => "AppBundle:Programas",
            "label" => "Programa padre",
            "empty_value" => 'label.seleccion',
            "required" => false,
            'mapped' => true,
            'query_builder' => function (EntityRepository $repository) use ($area) {
                $area = $area ?: 0;
                $qb = $repository->createQueryBuilder('p')
                        ->join('p.idarea', 'a')
                        ->where('a.idArea = :area')
                        ->andwhere('p.programa is null')
                        ->orderBy("p.programanombre", 'DESC')
                        ->setParameter('area', $area)
                ;
                return $qb;
            },
        );
        $form->add('programa', EntityType::class, $formOptions);
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }
        $area = $data->getPrograma() ? $data->getPrograma()->getIdarea() : null;
        if (!$area) {
            $area = $data->getIdarea();
        }
        $this->addProgramasForm($form, $area);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();
        if (null === $data) {
            return;
        }

        $area = array_key_exists('idarea', $data) ? $data['idarea'] : null;
        $this->addProgramasForm($form, $area);
    }

}

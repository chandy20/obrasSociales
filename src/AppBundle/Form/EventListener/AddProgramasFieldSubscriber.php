<?php

namespace AppBundle\Form\EventListener;

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

    private function addProgramasForm($form, $padre, $multiple) {

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
                        ->where('pp.id = :padre')
                        ->andwhere('p.idarea is null')
                        ->orderBy("pp.programanombre", 'DESC')
                        ->setParameter('padre', $padre)
                ;
                return $qb;
            },
        );
        if ($multiple) {
            $form->add('programas', EntityType::class, $formOptions);
        } else {
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
            $padre = count($data->getProgramas()) > 0 ? $data->getProgramas()[0]->getPrograma() : null;
        } else {
            $padre = $data->getPrograma() ? $data->getPrograma()->getPrograma() : null;
        }
        $this->addProgramasForm($form, $padre, property_exists($data, 'programas'));
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();
        if (null === $data) {
            return;
        }

        $padre = array_key_exists('programaPadre', $data) ? $data['programaPadre'] : null;
        $this->addProgramasForm($form, $padre, array_key_exists('programas', $data));
    }

}

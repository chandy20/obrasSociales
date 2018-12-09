<?php

namespace AppBundle\Form\EventListener;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AddProgramaPadreFieldSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }

    private function addProgramaPadreForm($form, $area, $padre) {

        $formOptions = array(
            "class" => "AppBundle:Programas",
            "label" => "label.programa",
            "empty_value" => 'label.seleccion',
            "required" => true,
            'mapped' => false,
            'attr' => [
                'onchange' => 'actualizarProgramas(this);',
            ],
            'query_builder' => function (EntityRepository $repository) use ($area) {
                $area = $area ?: 0;
                $qb = $repository->createQueryBuilder('p')
                        ->innerJoin('p.idarea', 'a')
                        ->where('a.idArea = :area')
                        ->orderBy("p.programanombre", 'DESC')
                        ->setParameter('area', $area)
                ;
                return $qb;
            },
        );

        if ($padre) {
            $formOptions['data'] = $padre;
        }
        $form->add('programaPadre', EntityType::class, $formOptions);
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $area = count($data->getProgramas()) > 0 ? $data->getProgramas()[0]->getPrograma()->getArea() : null;
        $padre = count($data->getProgramas()) > 0 ? $data->getProgramas()[0]->getPrograma() : null;
        $this->addProgramaPadreForm($form, $area, $padre);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $area = array_key_exists('area', $data) ? $data['area'] : null;
        $padre = array_key_exists('programaPadre', $data) ? $data['programaPadre'] : null;
        $this->addProgramaPadreForm($form, $area, $padre);
    }

}

<?php

namespace AppBundle\Form\EventListener;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AddProgramaPadreFieldSubscriber implements EventSubscriberInterface
{

    public $presupuesto = false;
    public $em = null;

    public function __construct($presupuesto = false,$em)
    {
        $this->presupuesto = $presupuesto;
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }

    private function addProgramaPadreForm($form, $area, $padre)
    {

        $formOptions = array(
            "class" => "AppBundle:Programas",
            "label" => "label.programa",
            "empty_value" => 'label.seleccion',
            "required" => true,
            'mapped' => false,
            'attr' => [
                'onchange' => 'actualizarProgramas(this);',
            ],
            'multiple' => true,
            'query_builder' => function (EntityRepository $repository) use ($area) {
                $area = $area ?: 0;
                $qb = $repository->createQueryBuilder('p')
                    ->innerJoin('p.idarea', 'a')
                    ->where('a.idArea IN (:area)')
                    ->andwhere('p.programa is null')
                    ->orderBy("p.programanombre", 'DESC')
                    ->setParameter('area', $area);
                return $qb;
            },
        );

        if ($padre) {
            $formOptions['data'] = $padre;
        }
        $form->add('programaPadre', EntityType::class, $formOptions);
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }
        if (property_exists($data, 'programas')) {
            $area = count($data->getProgramas()) > 0 ? $data->getProgramas()[0]->getPrograma()->getIdarea() : null;
            $padres = null;
            if (count($data->getProgramas()) > 0) {
                foreach ($data->getProgramas() as $padre) {
                    $padres[] = $this->em->getRepository('AppBundle:Programas')->find($padre->getPrograma()->getPrograma()->getId());
                }
            }
        } else {
            $area = $data->getPrograma() ? $data->getPrograma()->getPrograma()->getIdarea() : null;
            $padre = $data->getPrograma() ? $data->getPrograma()->getPrograma() : null;
        }
        $this->addProgramaPadreForm($form, $area, $padres);
    }

    public function preSubmit(FormEvent $event)
    {
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
        $padre = array_key_exists('programaPadre', $data) ? $data['programaPadre'] : null;
        $this->addProgramaPadreForm($form, $area, $padre);
    }

}

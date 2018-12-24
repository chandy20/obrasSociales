<?php

namespace AppBundle\Admin;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProgramaConceptoAdmin extends AbstractAdmin {

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('aprobado')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('id')
                ->add('aprobado')
                ->add('_action', null, [
                    'actions' => [
                        'show' => [],
                        'edit' => [],
                        'delete' => [],
                    ],
                ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $object = $this->getSubject();
        $data = null;
        if ($object->getPrograma()->getValorMes()) {
            $data = $object->getPrograma()->getValorMes();
        }
        $formMapper
                ->add('programa', EntityType::class, [
                    'class' => 'AppBundle:Programas',
                    'query_builder' => function (EntityRepository $er) use ($object) {
                        $qb = $er->createQueryBuilder('p');
                        $qb
                        ->where('p.programa = :programaPadre')
                        ->setParameter('programaPadre', $object->getPrograma()->getPrograma())
                        ;
                        return $qb;
                    },
                ])
                ->add('unidadesAprobadas', null, [
                    'label' => 'Unidades aprobadas',
                    'required' => true,
                    'attr' => [
                        'min' => 0
                    ],
                    'constraints' => [
                        new NotBlank(),
                        new GreaterThanOrEqual(0),
                    ]
                ])
                ->add('valorPrograma', null, [
                    'label' => 'Valor unidad',
                    'data' => $data,
                    'attr' => [
                        'readonly' => $data ? true : false,
                    ]
                ])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id')
                ->add('aprobado')
        ;
    }

}

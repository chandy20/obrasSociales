<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraints\NotBlank;

class PresupuestosAdmin extends AbstractAdmin {
    
    
    public function createQuery($context = 'list') {
        $query = parent::createQuery($context);
        $em = $this->getConfigurationPool()->getContainer()->get("doctrine")->getEntityManager();

        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($user->hasRole('ROLE_CONSULTOR')) {
            $query->where($query->getRootAliases()[0].".seccional = :seccional")
                    ->setParameter("seccional", $user->getSeccional());
        }
        return $query;
    }
    
    protected function configureRoutes(RouteCollection $collection) {
        $collection->remove('delete');
        $collection->remove('show');
        $collection->remove('edit');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('presupuestomonto', null, ["label" => "Monto"])
                ->add('seccional', null, ["lable" => "Seccional"])
                ->add('idarea', null, ["lable" => "Área"])
                ->add('saldo', null, ["label" => "Saldo"])
                ->add('desde', null, ["label" => "Desde"])
                ->add('hasta', null, ["label" => "Hasta"])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('presupuestomonto', null, ["label" => "Monto"])
                ->add('seccional', null, ["lable" => "Seccional"])
                ->add('idarea', null, ["lable" => "Área"])
                ->add('saldo', null, ["label" => "Saldo"])
                ->add('desde', null, ["label" => "Desde"])
                ->add('hasta', null, ["label" => "Hasta"])
                ->add('fechaCreacion', null, ["label" => "Fecha de creación"])
                ->add('_action', null, array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    ),
                ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper) {
        $constraint = array(new NotBlank());
        $formMapper
                ->add('presupuestomonto', null, ["label" => "Monto"])
                ->add('idarea', null, ["label" => "Área"])
                ->add('seccional', null, ["label" => "Seccional"])
                ->add('desde', DateType::class, array(
                    'widget' => 'single_text',
                    'constraints' => $constraint,
                    "label" => "Desde",
                    'format' => 'yyyy-MM-dd',
                    'empty_value' => "",
                    'attr' => array('class' => 'form-control')
                ))
                ->add('hasta', DateType::class, array(
                    'widget' => 'single_text',
                    'constraints' => $constraint,
                    "label" => "Hasta",
                    'format' => 'yyyy-MM-dd',
                    'empty_value' => "",
                    'attr' => array('class' => 'form-control')
        ));
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('presupuestomonto', null, ["label" => "label.monto"])
                ->add('saldo', null, ["label" => "label.saldo"])
                ->add('desde', null, ["label" => "label.desde"])
                ->add('hasta', null, ["label" => "label.hasta"])
                ->add('idarea', null, ["label" => "label.area"])
        ;
    }
    
    public function prePersist($object) {
        parent::prePersist($object);
        $hoy = new \DateTime();
        $object->setSaldo($object->getPresupuestomonto());
        $object->setFechaCreacion($hoy);
    }

}

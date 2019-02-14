<?php

namespace AppBundle\Admin;

use AppBundle\Form\EventListener\AddAreaFieldSubscriber;
use AppBundle\Form\EventListener\AddProgramaPadreFieldSubscriber;
use AppBundle\Form\EventListener\AddProgramasFieldSubscriber;
use DateTime;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\NotBlank;

class PresupuestosAdmin extends AbstractAdmin
{

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $em = $this->getConfigurationPool()->getContainer()->get("doctrine")->getEntityManager();

        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($user->hasRole('ROLE_CONSULTOR')) {
            $query->where($query->getRootAliases()[0] . ".seccional = :seccional")
                ->setParameter("seccional", $user->getSeccional());
        } else if ($user->hasRole('ROLE_LIDER')) {
            $query->where($query->getRootAliases()[0] . ".idarea = :area")
                ->setParameter("area", $user->getArea());
        }
        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
        $collection->remove('show');
        $collection->remove('edit');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('presupuestomonto', null, ["label" => "Monto"])
            ->add('seccional', null, ["label" => "Seccional"])
            ->add('idarea', null, ["label" => "Área"])
            ->add('saldo', null, ["label" => "Saldo"])
            ->add('desde', null, ["label" => "Desde"])
            ->add('hasta', null, ["label" => "Hasta"]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('presupuestomonto', null, ["label" => "Monto"])
            ->add('seccional', null, ["label" => "Seccional"])
            ->add('idarea', null, ["label" => "Área"])
            ->add('programa.programa', null, ["label" => "Programa"])
            ->add('programa', null, ["label" => "Modalidad"])
            ->add('saldo', null, ["label" => "Saldo"])
            ->add('desde', null, ["label" => "Desde"])
            ->add('hasta', null, ["label" => "Hasta"])
            ->add('fechaCreacion', null, ["label" => "Fecha de creación"]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $constraint = array(new NotBlank());
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $formMapper
            ->add('presupuestomonto', null, ["label" => "Monto"])
            ->add('idarea', EntityType::class, [
                "class" => "AppBundle:Areas"
            ])
            ->add('programaPadre', EntityType::class, [
                "class" => "AppBundle:Programas"
            ])
            ->add('programa', null, ["label" => "Modalidad"])
            ->add('seccional', null, ["label" => "Seccional"])
            ->add('desde', DatePickerType::class, array(
                'constraints' => $constraint,
                "label" => "Desde",
                'format' => 'yyyy-MM-dd',
            ))
            ->add('hasta', DatePickerType::class, array(
                'constraints' => $constraint,
                "label" => "Hasta",
                'format' => 'yyyy-MM-dd',
                'attr' => array('class' => 'form-control')
            ))
            ->getFormBuilder()
            ->addEventSubscriber(new AddAreaFieldSubscriber(true))
            ->addEventSubscriber(new AddProgramaPadreFieldSubscriber(true, $em))
            ->addEventSubscriber(new AddProgramasFieldSubscriber(true));
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('presupuestomonto', null, ["label" => "label.monto"])
            ->add('saldo', null, ["label" => "label.saldo"])
            ->add('desde', null, ["label" => "label.desde"])
            ->add('hasta', null, ["label" => "label.hasta"])
            ->add('idarea', null, ["label" => "label.area"]);
    }

    public function prePersist($object)
    {
        parent::prePersist($object);
        $hoy = new DateTime();
        $object->setSaldo($object->getPresupuestomonto());
        $object->setFechaCreacion($hoy);
    }

}

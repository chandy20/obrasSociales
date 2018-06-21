<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UserAdmin extends AbstractAdmin {

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('username')
                ->add('email')
                ->add('enabled')
                ->add('roles')
                ->add('firstname')
                ->add('lastname')
                ->add('seccional')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('username')
                ->add('email')
                ->add('enabled')
                ->add('roles')
                ->add('firstname')
                ->add('lastname')
                ->add('seccional')
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
        $formMapper
                ->add('username')
                ->add('email')
                ->add('enabled')
                ->add('roles')
                ->add('firstname')
                ->add('lastname')
                ->add('seccional')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('username')
                ->add('email')
                ->add('enabled')
                ->add('roles')
                ->add('firstname')
                ->add('lastname')
                ->add('seccional')
        ;
    }

}

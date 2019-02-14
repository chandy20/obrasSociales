<?php

namespace AppBundle\Admin;

use FOS\UserBundle\Model\UserManagerInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use AppBundle\Form\StringToArrayTransformer;

class UserAdmin extends \Sonata\UserBundle\Admin\Entity\UserAdmin
{
    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * {@inheritdoc}
     */
    public function getFormBuilder()
    {
        $this->formOptions['data_class'] = $this->getClass();

        $options = $this->formOptions;
        $options['validation_groups'] = (!$this->getSubject() || is_null($this->getSubject()->getId())) ? 'Registration' : 'Profile';

        $formBuilder = $this->getFormContractor()->getFormBuilder($this->getUniqid(), $options);

        $this->defineFormBuilder($formBuilder);

        return $formBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getExportFields()
    {
        // avoid security field to be exported
        return array_filter(parent::getExportFields(), function ($v) {
            return !in_array($v, ['password', 'salt']);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($user)
    {
        $this->getUserManager()->updateCanonicalFields($user);
        $this->getUserManager()->updatePassword($user);
    }

    /**
     * @param UserManagerInterface $userManager
     */
    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @return UserManagerInterface
     */
    public function getUserManager()
    {
        return $this->userManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
            ->add('enabled', null, ['editable' => true])
            ->add('createdAt');

    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('id')
            ->add('username')
            ->add('locked')
            ->add('email');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General')
            ->add('username')
            ->add('email')
            ->end()
            ->with('Groups')
            ->add('groups')
            ->end()
            ->with('Profile')
            ->add('dateOfBirth')
            ->add('firstname')
            ->add('lastname')
            ->add('website')
            ->add('biography')
            ->add('gender')
            ->add('locale')
            ->add('timezone')
            ->add('phone')
            ->end()
            ->with('Social')
            ->add('facebookUid')
            ->add('facebookName')
            ->add('twitterUid')
            ->add('twitterName')
            ->add('gplusUid')
            ->add('gplusName')
            ->end()
            ->with('Security')
            ->add('token')
            ->add('twoStepVerificationCode')
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $transformer = new StringToArrayTransformer();
        $choices = array();
        $admin = $this->getConfigurationPool()->getContainer()->get("security.authorization_checker")->isGranted("ROLE_SUPER_ADMIN");
        foreach ($this->getConfigurationPool()->getContainer()->getParameter('security.role_hierarchy.roles') as $rol) {
            if(is_array($rol) && array_key_exists('0', $rol)){
                foreach ($rol as $r){
                    if ($admin &&  $r != "ROLE_SONATA_ADMIN" && $r != "ROLE_ADMIN") {
                        $choices[$r] = $r;
                    }
                }
                $choices['ROLE_SUPER_ADMIN'] = 'ROLE_SUPER_ADMIN';

            }
        }

        $formMapper
            ->add('firstname', null, ['required' => false])
            ->add('lastname', null, ['required' => false])
            ->add('username')
            ->add('email')
            ->add('seccional', null, ['label' => 'Seccional'])
            ->add('area', null, ['label'=> 'Area'])
            ->add('plainPassword', 'text', [
                'required' => (!$this->getSubject() || is_null($this->getSubject()->getId())),
            ])
            ->add('phone', null, ['required' => false])
            ->add('enabled', null, ['required' => false]);
        $formMapper->add($formMapper->create('roles', 'choice', array(
            'label' => "label.roles",
            'mapped' => true,
            'expanded' => false,
            'multiple' => false,
            'choices' => $choices
        ))->addModelTransformer($transformer));
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'ApplicationSonataUserBundle:Usuarios:base_edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
        }
    }
}

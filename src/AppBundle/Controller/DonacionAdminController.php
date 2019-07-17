<?php

namespace AppBundle\Controller;

use AppBundle\Form\FormularioValidarDonacionType;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Bridge\Twig\AppVariable;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bundle\TwigBundle\Command\DebugCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\FormView;

class DonacionAdminController extends CRUDController
{

    protected $em;
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->em = $container->get("doctrine")->getManager();
        $this->container = $container;
    }

    private function setFormTheme(FormView $formView, $theme)
    {
        $twig = $this->get('twig');

        // BC for Symfony < 3.2 where this runtime does not exists
        if (!method_exists(AppVariable::class, 'getToken')) {
            $twig->getExtension(FormExtension::class)->renderer->setTheme($formView, $theme);

            return;
        }

        // BC for Symfony < 3.4 where runtime should be TwigRenderer
        if (!method_exists(DebugCommand::class, 'getLoaderPaths')) {
            $twig->getRuntime(TwigRenderer::class)->setTheme($formView, $theme);

            return;
        }

        $twig->getRuntime(FormRenderer::class)->setTheme($formView, $theme);
    }
    public function downloadPDFAction($id){

    }

    public function validateAction($id){
        {
            $donacion = $this->em->getRepository("AppBundle:Donacion")->findOneById($id);
            $form = $this->createForm(new FormularioValidarDonacionType(), $donacion, []);
            $form->handleRequest($this->getRequest());
            return $this->renderWithExtraParams("AppBundle:Donate:base_donate.html.twig", [
                'action' => 'edit',
                'form' => $form->createView(),
                'object' => $donacion
            ], null);
        }
    }
}

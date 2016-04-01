<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Uecode\Bundle\QPushBundle\Provider\ProviderInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @Route("/publish-message", name="publish_message")
     */
    public function publishMessage()
    {
        $message = ['userId' => rand(1, 999), 'emailType' => 'welcome_email'];

        $this->getQueue()->publish($message);

        $this->addFlash('success', 'Published Message: ' . json_encode($message));

        return $this->redirectToRoute('homepage');
    }

    /**
     * @return ProviderInterface
     */
    private function getQueue(): ProviderInterface
    {
        return $this->get('uecode_qpush.my_queue');
    }
}

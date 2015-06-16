<?php

namespace Europa\SandboxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($name, Request $request)
    {
        $_session = $request->getSession();
        $previousName = $_session->get('previousName', 'Non renseigné');
        $_session->set('previousName', $name);
        
        $response = new \Symfony\Component\HttpFoundation\Response();
        
        if($name === 'toto') {
            
            $_session->getFlashBag()->add('notice', 'Toto invalide');
            return $this->redirect($this->generateUrl('europa_sandbox_homepage', array('name' => 'tatayoyo', 'previousName' => $previousName)));

        }
        
        $headers = $response->headers;        
        $headers->set('Content-Type', 'text/html');
        $response->setContent(
          $this->renderView('EuropaSandboxBundle:Default:index.html.twig', 
          array('name' => $name, 'previousName' => $previousName)
          ));
        
        $response->setStatusCode(200);
        
        
        return $response;
        /*
        return  $this->render('EuropaSandboxBundle:Default:index.html.twig', 
                array('name' => $name, 'previousName' => $previousName, )); */
    }
    
    public function testAction($notif)
    {
        usleep(2000000);
        return  $this->render('EuropaSandboxBundle:Default:test.html.twig', 
                array('notif' => $notif));
    }
}

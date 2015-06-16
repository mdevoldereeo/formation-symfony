<?php

namespace Europa\BlogBundle\Controller;

use DateTime; 
use Europa\BlogBundle\Entity\Post; 
use Europa\BlogBundle\Entity\Author; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template; 
use Symfony\Bundle\FrameworkBundle\Controller\Controller; 
use Symfony\Component\HttpFoundation\Response; 

/**
 * Class PostController
 * @package Europa/BlogBundle/Controller
 * 
 * @Route("/blog")
 */
class PostController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
       /*$post = (new Author())
                    ->setLastname('DEVOLDERE')
                    ->setFirstname('Mike');
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($post);
        $em->flush();*/
        
        return new Response('NaN', Response::HTTP_CREATED);
    }
    
    /**
     * @Route("/add")
     * @Template()
     */
    public function addAction()
    {
        $post = (new Post())
                    ->setTitle('Titre')
                    ->setBody('Texte<br/>texte2')
                    ->setPublishedate(new DateTime());
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($post);
        $em->flush();
        
        return new Response('Post:add:OK', Response::HTTP_CREATED);
        
    }
    
    /**
     * @Route("/{id}", requirements={"id":"\d+"})
     * @Template()
     * 
     * @param integer $id
     * @return array
     */
    public function showAction($id)
    {
        $pr = $this->getDoctrine()->getRepository('EuropaBlogBundle:Post');
        
        $post = $pr->find($id);
        
        if(!$post) {
            throw $this->createNotFoundException('Post '.$id.' not found');
        }

        return array('post' => $post);
    }
    
    /**
     * @Route("/{id}", requirements={"id":"\d+"})
     * @Template()
     * @ParamConverter("post", class="EuropaBlogBundle:Post")
     * 
     * @param Post $post
     * @return array
     */ /*
    public function showAction(Post $post)
    {
        return array('post' => $post);
    } */
    
    
    /**
     * @Route("/title/{title}")
     * @Template("EuropaBlogBundle:post:show.html.twig")
     * 
     * @param string $title
     * @return array
     */ 
    public function showByTitleAction($title)
    {
        $pr = $this->getDoctrine()->getRepository('EuropaBlogBundle:Post');
        
        $post = $pr->findOneBy(array('title' => $title));
        
        if(!$post) {
            throw $this->createNotFoundException('Post '.$title.' not found');
        }
        
        return array('post' => $post);
    }
    
    /**
     * @Route("/{year}/{month}", requirements={ "year":"\d{4}", "month":"\d{2}" })
     * @Template("EuropaBlogBundle:post:index.html.twig")
     * 
     * @param integer $year
     * @param integer $month
     * @return array
     */ 
    public function showByMonthAction($month, $year)
    {
        $pr = $this->getDoctrine()->getRepository('EuropaBlogBundle:Post');
        
        $posts = $pr->findByMonth($month, $year);
        
        return array('posts' => $posts);
    }
    
    /**
     * @Route("/search/{needle}")
     * @Template("EuropaBlogBundle:post:index.html.twig")
     * 
     * @param string $needle
     * @return array
     */ 
    public function showByKeyword($needle)
    {
        $pr = $this->getDoctrine()->getRepository('EuropaBlogBundle:Post');
        
        $posts = $pr->findByKeyword($needle);
        
        return array('posts' => $posts);
    }

    
    
}

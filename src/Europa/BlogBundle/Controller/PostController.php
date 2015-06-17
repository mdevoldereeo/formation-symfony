<?php

namespace Europa\BlogBundle\Controller;

use Europa\BlogBundle\Entity\Post;
use Europa\BlogBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
     * @Template("EuropaBlogBundle:post:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $pr = $this->getDoctrine()->getRepository('EuropaBlogBundle:Post');
        
        $posts = $pr->listPosts();
        
        return array('posts' => $posts, 'loc' => $request->getLocale());
    }
    
    /**
     * @Route("/add")
     * @Template()
     * @return Response 
     */
    public function addAction(Request $request)
    {
        $post = new Post();

        $form = $this->createForm
        (
          new PostType(), 
          $post, 
          array('validation_groups' => array('publising', 'Default'))
        );
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            $this->addFlash('user_notice', 'Publication ajoutée');
            
            return $this->redirectToRoute('europa_blog_post_show', array('id' => $post->getId()));
        }
        
        return array('postForm' => $form->createView());
    }
    
    /**
     * @Route("/addnodate")
     * @Template()
     */
    public function addNoDateAction()
    {
        $pr = $this->getDoctrine()->getRepository('EuropaBlogBundle:Author');
        
        $author = $pr->find('2');
        
        
        $post = (new Post())
                    ->setTitle('Europa Test')
                    ->setBody('Read the f***ing manual !!!')
                    ->setAuthor($author);
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($post);
        $em->flush();
        
        return new Response('Post:addNoDate:OK', Response::HTTP_CREATED);
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
    public function showByMonthAction($month, $year, Request $request)
    {
        $pr = $this->getDoctrine()->getRepository('EuropaBlogBundle:Post');
        
        $posts = $pr->findByMonth($month, $year);
        
        return array('posts' => $posts, 'loc' => $request->getLocale());
    }
    
    /**
     * @Route("/search/{needle}")
     * @Template("EuropaBlogBundle:post:index.html.twig")
     * 
     * @param string $needle
     * @return array
     */ 
    public function showByKeyword($needle, Request $request)
    {
        $pr = $this->getDoctrine()->getRepository('EuropaBlogBundle:Post');
        
        $posts = $pr->findByKeyword($needle);
        
        return array('posts' => $posts, 'loc' => $request->getLocale());
    }

    
    
}

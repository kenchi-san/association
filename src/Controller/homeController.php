<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 19/12/2018
 * Time: 01:38
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class homeController extends AbstractController
{
    /**
     * @Route("/",name="homepage")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('pages/index.html.twig');
    }

    /**
     * @Route("about", name="team")
     * @return Response
     */
    public function about(): Response
    {
        return $this->render('pages/about.html.twig');
    }

    /**
     * @Route("post", name="post")
     * @return Response
     */
    public function post(): Response
    {
        return $this->render('pages/blog-post.html.twig');
    }

    /**
     * @Route("event", name="event")
     * @return Response
     */
    public function Event(): Response
    {
        return $this->render('pages/Event.html.twig');
    }

    /**
     * @Route("dash", name="dash")
     * @return Response
     */
    public function test(): Response
    {
    return $this->render('backend/test.html.twig');
    }
}
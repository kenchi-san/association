<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 19/12/2018
 * Time: 01:38
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class homeController extends AbstractController
{
    /**
     * @Route("/",name="homepage")
     * @return Response
     */
    public function index():Response{
    return $this->render('pages/index.html.twig');
}

    /**
     * @Route("about", name="team")
     * @return Response
     */
public function about():Response{
        return $this->render('pages/about.html.twig');
}

    /**
     * @Route("post", name="post")
     * @return Response
     */
public function post():Response{
    return $this->render('pages/blog-post.html.twig');
}
}
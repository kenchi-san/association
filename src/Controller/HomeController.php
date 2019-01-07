<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 19/12/2018
 * Time: 01:38
 */

namespace App\Controller;


use App\Repository\ActionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @var ActionRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(ActionRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/",name="homepage")
     * @return Response
     */
    public function index()
    {
        $actions = $this->repository->findAll();
        return $this->render('pages/index.html.twig',compact('actions'));
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
     * @Route("post/{id}", name="post")
     * @param $id
     * @return Response
     */
    public function post($id)
    {
        $actions = $this->repository->find($id);
        return $this->render('pages/blog-post.html.twig',compact('actions'));
    }

    /**
     * @Route("event", name="event")
     * @return Response
     */
    public function Event(): Response
    {
        return $this->render('pages/Event.html.twig');
    }

}
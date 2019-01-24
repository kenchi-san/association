<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 22/01/2019
 * Time: 16:24
 */

namespace App\Controller;


use App\Entity\Multimedia;
use App\Form\MultimediaType;
use App\Repository\MultimediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminMultimediaController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var MultimediaRepository
     */
    private $multimediaRepository;

    /**
     * AdminMultimediaController constructor.
     * @param EntityManagerInterface $manager
     * @param MultimediaRepository $multimediaRepository
     */
    public function __construct(EntityManagerInterface $manager, MultimediaRepository $multimediaRepository)
    {

        $this->manager = $manager;
        $this->multimediaRepository = $multimediaRepository;
    }

    /**
     * @Route("/movie/list",name="admin_movies_list")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return
     */
    public function videoList(PaginatorInterface $paginator, Request $request){
        $videos = $paginator->paginate(
            $this->multimediaRepository->OrderByEsc(),
            $request->query->getInt('page', 1),
            5);
        return $this->render('Admin/multimedia_list.html.twig', compact('videos'));
    }

    /**
     * @Route("/movie/add",name="admin_movies_add")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function videoAdd(Request $request, EntityManagerInterface $manager)
    {    $video = new Multimedia();
        $form = $this->createForm(MultimediaType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $manager->persist($video);
            $manager->flush();

            return $this->redirectToRoute('admin_movies_list');
        }

        return $this->render('Admin/multimedia_add.html.twig', ['form' => $form->createView()]);


    }
}
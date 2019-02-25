<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 21/02/2019
 * Time: 15:37
 */

namespace App\Controller;


use App\Entity\IntroductionSchool;
use App\Form\IntroductionSchoolType;
use App\Repository\IntroductionSchoolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class AdminIntroductionSchoolController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var IntroductionSchoolRepository
     */
    private $repository;


    /**
     * AdminActionController constructor.
     * @param EntityManagerInterface $manager
     * @param IntroductionSchoolRepository $repository
     */
    public function __construct( EntityManagerInterface $manager, IntroductionSchoolRepository $repository)
    {


        $this->manager = $manager;
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/introduction_school",name="admin_introSchool")
     * @return mixed
     */
    public function introductionshow()
    {
        $Introduction=$this->repository->findAll();
        return $this->render('Admin/introductionSchool_list.html.twig',compact('Introduction'));
    }

    /**
     * @Route("/admin/introduction/delete/{id}", name="admin_introduction_delete", methods="DELETE")
     * @param IntroductionSchool $introductionSchool
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function introductionDelete(IntroductionSchool $introductionSchool)
    {

        $this->manager->remove($introductionSchool);
        $this->manager->flush();
        return $this->redirectToRoute('admin_introSchool');

    }

    /**
     * @param Request $request
     * @param IntroductionSchool $introductionSchool
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/admin/introduction/{id}/edit", name="admin_introduction_edit", methods="GET|POST")
     */
    public function introductionEdit(Request $request, IntroductionSchool $introductionSchool)
    {
        $form = $this->createForm(IntroductionSchoolType::class, $introductionSchool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();

            return $this->redirectToRoute('admin_introSchool');
        }

        return $this->render('Admin/introductionSchool_edit.html.twig', [
            'introduction' => $introductionSchool,
            'form' => $form->createView()
        ]);


    }

    /**
     * @Route("admin/introduction/add", name="admin_introduction_add")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function introductionAdd(Request $request, EntityManagerInterface $manager)
    {
        $intro = new IntroductionSchool();
        $form = $this->createForm(IntroductionSchoolType::class, $intro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $manager->persist($intro);
            $manager->flush();

            return $this->redirectToRoute('admin_introSchool');
        }

        return $this->render('Admin/introductionSchool_add.html.twig', ['form' => $form->createView()]);


    }

}
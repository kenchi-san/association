<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 13/01/2019
 * Time: 20:13
 */

namespace App\Controller;


use App\Entity\Galery;
use App\Form\GaleryType;
use App\Repository\GaleryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminGaleryController extends AbstractController
{
    /**
     * @var GaleryRepository
     */
    private $galeryRepository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;


    public function __construct(GaleryRepository $galeryRepository, EntityManagerInterface $manager)
    {
        $this->galeryRepository = $galeryRepository;

        $this->manager = $manager;
    }

    /**
     * @Route("/galery/list",name="admin_galeries_list")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
public function galeryList(PaginatorInterface $paginator, Request $request){
    $galeries = $paginator->paginate(
        $this->galeryRepository->OrderByEsc(),
        $request->query->getInt('page', 1),
        5);

    return $this->render('Admin/galery_list.html.twig',compact('galeries'));
}


    /**
     * @Route("/galery/add",name="admin_galery_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function eventAdd(Request $request)
    {
        $galery = new Galery();
        $form = $this->createForm(GaleryType::class, $galery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $this->manager->persist($galery);
            $this->manager->flush();

            return $this->redirectToRoute('admin_galeries_list');
        }

        return $this->render('Admin/galery_add.html.twig', ['form' => $form->createView()]);


    }

    /**
     * @Route("/galery/delete/{id}",name="admin_galery_delete")
     * @param Galery $galery
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function actionDelete(Galery $galery)
    {

        $this->manager->remove($galery);
        $this->manager->flush();
        return $this->redirectToRoute('admin_galeries_list');

    }

    /**
     * @Route("/galery/edit/{id}",name="admin_galery_edit")
     * @param Request $request
     * @param Galery $galery
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function actionEdit(Request $request, Galery $galery)
    {
        $form = $this->createForm(GaleryType::class, $galery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->manager->flush();

            return $this->redirectToRoute('admin_galeries_list');
        }

        return $this->render('Admin/galery_edit.html.twig', [
            'galery' => $galery,
            'form' => $form->createView()
        ]);

    }
}
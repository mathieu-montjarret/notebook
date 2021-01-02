<?php

namespace App\Controller;

use App\Form\EditprofileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
   /**
     * @Route("/admin/informations", name="admin-informations")
     */
    public function index(): Response
    {
        return $this->render('admin/informations.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

     /**
    * @Route("/admin/edit-profile", name="admin-edit-profile") 
    */
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditprofileType::class, $user); 

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager(); 
            $em->persist($user); 
            $em->flush(); 

            $this->addFlash('message', 'Profil mis à jour');

            return $this->redirectToRoute('admin-informations');
        }

    
        return $this->render('admin/edit-informations.html.twig', [ 'form' => $form->createView()]);
        
    }
    
}

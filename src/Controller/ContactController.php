<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Form\EditContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ContactController extends AbstractController
{
    /**
    * @Route("admin/inscription-contact", name="contact-registration") 
    */
    public function registrationContact(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {
        
        $contact = new Contact();
       
        $form = $this->createForm(ContactType::class, $contact); 

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) 
        {
            $user = $this->getUser();
            $contact->setUserLink($user);
            $hash = $encoder->encodePassword($contact, $contact->getPassword());
            $contact->setPassword($hash);
            $contact->setRoles(["ROLE_USER"]);
            $manager->persist($contact); 
            $manager->flush(); 

            return $this->redirectToRoute('contact-list');
        }

    
        return $this->render('contact/contact-registration.html.twig', [
             'form' => $form->createView(),
             'editContact' => $contact->getId()
             ]);
        
    }

    /**
    * @Route("admin/affichage-contact", name="contact-list") 
    */
    public function showContact(): Response
    {        
        return $this->render('contact/contact-informations.html.twig');
    }

    /**
     * @Route("/admin/{id}/edit-contact", name="contact-edit")
     */
    public function editContact(Contact $contact, Request $request, EntityManagerInterface $manager): Response
    {

        $formContact = $this->createForm(EditContactType::class, $contact);

        $formContact->handleRequest($request);

        if($formContact->isSubmitted() && $formContact->isValid()){

            $manager->persist($contact);
            $manager->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");


            return $this->redirectToRoute('contact-list');
        }


        return $this->render('contact/contact-edit.html.twig', [
            'formContact' => $formContact->createView(),
        ]);   
    }



    /**
     * @Route("/admin/{id}/delete_contact", name="contact-delete")
     */
    public function deleteArticle(Contact $contact, EntityManagerInterface $manager)
    {
        $manager->remove($contact);
        $manager->flush();

        $this->addFlash('success', "Le contact a bien été supprimé");

        return $this->redirectToRoute('contact-list');
    }
}

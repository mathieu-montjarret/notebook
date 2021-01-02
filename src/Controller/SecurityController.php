<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SecurityController extends AbstractController
{
    /**
    * @Route("inscription", name="admin-registration") 
    */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User(); 
        $form = $this->createForm(RegistrationType::class, $user); 

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) 
        {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setRoles(["ROLE_ADMIN"]);
            $manager->persist($user); 
            $manager->flush(); 

            return $this->redirectToRoute('login');
        }

    
        return $this->render('security/admin-registration.html.twig', [ 'form' => $form->createView()]);
        
    }

    /**
    * @Route("/", name="login") */
    public function login(AuthenticationUtils $authenticationUtils, AuthorizationCheckerInterface $authChecker)
    {

        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute("admin-informations");
        }

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error


        ]);
    }

    /**
    * @Route("\deconnexion", name="logout") 
    */
    public function logout(){}
}
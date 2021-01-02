<?php

namespace App\Controller;

use App\Form\EditprofileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class NotebookController extends AbstractController
{
    
 /**
* @Route("/homepage", name="homepage") 
*/
public function homepage()
    {
        return $this->render('notebook/homepage.html.twig');
    }

}

<?php

namespace App\Controller;


use App\Entity\Nomade;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class NomadeLoginController extends AbstractController
{
    /**
     * @Route("/login-locataire", name="login_nomade")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {


        if ($this->getUser()) {
            $role = $this->getUser()->getRoles();
            if ($role[0] == "ROLE_PROPRIO"){
                return $this->redirectToRoute('proprio_home');
            }elseif ($role[0] == "ROLE_USER"){
//                $id = $this->getDoctrine()->getRepository()->find($id);
                return $this->redirectToRoute('nomade_home' );
            }
        }



        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();



        return $this->render('nomade/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}

<?php

namespace App\Controller;

use App\Entity\Nomade;
use App\Form\NomadeType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/locataire", name="nomade_")
 *
 */

class NomadeController extends AbstractController
{

    /**
     * @Route("/", name="presentation")
     *
     */

    public function presentationLoc(){

        return $this->render('nomade/presentation.html.twig');
    }


    /**
     * @Route("/accueil", name="home")
     * @IsGranted("ROLE_USER")
     *
     */

    public function espace(){

        return $this->render('nomade/espace.html.twig');
    }

    /**
     * @Route("/profile", name="profile")
     * @IsGranted("ROLE_USER")
     *
     */

    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // Récupération de l'utilisateur courant
        $nomade = $this->getUser();
        // Passage de l'utilisateur au formulaire pour pré-remplir les champs
        $nomadeForm = $this->createForm(NomadeType::class, $nomade);

        $nomadeForm->handleRequest($request);

        // Vérification de validité
        if ($nomadeForm->isSubmitted() && $nomadeForm->isValid()) {
            // Formulaire lié à une classe entité: getData() retourne l'entité
            $nomade = $nomadeForm->getData();

            // Mise à jour de l'entité en BDD

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nomade);
            $entityManager->flush();


            // Ajout d'un message flash
            $this->addFlash('success', 'Votre profil a été mis à jour.');



        }else if ($nomadeForm->isSubmitted()) {
            $this->addFlash('danger', 'Echec de mise à jour.');
        }

        return $this->render('nomade/nomade.html.twig', [
            'nomadeForm' => $nomadeForm->createView()
        ]);
    }

}


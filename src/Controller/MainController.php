<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Entity\Paniers; 
use App\Form\ProduitsType;
use App\Form\PanierType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{

    /**
     * @Route("/produits", name="produits")
     */
    public function produits(EntityManagerInterface $entityManager, Request $request)
    {

        $produit = new Produits();



        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $produit = $form->getData();

            $photo = $form->get('photo')->getData();
            $photoName = md5(uniqid()).'.'.$photo->guessExtension();
            $photo->move($this->getParameter('upload_files') ,
            $photoName);
            $produit ->setPhoto($photoName);


            $entityManager->persist($produit);
            $entityManager->flush();

           return $this->redirectToRoute('produits');
        }

        $produitsRepository = $this->getDoctrine()
        ->getRepository(Produits::class)
        ->findAll();

        return $this->render('main/produits.html.twig',[
            'produits' =>$produitsRepository,
            'addProduits' => $form->createView(),
        ]);
    }

        /**
     * @Route("/produits/ficheProduits/{id}", name="showProduit")
     */
    public function showProduit($id, Request $request, EntityManagerInterface $entityManager)
    {   
        $produitSpecial = $this->getDoctrine()
                                ->getRepository(Produits::class)
                                ->find($id);

        $paniers = new Paniers();
        
        $formulaire = $this->createForm(PanierType::class, $paniers);
        $formulaire->handleRequest($request);

        if($formulaire->isSubmitted() && $formulaire->isValid()){
            $paniers = $formulaire->getData();
            $paniers->setDateAjout(new\DateTime()) ;
            $paniers->setEtat(false);
            $paniers->setProduit($produitSpecial);

            $entityManager->persist($paniers);
            $entityManager->flush();

            
        }

        $panierRepository = $this->getDoctrine()
        ->getRepository(Paniers::class)
        ->findAll();

        return $this->render('main/ficheProduit.html.twig', [
            'produit' => $produitSpecial,
            'paniers' => $panierRepository,
            'addPanier' =>$formulaire->createView()
        ]);
    }


    /**
     * @Route("/produits/delete/{id}", name="deleteProduit")
     */
    public function deleteProduit($id, EntityManagerInterface $entityManager){
        $produit = $this->getDoctrine()->getRepository(Produits::class)->find($id);

        $entityManager->remove($produit);
        $entityManager->flush();

        return $this->redirectToRoute('produits');
    }
    
    /**
     * @Route("/", name="panier")
     */
    public function paniers()
    {
        return $this->render('main/panier.html.twig', [


        ]);
    }


}

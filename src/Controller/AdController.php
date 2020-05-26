<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AdController extends Controller
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)
    {        
        //$repo = $this->getDoctrine()->getRepository(Ad::class);

        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [ 
            'ads' => $ads,
        ]);
    }

     /**
     * Permet de créer une annonce
     * 
     * @Route("/ads/new", name="ads_create")
     * 
     * @return Response 
     */
    public function create(Request $request, EntityManagerInterface $manager){  //récupére les informations saisi dans le formulaire
        //Note  attention sur symphonie 4 s'appel ObjectManager et non EntityManagerInterface
       
        $ad = new Ad(); // Pour dire que c'est une création



        $image = new Image();

        $image->setUrl('http://placehold.it/400x200')
              ->setCaption('Titre 1');
        
        $image2 = new Image();

        $image2->setUrl('http://placehold.it/400x22222')
               ->setCaption('Titre 2');

        $ad->addImage($image)
           ->addImage($image2);



        $form = $this->createForm(AdType::class, $ad); // raccourcie vers les champs du formulaire (page AdType.php)
        
        $form->handleRequest($request); //récupére toutes les infos des formulaire 

        // Enregistrement de la série d'image supplementaire 
        if($form->isSubmitted() && $form->isValid()){ // Vérifie si le formulaire est bien remplis
            foreach($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }

            $manager->persist($ad);
            $manager->flush(); 

            // message à l'utilisateur que le formulaire c'est bien ou pas bien passé
                $this->addFlash(
                    'success',
                    "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !"
                );

            //redirection sur la page qui viens d'être enregistré
            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug() // donner l'adresse de l'enregistrement
            ]);
        }

        return $this->render('ad/new.html.twig', [
            'form' => $form->createView() // afficher le formulaire créer ci dessus
        ]);
    }

    /**
     * Permet d'afficher une seule annonce
     * 
     * @Route("/ads/{slug}", name="ads_show")
     * 
     * @return Response
     */

     public function show(Ad $ad){
         // Je récupére l'annonce qui correspnd au slug !
        return $this->render('ad/show.html.twig', [
                'ad' => $ad
            ]);
     }


}

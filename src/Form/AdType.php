<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends AbstractType
{

    /**
     * Permet d'avoir la configuration de base d'un champ !
     * 
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    private function getConfiguration($label, $placeholder) {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 
            TextType::class, 
            $this->getConfiguration("Titre", "Tapez un super titre pour votre annonce")
            )

            ->add('slug', 
            TextType::class, 
            $this->getConfiguration("Adresse web", "Tapez l'adresse web (automatique)")
            )

            ->add('introduction', 
            TextType::class, 
            $this->getConfiguration("Introduction", "Donnez une description globale de l'annonce")
            )

            ->add('content', 
            TextareaType::class, 
            $this->getConfiguration("Description détaillée", "Tapez une description qui donne vraiement envie de venir chez vous !")
            )

            ->add('coverImage', 
            UrlType::class, 
            $this->getConfiguration("URL de l'image", "Donnez l'adresse d'une image qui donne vraiement envie")
            )

            ->add('rooms', 
            IntegerType::class, 
            $this->getConfiguration("Nombre de chambre", "Le nombre de chambres disponibles")
            )

            ->add(
                'price', 
                MoneyType::class, 
                $this->getConfiguration("Prix par nuit", "Indiquez le prix que vous voulez pour la nuit")
            )
            
            ->add(
                'images',
                CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'allow_add' => true // rajoute le champs data-prototype dans une <idv>
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}

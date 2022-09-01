<?php

namespace App\Form;

use App\Entity\Dishes;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
			->add('Immagine', FileType::class, ['mapped'=>false, 'required'=>false])
            ->add('description')
			->add('category', EntityType::class, [
				'class'=>Category::class
			])
            ->add('price')
			->add('Salva', SubmitType::class)
        ;
		//evento dopo post ma prima di injection in entity
		//$builder->get('Immagine')->addEventListener(FormEvents::POST_SUBMIT, static function (FormEvent $event) {          
            //$img = $event->getForm()->getData();
            //dd($img);
			//$dish = $event->getForm()->getParent()->getData();
        //});
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dishes::class,
        ]);
    }
}

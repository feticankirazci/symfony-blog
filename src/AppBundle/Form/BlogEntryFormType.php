<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogEntryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('excerpt')
            ->add('title')
            ->add('body')
            ->add('status', ChoiceType::class,[
                'choices' => [
                    'Active' => true,
                    'Passive' => false,
                ]
            ])
            ->add('createdAt')
            ->add('updatedAt')
            ->add('blogCategories', EntityType::class, [
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Blog'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_blog_entry_form_type';
    }
}

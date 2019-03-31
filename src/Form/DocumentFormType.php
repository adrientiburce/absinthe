<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\LabelDocument;
use App\Entity\CourseDocument;
use App\Repository\CourseRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class DocumentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('course', EntityType::class, [
                'class' => Course::class,
                'label' => 'Cours',
                'choice_label' => 'name',
                'query_builder' => function (CourseRepository $repo) {
                    return $repo->findCoursesWithCategory();
                    },
                'group_by' => function(Course $choiceValue) {
                    return $choiceValue->getCourseCategory();
                },
                'required' => true,
            ])
            ->add('document', FileType::class, [
                'label' => 'Document',
                'help' => 'Veuillez sélectionner un PDF ou Word de moins de 5 Mo',
                'required' => true,
                'attr' => array('class' => 'file-upload-name'),
            ])
            ->add('label',EntityType::class, [
                'class' => LabelDocument::class,
                'choice_label' => 'name',
                'label' => 'Label',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseDocument::class,
        ]);
    }
}

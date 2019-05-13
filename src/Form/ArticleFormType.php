<?php

namespace App\Form;


use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    /**
     * @var UserRepository
     */
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('publishedAt', null, [
                'widget' => 'single_text'
            ])
            ->add('author', UserToTextType::class, [
                'finder_callback' => function(UserRepository $userRepository, $email){
                    $user = $userRepository->findOneBy(['email' => $email]);
//                    if($user->hasRole('ROLE_ADMIN_ARTICLE')){
//                        return $user;
//                    }
                    return $user;
                }
            ])

//            ->add('author', EntityType::class, [
//                'class' => User::class,
//                'choices' => $this->userRepo->findBy([], ['email' => 'ASC']),
//                'choice_label' => function(User $user){
//                    return sprintf('(%d) %s', $user->getId(), $user->getEmail());
//                },
//                'placeholder' => 'Choose an author'
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
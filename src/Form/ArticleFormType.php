<?php

namespace App\Form;


use App\Entity\Article;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
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
                'finder_callback' => function (UserRepository $userRepository, $email) {
                    $user = $userRepository->findOneBy(['email' => $email]);
//                    if($user->hasRole('ROLE_ADMIN_ARTICLE')){
//                        return $user;
//                    }
                    return $user;
                }
            ])
            ->add('location', ChoiceType::class, [
                'required' => false,
                'placeholder' => 'Choose a location',
                'choices' => [
                    'The Solar System' => 'solar_system',
                    'Near a star' => 'star',
                    'Interstellar Space' => 'interstella_space'
                ]
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

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event){
            /** @var Article | null $data */
            $data = $event->getData();
            if(!$data){
                return;
            }

            $this->setupLocationNameChoices($event->getForm(), $data->getLocation());
        });

        $builder->get('location')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->setupLocationNameChoices($form->getParent(), $form->getData());
            });

    }

    private function setupLocationNameChoices(FormInterface $form, ?string $location)
    {
        if (!$location) {
            $form->remove('specificLocationName');
            return;
        }

        $choices = $this->getLocationNameChoices($location);
        if (!$choices) {
            $form->remove('specificLocationName');
            return;
        }

        $form->add('specificLocationName', ChoiceType::class, [
            'required' => false,
            'placeholder' => 'Where exactly',
            'choices' => $choices
        ]);
    }

    private function getLocationNameChoices(string $location)
    {
        $planets = [
            'Mercury', 'Venus', 'Earth', 'Mars', 'Jupiter', 'Saturn', 'Uranus', 'Neptune'
        ];

        $stars = [
            'Polaris', 'Sirius', 'Alpha Centauari A', 'Alpha Centauari B', 'Betelgeuse', 'Rigel', 'Other'
        ];

        $locationNameChoices = [
            'solar_system' => array_combine($planets, $planets),
            'star' => array_combine($stars, $stars),
            'interstellar_space' => null
        ];

        return $locationNameChoices[$location] ?? null;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
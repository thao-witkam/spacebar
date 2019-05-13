<?php

namespace App\Form;

use App\Form\DataTransformer\EmailToUser;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class UserToTextType extends AbstractType
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RouterInterface
     */
    private $route;

    public function __construct(UserRepository $userRepository, RouterInterface $route)
    {
        $this->userRepository = $userRepository;
        $this->route = $route;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new EmailToUser(
            $this->userRepository,
            $options['finder_callback']
            ));
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'invalid_message' => 'Hmmm user not found',
            'finder_callback' => function(UserRepository $userRepository, string $email){
                return $userRepository->findOneBy(['email' => $email]);
            }
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $attr = $view->vars['attr'];
        $class = isset($attr['class']) ? $attr['class'].' ' : '';
        $class .= 'js-user-autocomplete';

        $attr['class'] = $class;
        $attr['data-autocomplete-url'] = $this->route->generate('admin_utility_users');

        $view->vars['attr'] = $attr;
    }


}
<?php

namespace App\Form\DataTransformer;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EmailToUser implements DataTransformerInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var callable
     */
    private $finderCallback;

    public function __construct(UserRepository $userRepository, callable $finderCallback)
    {
        $this->userRepository = $userRepository;
        $this->finderCallback = $finderCallback;
    }

    public function transform($value)
    {
        if(!$value){
            return '';
        }

        if(!$value instanceof User){
            throw new \LogicException('The UserToTexttype can only be user entity');
        }

        return $value->getEmail();
    }

    public function reverseTransform($value)
    {
        $callback = $this->finderCallback;
        $user = $callback($this->userRepository, $value);

        if(!$user){
            throw new TransformationFailedException(sprintf('Email "%s" not found', $value));
        }

        return $user;
    }
}
<?php

namespace App\Controller;


use App\Message\SmsNotification;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     * @param MessageBusInterface $bus
     */
    public function index(MessageBusInterface $bus)
    {
        $faker = Factory::create();
        $message = $faker->sentence(rand(5, 15));
        $bus->dispatch(new SmsNotification($message, ['name' => $faker->name, 'email' => $faker->email]));

        var_dump('send message', $message);
        die;
    }

}
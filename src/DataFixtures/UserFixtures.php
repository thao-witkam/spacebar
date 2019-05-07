<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class, 10, function (User $user){
            $user->setEmail($this->faker->email);
            $user->setFirstName($this->faker->name);
            $user->setPassword($this->faker->password);
        });

        $manager->flush();
    }
}

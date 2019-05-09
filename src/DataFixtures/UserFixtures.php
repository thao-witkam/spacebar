<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class, 10, function (User $user){
            $user->setEmail($this->faker->email);
            $user->setFirstName($this->faker->name);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
            if($this->faker->boolean){
                $user->setTwitterUsername($this->faker->userName);
            }

            if($this->faker->boolean(5)){
                $user->setRoles(['ROLE_SUPER_ADMIN']);
            }
        });

        $manager->flush();
    }
}

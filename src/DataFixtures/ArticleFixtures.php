<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixture
{
    static $images = ['asteroid.jpeg', 'mercury.jpeg', 'space-ice.png', 'asteroid.jpeg', 'alien-profile.png', 'astronaut-profile.png', 'asteroid.jpeg',  'lightspeed.png'];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function (Article $article, $count) use ($manager) {

            $article->setTitle($this->faker->sentence)
                ->setContent($this->faker->paragraph(rand(2,5)))
                ->setAuthor($this->faker->name)
                ->setHeartCount($this->faker->numberBetween(5, 100));

            $article->setImageFilename($this->faker->randomElement(self::$images));

            if (rand(1, 10) > 2) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-30days'));
            }
        });
        $manager->flush();
    }
}

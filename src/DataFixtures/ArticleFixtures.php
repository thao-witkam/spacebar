<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixture implements DependentFixtureInterface
{
    static $images = ['asteroid.jpeg', 'mercury.jpeg', 'space-ice.png', 'asteroid.jpeg', 'alien-profile.png', 'astronaut-profile.png', 'asteroid.jpeg',  'lightspeed.png'];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function (Article $article, $count) use ($manager) {

            $article->setTitle($this->faker->sentence)
                ->setContent($this->faker->paragraph(rand(2,5)))
                ->setAuthor($this->getRandomReference(User::class))
                ->setHeartCount($this->faker->numberBetween(5, 100));

            $article->setImageFilename($this->faker->randomElement(self::$images));

            if (rand(1, 10) > 2) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-30days'));
            }

            $tags = $this->getRandomReferences(Tag::class, $this->faker->numberBetween(1, 4));
            foreach($tags as $tag){
                $article->addTag($tag);
            }
        });
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            TagFixtures::class
        ];
    }
}

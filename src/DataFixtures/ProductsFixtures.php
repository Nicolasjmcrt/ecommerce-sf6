<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Products;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductsFixtures extends Fixture
{

    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($prd = 0; $prd < 10; $prd++) {
            $product = new Products();
            $product->setName($faker->text(5));
            $product->setDescription($faker->text());
            $product->setSlug($this->slugger->slug($product->getName())->lower());
            $product->setPrice($faker->numberBetween(900, 150000));
            $product->setStock($faker->numberBetween(0, 100));

            // On va chercher une référence à une catégorie aléatoire
            $category = $this->getReference('category_' . rand(1, 10));
            $product->setCategories($category);

            $manager->persist($product);
        }

        $manager->flush();
    }
}

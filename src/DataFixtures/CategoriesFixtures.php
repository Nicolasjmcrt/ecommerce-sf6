<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    private $counter = 1;


    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory('Informatique', null, $manager);

        $this->createCategory('Ordinateurs portables', $parent, $manager);
        $this->createCategory('Écrans', $parent, $manager);
        $this->createCategory('Imprimantes', $parent, $manager);
        $this->createCategory('Composants', $parent, $manager);

        $parent = $this->createCategory('Gaming', null, $manager);

        $this->createCategory('Consoles', $parent, $manager);
        $this->createCategory('Jeux vidéo', $parent, $manager);
        $this->createCategory('Accessoires', $parent, $manager);
        $this->createCategory('Abonnements', $parent, $manager);

        $manager->flush();
    }

    public function createCategory(string $name, Categories $parent = null, ObjectManager $manager)
    {
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);

        $this->addReference('category_' . $this->counter, $category);
        $this->counter++;

        return $category;
    }
}

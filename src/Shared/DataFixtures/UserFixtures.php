<?php

declare(strict_types=1);

namespace App\Shared\DataFixtures;

use App\Identity\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

final class UserFixtures extends Fixture
{
    public const USER_1 = 'IU-655532dd20bae';
    public const USER_2 = 'IU-9889635165161';

    public const PASSWORD = '$2y$13$rTr3IlN8SUlHVoWWgJiVfOh91LBS3jJiXKTc8AW9EF7V5C/J0bWla';


    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user1 = new User(
            id: self::USER_1,
            identifier: 'st',
            firstName: 'admin',
            lastName: 'rocks',
            email: 'admin@admin.pl',
            hashedPassword: self::PASSWORD,
        );

        $user2 = new User(
            id: self::USER_2,
            identifier: 'test',
            firstName: 'test',
            lastName: 'rocks',
            email: 'test@test.pl',
            hashedPassword: self::PASSWORD,
        );

        $this->em->persist($user1);
        $this->em->persist($user2);
        $this->em->flush();
    }
}

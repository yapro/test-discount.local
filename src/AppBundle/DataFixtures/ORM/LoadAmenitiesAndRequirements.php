<?php
declare(strict_types = 1);

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Amenity;
use AppBundle\Entity\Requirement;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAmenitiesAndRequirements implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $amenityIndex = 0;
        for ($i = 0; $i < 2; $i++) {
            $date = new \DateTimeImmutable();
            $requirement = (new Requirement())
                ->setDateFrom($date->modify('-1 week'))
                ->setDateTo($date->modify('1 week'))
            ;
            if ($i === 1) {
                $date = new \DateTimeImmutable('2000-01-01 00:00:00');
                $requirement
                    ->setDateFrom($date->modify('-1 week'))
                    ->setDateTo($date->modify('1 week'))
                    ->setFlagPhoneNumber(true)
                    ->setPhoneNumberEnd(5491)
                    ->setGender(1)
                ;
            }
            $manager->persist($requirement);
            for ($n = 0; $n < 2; $n++) {
                $amenityIndex++;
                $amenity = new Amenity();
                $amenity->setName('Услуга ' . $amenityIndex);
                $manager->persist($amenity);
                $requirement->addAmenity($amenity);
            }
        }
        $manager->flush();
    }
}
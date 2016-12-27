<?php
declare(strict_types = 1);

namespace AppBundle\Manager;

use AppBundle\Entity\Amenity;
use Doctrine\ORM\EntityManager;

class AmenityManager
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getAmenities(int $id)
    {
        return $this->em->getRepository(Amenity::class)->find($id);
    }
}
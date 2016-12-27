<?php
declare(strict_types = 1);

namespace AppBundle\Manager;

use AppBundle\Entity\Amenity;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;

class AmenityManager
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var EntityManager
     */
    private $em;

    function __construct(RequestStack $requestStack, EntityManager $em){
        $this->request = $requestStack->getCurrentRequest();
        $this->em = $em;
    }

    /**
     * @return Amenity[]
     */
    public function getAmenities()
    {
        return $this->em->getRepository(Amenity::class)->findAll();
    }

    /**
     * @return Amenity
     */
    public function addAmenity()
    {
        $amenity = new Amenity();
        $amenity->setName($this->request->get('name'));
        $this->em->persist($amenity);
        $this->em->flush();
        return $amenity;
    }

    /**
     * @param int $id
     * @return Amenity|null
     */
    public function updateAmenity(int $id)
    {
        $amenity = $this->em->getRepository(Amenity::class)->find($id);
        $amenity->setName($this->request->get('name'));
        $this->em->flush();
        return $amenity;
    }

    /**
     * @param int $id
     */
    public function deleteAmenity(int $id)
    {
        $amenity = $this->em->getRepository(Amenity::class)->find($id);
        $this->em->remove($amenity);
        $this->em->flush();
    }
}
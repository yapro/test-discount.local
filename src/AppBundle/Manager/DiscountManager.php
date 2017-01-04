<?php
declare(strict_types = 1);

namespace AppBundle\Manager;

use AppBundle\Api\Request\MaxDiscountRequest;
use AppBundle\Entity\Requirement;
use Doctrine\ORM\EntityManager;

class DiscountManager
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getMaxDiscountByRequest(MaxDiscountRequest $request)
    {
        $discount = $this->em->getRepository(Requirement::class)->getMaxDiscount(
            $request->getBirthDate(),
            $request->getAmenities(),
            $request->getPhoneNumber(),
            $request->getGender()
        );
        return $discount;
    }
}
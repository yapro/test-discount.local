<?php
declare(strict_types = 1);

namespace AppBundle\Manager;

use AppBundle\Entity\Requirement;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class DiscountManager
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(RequestStack $requestStack, EntityManager $em)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->em = $em;
    }

    public function getMaxDiscountByRequest()
    {
        $discount = $this->em->getRepository(Requirement::class)->getMaxDiscount(
            $this->request->get('amenities'),
            $this->request->get('birth_date', ''),
            $this->request->get('phone_number', ''),
            $this->request->get('gender', 0)
        );
        return $discount;
    }
}
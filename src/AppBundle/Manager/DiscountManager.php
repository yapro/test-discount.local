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

    function __construct(RequestStack $requestStack, EntityManager $em)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->em = $em;
    }

    public function getDiscount()
    {
        $requirements = $this->em->getRepository(Requirement::class)->getRequirementsByParams($this->request);
        // найти все требования и подобрать с наибольшей скидкой
        return ['discount' => count($requirements)];
    }
}
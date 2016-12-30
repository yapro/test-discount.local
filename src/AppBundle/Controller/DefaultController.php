<?php
declare(strict_types = 1);

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;

class DefaultController extends Controller
{
    /**
     * @Rest\Get("/api/")
     */
    public function indexAction()
    {
        return array('hello' => 'world');
    }

    /**
     * @Rest\Get("/api/amenity/")
     */
    public function getAmenitiesAction()
    {
        return $this->get('amenity_manager')->getAmenities();
    }

    /**
     * @Rest\Put("/api/amenity/")
     */
    public function putAmenityAction()
    {
        return $this->get('amenity_manager')->addAmenity();
    }

    /**
     * @Rest\Post("/api/amenity/{id}")
     */
    public function postAmenityAction(int $id)
    {
        return $this->get('amenity_manager')->updateAmenity($id);
    }

    /**
     * @Rest\Delete("/api/amenity/{id}")
     */
    public function deleteAmenityAction(int $id)
    {
        return $this->get('amenity_manager')->deleteAmenity($id);
    }

    /**
     * @Rest\Get("/api/requirement/")
     */
    public function getRequirementsAction()
    {
        return $this->get('requirement_manager')->getRequirements();
    }

    /**
     * @Rest\Get("/api/requirement/{id}")
     */
    public function getRequirementAction(int $id)
    {
        return $this->get('requirement_manager')->getRequirement($id);
    }

    /**
     * @Rest\Put("/api/requirement/")
     */
    public function putRequirementAction()
    {
        return $this->get('requirement_manager')->addRequirement();
    }

    /**
     * @Rest\Post("/api/requirement/{id}")
     */
    public function postRequirementAction(int $id)
    {
        return $this->get('requirement_manager')->updateRequirement($id);
    }

    /**
     * @Rest\Delete("/api/requirement/{id}")
     */
    public function deleteRequirementAction(int $id)
    {
        return $this->get('requirement_manager')->deleteRequirement($id);
    }

    /**
     * @Rest\Post("/api/order")
     */
    public function postDiscountAction()
    {
        return $this->get('discount_manager')->getDiscount();
    }
}

<?php
declare(strict_types = 1);

namespace AppBundle\Controller;

use AppBundle\Api\Request\MaxDiscountRequest;
use AppBundle\Api\Response\MaxDiscountResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DefaultController extends Controller
{
    /**
     * @Rest\Get("/api/amenity/")
     * @ApiDoc()
     */
    public function getAmenitiesAction()
    {
        return $this->get('amenity_manager')->getAmenities();
    }

    /**
     * @Rest\Put("/api/amenity/")
     * @ApiDoc(
     *  requirements={
     *      {
     *          "name"="name",
     *          "dataType"="string"
     *      }
     *  }
     * )
     */
    public function putAmenityAction()
    {
        return $this->get('amenity_manager')->addAmenity();
    }

    /**
     * @Rest\Post("/api/amenity/{id}")
     * @ApiDoc(
     *  requirements={
     *      {
     *          "name"="name",
     *          "dataType"="string"
     *      }
     *  }
     * )
     */
    public function postAmenityAction(int $id)
    {
        return $this->get('amenity_manager')->updateAmenity($id);
    }

    /**
     * @Rest\Delete("/api/amenity/{id}")
     * @ApiDoc()
     */
    public function deleteAmenityAction(int $id)
    {
        return $this->get('amenity_manager')->deleteAmenity($id);
    }

    /**
     * @Rest\Get("/api/requirement/")
     * @ApiDoc()
     */
    public function getRequirementsAction()
    {
        return $this->get('requirement_manager')->getRequirements();
    }

    /**
     * @Rest\Get("/api/requirement/{id}")
     * @ApiDoc()
     */
    public function getRequirementAction(int $id)
    {
        return $this->get('requirement_manager')->getRequirement($id);
    }

    /**
     * @Rest\Put("/api/requirement/")
     * @ApiDoc(
     *  input="AppBundle\Entity\Requirement",
     *  output="AppBundle\Entity\Requirement"
     * )
     */
    public function putRequirementAction()
    {
        return $this->get('requirement_manager')->addRequirement();
    }

    /**
     * @Rest\Post("/api/requirement/{id}")
     * @ApiDoc(
     *  input="AppBundle\Entity\Requirement",
     *  output="AppBundle\Entity\Requirement"
     * )
     */
    public function postRequirementAction(int $id)
    {
        return $this->get('requirement_manager')->updateRequirement($id);
    }

    /**
     * @Rest\Delete("/api/requirement/{id}")
     * @ApiDoc()
     */
    public function deleteRequirementAction(int $id)
    {
        $this->get('requirement_manager')->deleteRequirement($id);
    }

    /**
     * @Rest\Post("/api/order")
     * @ParamConverter("request", converter="fos_rest.request_body")
     * @param \AppBundle\Api\Request\MaxDiscountRequest $request
     * @ApiDoc(
     *  input="AppBundle\Api\Request\MaxDiscountRequest",
     *  output="AppBundle\Api\Response\MaxDiscountResponse"
     * )
     * @return MaxDiscountResponse
     */
    public function postDiscountAction(MaxDiscountRequest $request)
    {
        return (new MaxDiscountResponse())->setDiscount(
            $this->get('discount_manager')->getMaxDiscountByRequest($request)
        );
    }
}

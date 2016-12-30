<?php
declare(strict_types = 1);

namespace AppBundle\Manager;

use AppBundle\Entity\Amenity;
use AppBundle\Entity\Requirement;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;


class RequirementManager
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

    /**
     * @return Requirement[]
     */
    public function getRequirements()
    {
        return $this->em->getRepository(Requirement::class)->findAll();
    }

    /**
     * @param int $id
     * @return Requirement|null
     */
    public function getRequirement(int $id)
    {
        return $this->em->getRepository(Requirement::class)->find($id);
    }

    /**
     * @return Requirement
     */
    public function addRequirement() : Requirement
    {
        $requirement = new Requirement();
        return $this->enrichRequirement($requirement);
    }

    /**
     * @param int $id
     * @return Requirement|null
     */
    public function updateRequirement(int $id)
    {
        $requirement = $this->em->getRepository(Requirement::class)->find($id);
        return $requirement instanceof Requirement ? $this->enrichRequirement($requirement) : null;
    }

    /**
     * @param int $id
     */
    public function deleteRequirement(int $id)
    {
        $amenity = $this->em->getRepository(Requirement::class)->find($id);
        $this->em->remove($amenity);
        $this->em->flush();
    }

    /**
     * @param Requirement $requirement
     * @return Requirement
     */
    private function enrichRequirement(Requirement $requirement) : Requirement
    {
        $requirement
            ->setDiscount($this->request->get('discount'))
            ->setDateFrom(new \DateTime($this->request->get('date_from')))
            ->setDateTo($this->request->get('date_to') ? new \DateTime($this->request->get('date_to')) : null)
            ->setFlagBirthDateBefore($this->request->get('flag_birth_date_before', false))
            ->setFlagBirthDateAfter($this->request->get('flag_birth_date_after', false))
            ->setFlagPhoneNumber($this->request->get('flag_phone_number', false))
            ->setGender($this->request->get('gender', 0));
        $phoneNumberEnd = filter_var($this->request->get('phone_number_end'), FILTER_VALIDATE_INT);
        if($phoneNumberEnd !== false) {
            $requirement->setPhoneNumberEnd($phoneNumberEnd);
        }
        $this->saveAmenities($requirement);
        $this->em->persist($requirement);
        $this->em->flush();
        return $requirement;
    }

    /**
     * @param Requirement $requirement
     */
    private function saveAmenities(Requirement $requirement)
    {
        $amenitiesData = $this->request->get('amenities');
        if (empty($amenitiesData)) {
            return;
        }
        $existedAmenities = $this->getExistedAmenityWithId($requirement->getAmenities());
        foreach ($amenitiesData as $amenityData) {
            if (empty($amenityData['isSelected'])) {
                if (array_key_exists($amenityData['id'], $existedAmenities)) {
                    $requirement->removeAmenity($existedAmenities[$amenityData['id']]);
                }
            } else {
                if (!array_key_exists($amenityData['id'], $existedAmenities)) {
                    $amenity = $this->em->getRepository(Amenity::class)->find($amenityData['id']);
                    $requirement->addAmenity($amenity);
                }
            }
        }
    }

    /**
     * @param Collection $amenities
     * @return array
     */
    private function getExistedAmenityWithId(Collection $amenities)
    {
        $result = [];
        /** @var Amenity $amenity */
        foreach ($amenities->getValues() as $amenity) {
            $result[$amenity->getId()] = $amenity;
        }
        return $result;
    }
}
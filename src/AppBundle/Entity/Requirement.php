<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Requirement
 *
 * @ORM\Table(name="requirement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RequirementRepository")
 */
class Requirement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="flag_birth_date_before", type="boolean", options={"unsigned": true, "default":"0"})
     */
    private $flagBirthDateBefore = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="flag_birth_date_after", type="boolean", options={"unsigned": true, "default":"0"})
     */
    private $flagBirthDateAfter = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="flag_phone_number", type="boolean", options={"unsigned": true, "default":"0"})
     */
    private $flagPhoneNumber = false;

    /**
     * @var int
     *
     * @ORM\Column(name="phone_number_end", type="smallint", options={"unsigned": true}, nullable=true)
     */
    private $phoneNumberEnd;

    /**
     * @var int
     *
     * @ORM\Column(name="gender", type="smallint", options={"unsigned": true, "default":0})
     */
    private $gender = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_from", type="date")
     */
    private $dateFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_to", type="date")
     */
    private $dateTo;

    /**
     * Many Requirements have Many Amenities.
     * @ORM\ManyToMany(targetEntity="Amenity")
     * @ORM\JoinTable(name="requirements_amenities",
     *      joinColumns={@ORM\JoinColumn(name="requirement_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="amenity_id", referencedColumnName="id")}
     *      )
     */
    private $amenities;

    public function __construct() {
        $this->amenities = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Set amenities
     *
     * @param ArrayCollection $amenities
     *
     * @return Requirement
     */
    public function setAmenities(ArrayCollection $amenities)
    {
        $this->amenities = $amenities;

        return $this;
    }

    /**
     * Get amenities
     *
     * @return ArrayCollection
     */
    public function getAmenities() : ArrayCollection
    {
        return $this->amenities;
    }

    /**
     * @param Amenity $amenity
     * @return $this
     */
    public function addAmenity(Amenity $amenity)
    {
        $this->amenities->add($amenity);

        return $this;
    }

    /**
     * @param Amenity $amenity
     * @return $this
     */
    public function removeAmenity(Amenity $amenity)
    {
        if ($this->amenities->contains($amenity)){
            $this->amenities->remove($amenity);
        }

        return $this;
    }

    /**
     * Set flagBirthDateBefore
     *
     * @param boolean $flagBirthDateBefore
     *
     * @return Requirement
     */
    public function setFlagBirthDateBefore(bool $flagBirthDateBefore)
    {
        $this->flagBirthDateBefore = $flagBirthDateBefore;

        return $this;
    }

    /**
     * Get flagBirthDateBefore
     *
     * @return bool
     */
    public function getFlagBirthDateBefore() : bool
    {
        return $this->flagBirthDateBefore;
    }

    /**
     * Set flagBirthDateAfter
     *
     * @param boolean $flagBirthDateAfter
     *
     * @return Requirement
     */
    public function setFlagBirthDateAfter(bool $flagBirthDateAfter)
    {
        $this->flagBirthDateAfter = $flagBirthDateAfter;

        return $this;
    }

    /**
     * Get flagBirthDateAfter
     *
     * @return bool
     */
    public function getFlagBirthDateAfter() : bool
    {
        return $this->flagBirthDateAfter;
    }

    /**
     * Set flagPhoneNumber
     *
     * @param boolean $flagPhoneNumber
     *
     * @return Requirement
     */
    public function setFlagPhoneNumber(bool $flagPhoneNumber)
    {
        $this->flagPhoneNumber = $flagPhoneNumber;

        return $this;
    }

    /**
     * Get flagPhoneNumber
     *
     * @return bool
     */
    public function getFlagPhoneNumber() : bool
    {
        return $this->flagPhoneNumber;
    }

    /**
     * Set phoneNumberEnd
     *
     * @param integer $phoneNumberEnd
     *
     * @return Requirement
     */
    public function setPhoneNumberEnd(int $phoneNumberEnd)
    {
        $this->phoneNumberEnd = $phoneNumberEnd;

        return $this;
    }

    /**
     * Get phoneNumberEnd
     *
     * @return int
     */
    public function getPhoneNumberEnd() : int
    {
        return $this->phoneNumberEnd;
    }

    /**
     * Set gender
     *
     * @param integer $gender
     *
     * @return Requirement
     */
    public function setGender(int $gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return int
     */
    public function getGender() : int
    {
        return $this->gender;
    }

    /**
     * Set dateFrom
     *
     * @param \DateTimeInterface $dateFrom
     *
     * @return Requirement
     */
    public function setDateFrom(\DateTimeInterface $dateFrom = null)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime
     */
    public function getDateFrom() : \DateTime
    {
        return $this->dateFrom;
    }

    /**
     * Set dateTo
     *
     * @param \DateTimeInterface $dateTo
     *
     * @return Requirement
     */
    public function setDateTo(\DateTimeInterface $dateTo = null)
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * Get dateTo
     *
     * @return \DateTime
     */
    public function getDateTo() : \DateTime
    {
        return $this->dateTo;
    }
}


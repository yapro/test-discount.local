<?php
declare(strict_types = 1);

namespace AppBundle\Api\Request;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

class MaxDiscountRequest
{
    /**
	 * @var array
	 * @Serializer\Type("array")
	 */
    private $amenities = [];
	
    /**
	 * @var \DateTime
	 * @Assert\NotBlank()
	 * @Serializer\Type("DateTime<'Y-m-d'>")
	 * @Serializer\SerializedName("birth_date")
	 */
    private $birthDate;

	/**
	 * @var string
	 * @Serializer\Type("string")
	 * @Serializer\SerializedName("phone_number")
	 * @Assert\Regex("/^[\d -+]+$/")
	 */
	private $phoneNumber = '';
	
	/**
	 *
	 * @var integer
	 * @Serializer\Type("integer")
	 * @Serializer\SerializedName("gender")
	 * @Assert\Choice(choices = {0, 1, 2})
	 */
	private $gender = 0;
	
	/**
	 * @return array
	 */
	public function getAmenities() : array 
	{
		return $this->amenities;
	}

	/**
	 * @param array $amenities
	 * @return MaxDiscountRequest
	 */
	public function setAmenities($amenities) : MaxDiscountRequest
	{
		$this->amenities = $amenities;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getBirthDate() : \DateTime
	{
		return $this->birthDate;
	}

	/**
	 * @param \DateTime $birthDate
	 * @return MaxDiscountRequest
	 */
	public function setBirthDate($birthDate) : MaxDiscountRequest
	{
		$this->birthDate = $birthDate;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPhoneNumber() : string
	{
		return $this->phoneNumber;
	}

	/**
	 * @param string $phoneNumber
	 * @return MaxDiscountRequest
	 */
	public function setPhoneNumber($phoneNumber) : MaxDiscountRequest
	{
		$this->phoneNumber = $phoneNumber;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getGender() : int
	{
		return $this->gender;
	}

	/**
	 * @param int $gender
	 * @return MaxDiscountRequest
	 */
	public function setGender($gender) : MaxDiscountRequest
	{
		$this->gender = $gender;
		return $this;
	}
}
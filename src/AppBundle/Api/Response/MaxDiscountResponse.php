<?php
declare(strict_types = 1);

namespace AppBundle\Api\Response;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

class MaxDiscountResponse
{
	/**
	 *
	 * @var integer
	 * @Serializer\Type("integer")
	 * @Serializer\SerializedName("discount")
	 */
	private $discount;

	/**
	 * @return int
	 */
	public function getDiscount() : int
	{
		return $this->discount;
	}

	/**
	 * @param int $discount
	 * @return MaxDiscountResponse
	 */
	public function setDiscount($discount) : MaxDiscountResponse
	{
		$this->discount = $discount;
		return $this;
	}
}
<?php 

namespace TDD;

use \BadMethodCallException;

use TDD\Formatter;

class Receipt
 {


 	protected $formatter;


 	public function __construct($formatter)
 	{
 		

 		$this->formatter = $formatter;


 	}


	public function subtotal(array $items = [], $coupon)
	{


		if($coupon > 1.00)
		{

			throw new BadMethodCallException('Coupon must be less than or equal to 1.00');

		}


		$sum = array_sum($items);

		
		if(!is_null($coupon))
		{
			
		
		 return $sum - ($sum * $coupon);
		
		
		}

		
		return $sum;

	}


	public function tax($amount)
	{
		

		return $this->formatter->currencyAmount(($amount * $this->tax));


	}



	public function postTaxTotal($items, $coupon)
	{
		
		$subtotal = $this->subtotal($items, $coupon);	

		return $subtotal + $this->tax($subtotal);	


	}




}
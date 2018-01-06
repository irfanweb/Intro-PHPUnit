<?php

namespace TDD\Test;

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR.'vendor'. DIRECTORY_SEPARATOR.'autoload.php';


use PHPUnit\Framework\TestCase;

use TDD\Receipt;

class ReceiptTest extends TestCase
{


	public function setUP()
	{
		
 
		$this->receipt = new Receipt();


	}



	public function tearDown()
	{


		unset($this->receipt);

	}


	public function testTotal()
	{
		
		$input = [ 0, 2, 5, 8];

		$coupon = null;

		$output = $this->receipt->total($input, $coupon);

		$this->assertEquals(
			15,
		 	$output,
		 	 'When summing the total should be equal to 15'
		);

	}



	public function testTotalWithCoupon()
	{
		
		$input = [ 0, 2, 5, 8];

		$coupon = 0.20;

		$output = $this->receipt->total($input, $coupon);

		$this->assertEquals(
			12,
		 	$output,
		 	 'When summing the total should be equal to 12'
		);

	}




	public function testTax()
	{
		

		$inputAmount = 10.00;

		$taxAmount =  0.10;

		$output = $this->receipt->tax($inputAmount, $taxAmount);

		$this->assertEquals(
			1.00,
			$output,
			'The Tax Calculation should be qual to 1.00'
		);



	}



	public function testpostTaxTotal()
	{
		
		$items = [1, 2, 5, 8];

		$tax = 0.20;

		$coupon = null;

		$receipt = $this->getMockBuilder('TDD\Receipt')
	 					 ->setMethods(['tax', 'total'])
						 ->getMock();


		$receipt->expects($this->once())
				->method('total')
				->with($items, $coupon)
				->will($this->returnValue(10.00));


		$receipt->expects($this->once())
				->method('tax')
				->with(10.00, $tax)
				->will($this->returnValue(1.00));


		$results = $receipt->postTaxTotal([1, 2, 5, 8], 0.20, null);
		

		$this->assertEquals(11.00, $results);		


	}



 
}
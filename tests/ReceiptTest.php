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


	/**
	* @dataProvider provideSubtotal
	*/
	public function testSubTotal($items, $expected)
	{
		
		$coupon = null;

		$output = $this->receipt->subtotal($items, $coupon);

		$this->assertEquals(
			$expected,
		 	$output,
		 	 "When summing the total should be equal to {$expected}"
		);

	}


	public function provideSubtotal()
	{
		
		return [

		'ints totaling 16' => [ [1, 2, 5, 8], 16],

			[[-1, 2, 5, 8], 14],

			[[1, 2, 8], 11]
		];

	}


	public function testSubtotalWithCoupon()
	{
		
		$input = [ 0, 2, 5, 8];

		$coupon = 0.20;

		$output = $this->receipt->subtotal($input, $coupon);

		$this->assertEquals(
			12,
		 	$output,
		 	 'When summing the total should be equal to 12'
		);

	}



	public function testSubtotalWithCouponGreaterThan100PercentException()
	{
		
		$input = [ 0, 2, 5, 8];

		$coupon = 1.20;

		$this->expectException('BadMethodCallException');

		$this->receipt->subtotal($input, $coupon);


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
	 					 ->setMethods(['tax', 'subtotal'])
						 ->getMock();


		$receipt->expects($this->once())
				->method('subtotal')
				->with($items, $coupon)
				->will($this->returnValue(10.00));


		$receipt->expects($this->once())
				->method('tax')
				->with(10.00, $tax)
				->will($this->returnValue(1.00));


		$results = $receipt->postTaxTotal([1, 2, 5, 8], 0.20, null);
		

		$this->assertEquals(11.00, $results);		


	}

	/**
	 * @dataProvider provideCurrenyAmount
	*/

	public function testCurrentyAmount($input, $expected, $msg)
	{
		

		$this->assertSame(
			$expected,
			$this->receipt->currenyAmount($input),
			 $msg
		);

	}


	public function provideCurrenyAmount()
	{
		
		return [

			[1, 1.00, '1 should be transformed into 1.00'],

			[1.1, 1.10, '1.1 should be transformed into 1.10'],
			
			[1.11, 1.11, '1.11 should stay as 1.11'],

			[1.111, 1.11, '1.111 should be transformed into 1.11'],


		];


	}

















 
}
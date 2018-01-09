<?php

namespace TDD\Test;

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR.'vendor'. DIRECTORY_SEPARATOR.'autoload.php';


use PHPUnit\Framework\TestCase;

use TDD\Receipt;

class ReceiptTest extends TestCase
{


	public function setUP()
	{
		
 		$this->formatter = $this->getMockBuilder('TDD\Formatter')
 								->setMethods(['currencyAmount'])
 								->getMock();


 		$this->formatter->expects($this->any())
 						->method('currencyAmount')
 						->with($this->anything())
 						->will($this->returnArgument(0));	


		$this->receipt = new Receipt($this->formatter);



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

		$this->receipt->tax =  0.10;

		$output = $this->receipt->tax($inputAmount);

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
	 					 ->setConstructorArgs([$this->formatter])
						 ->getMock();


		$receipt->expects($this->once())
				->method('subtotal')
				->with($items, $coupon)
				->will($this->returnValue(10.00));


		$receipt->expects($this->once())
				->method('tax')
				->with(10.00)
				->will($this->returnValue(1.00));


		$results = $receipt->postTaxTotal([1, 2, 5, 8], null);
		

		$this->assertEquals(11.00, $results);		


	}








 
}
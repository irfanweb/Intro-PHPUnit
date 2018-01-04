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

		$output = $this->receipt->total($input);

		$this->assertEquals(
			15,
		 	$output,
		 	 'When summing the total should be equal to 15'
		);

	}



}
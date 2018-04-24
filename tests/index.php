<?php

require_once('./vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestSuite;

class MySuite extends TestSuite
{
	public static function suite()
	{
		$suite = new MySuite('MyTestSuite');
		$suite->addTestSuite('MathClassTest1');
		$suite->addTestSuite('MathClassTest2');
		$suite->addTestSuite('MathClassTest3');
		return $suite;
	}
}


class MathClass
{
	public function factorial($n)
	{
		if ($n == 0)
		{
			return 1;
		}
		else
		{
			return $n * $this->factorial($n-1);
		}
	}
}



class MathClassTest1 extends TestCase
{
	
	public function testFactorial()
	{
		$my = new MathClass();
		$this->assertEquals(6, $my->factorial(3));
	}
	
}



class MathClassTest2 extends TestCase
{
	/**
	* @dataProvider providerFactorial
	*/
	
	public function testFactorial($a, $b)
	{
		$my = new MathClass();
		$this->assertEquals($b, $my->factorial($a));
	}
	
	
	public function providerFactorial()
	{
		return array(
			array(0,1),
			array(2,2),
			array(3,6),
			array(5,120),
			array(6,720),
			array(7,1440),
			array(8,40320),
		);
	}
	
	
}



class MathClassTest3 extends TestCase
{
	protected $fixture;
	
	protected function setUp()
	{
		$this->fixture = new MathClass();
	}
	
	protected function tearDown()
	{
		$this->fixture = NULL;
	}
	
	
	/**
	* @dataProvider providerFactorial
	*/
	
	public function testFactorial($a, $b)
	{
//		$my = new MathClass();
		$this->assertEquals($b, $this->fixture->factorial($a));
	}
	
	
	public function providerFactorial()
	{
		return array(
			array(0,1),
			array(2,2),
			array(3,6),
			array(5,120),
			array(6,720),
			array(7,1440),
			array(8,40320),
		);
	}
	
	
}





?>







<?php

//App::import('Lib', 'FutureCakeTestCase.FutureCakeTestCase');
// @include_once 'Mockery/Loader.php'; $loader = new \Mockery\Loader; $loader->register();


/**
 * FutureCakeTestCase Test Case
 *
 * Test all of the (implemented) PHPUnit-style compatibility methods that map
 * to SimpleTest assertions.
 *
 * This same test case should pass when run under PHPUnit. To test that:
 *   - Comment out the App::import(...) line above.
 *   - Load Mockery here instead: @include_once 'Mockery/Loader.php'; $loader = new \Mockery\Loader; $loader->register();
 *   - Make this class extend from PHPUnit_Framework_TestCase instead of CompatibleCakeTestCase.
 *   - Execute the test under phpunit: `phpunit tests/cases/compatible_cake_test_case.test.php`
 *   - (Everything should still pass.)
 *
 */
class FutureCakeTestCaseTest extends FutureCakeTestCase {
//class FutureCakeTestCaseTest extends PHPUnit_Framework_TestCase {

	/**
	 * Test all of the compatibility PHPUnit-style assertions with known-good
	 * values. Only the assertions tests below have been implemented (out of
	 * the 91 total assertions supported directly by PHPUnit.) This is due to
	 * the limited counterparts available in SimpleTest. Attempting to use an
	 * unimplemented assertion will result in a failure.
	 *
	 * @return void
	 */
	public function testAssertions() {
		$this->assertCount(2, array('a', 'b'), '`array(a,b)` has 2 elements.');
		$this->assertEmpty(array(), '`array()` is empty.');
		$this->assertEquals('expected', 'expected', '`expected` is the same as `expected`.');
		$this->assertFalse(false, '`false` is false.');
		$this->assertFileExists(__FILE__, 'This file exists.');
		$this->assertFileNotExists('nonexistant.txt', '`nonexistant.txt` file does not exist.');
		$this->assertGreaterThan(1, 3, '3 > 1.');
		$this->assertGreaterThanOrEqual(1, 3, '3 >= 1.');
		$this->assertGreaterThanOrEqual(3, 3, '3 >= 3.');

		$this->assertInternalType('boolean', true, '`true` is internal type boolean.');
		$this->assertInternalType('integer',2,  '`2` is internal type integer.');
		$this->assertInternalType('float', 3.14, '`3.14` is internal type double.');
		$this->assertInternalType('string', 'hello world', '`hellow world` is internal type string.');
		$this->assertInternalType('array', array(), '`array()` is internal type array.');
		$this->assertInternalType('resource', fopen(__FILE__, 'r'), '`fopen(__FILE__, r)` is internal type resource.');
		$this->assertInternalType('null', null, '`null` is internal type null.');

		$this->assertInstanceOf('StdClass', new StdClass(), '`new StdClass` is an instance of an object.');

		$this->assertLessThan(3, 1, '1 < 3.');
		$this->assertLessThanOrEqual(3, 2, '2 <= 3.');
		$this->assertLessThanOrEqual(3, 3, '3 <= 3.');
		$this->assertNotCount(2, array('a'), '`array(a)` does not have 2 elements.');
		$this->assertNotEmpty(array('a'), '`array(a)` is not empty.');
		$this->assertNotEquals('expected', 'different', '`different` is not the same as `expected`.');

		$this->assertNotInstanceOf('StdClass', 'hello world', '`hello world` is not an integer.');

		$this->assertNotInternalType('string', false, '`false` is not a string.');

		$this->assertNotNull(42,  '`42` is not null.');
		$this->assertNotRegExp('/.*f.*/', 'abcde', '`abcde` does not match pattern /.*f.*/.');

		$x = array('string');
		$y = 'string';
		$this->assertNotSame($x, $y, '`array(string)` is not the same as "string".');

		$this->assertNotSameSize(array('a'), array(1, 2), '`array(a)` is not the same size as `array(1, 2)`.');
		$this->assertNull(null, '`null` is null.');
		$this->assertRegExp('/.*f.*/', 'abcdefghi', '`abcdefghi` matches pattern /.*f.*/.');

		$var = new StdClass();
		$this->assertSame($var, $var, '`$var` is the same as $var.');

		$this->assertSameSize(array('a'), array(1), '`array(a)` is not the same size as `array(1)`.');
		$this->assertTrue(true, '`true` is true.');
	}

	/**
	 * Verify that we can create Mockery mocks.
	 *
	 * @return void
	 */
	public function testMockery() {
		$mock = Mockery::mock('StdClass');
		$mock->shouldReceive('someMethod')
			->with('list', array('conditions'))
			->once()
			->andReturn('canary')
			->mock();

		$this->assertEquals('canary', $mock->someMethod('list', array('conditions')));
	}
}

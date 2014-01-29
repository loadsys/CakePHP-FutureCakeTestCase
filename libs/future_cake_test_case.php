<?php
/**
 * FutureCakeTestCase class
 */

App::__map(CAKE . 'tests/lib/cake_test_case.php', 'CakeTestCase', 'Test', false);
App::import('Test', 'CakeTestCase');

@include_once 'Mockery/Loader.php';
$loader = new \Mockery\Loader;
$loader->register();

/**
 * FutureCakeTestCase base class. Provides a future-compatible interface
 * for writing tests that will be more-automatically compatible with phpunit
 * under Cake 2.x.
 *
 * Usage:
 *   - All test cases in the 1.3 project should inherit from
 *     `CompatibleCakeTestCase` instead of just `CakeTestCase`.
 *   - Your test case files will have to include
 *     `App::import(null, 'CompatibleCakeTestCase', array('file' => 'libs/test/CompatibleCakeTestCase.php'));`
 *     at the top as well.
 *
 */
class FutureCakeTestCase extends CakeTestCase {

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		parent::tearDown();
		Mockery::close();
	}

	/**
	 * skipWithoutMockery method
	 *
	 * @TODO: Add ability to properly reference the calling method.
	 * Ref: http://stackoverflow.com/a/11238046/70876
	 * Ref: http://stackoverflow.com/a/9133897/70876
	 * Ref: https://github.com/sebastianbergmann/phpunit/tree/master/src/Framework
	 *
	 * @return void
	 */
	public function skipWithoutMockery() {
		if (!class_exists('Mockery')) {
			self::markTestSkipped('Mockery framework not available.');
			// $Exception = new PHPUnit_Framework_SkippedTestError($message);
			// $Exception->setCallingFunctionAndLineNumber(...);
			// throw $Exception;
		}
	}

	/**
	 * Provides a future-compatible way to mark tests as intentionally skipped.
	 * This will continue to work under Cake 2.x and phpunit.
	 *
	 * @return void
	 */
	public function markTestSkipped($msg) {
		self::skip($msg);
	}

	/**
	 * Provides a future-compatible way to mark tests as incomplete. This will
	 * continue to work under Cake 2.x and phpunit.
	 *
	 * @return void
	 */
	public function markTestIncomplete($msg) {
		self::skip($msg);
	}


	/**
	 * Forward-compatibility wrapper function for PHPUnit's (lack of) assertError.
	 *
	 * @return void
	 */
	public function assertError() {
		return self::fail('assertError will not be available under PHPUnit. Please choose a different assertion method.');
	}

	/**
	 * Forward-compatibility wrapper function for PHPUnit's (lack of) assertNoErrors.
	 *
	 * @return void
	 */
	public function assertNoErrors() {
		return self::fail('assertNoErrors will not be available under PHPUnit. Please choose a different assertion method.');
	}

	/**
	 * Forward-compatibility wrapper function for PHPUnit's (lack of) swallowErrors.
	 *
	 * @return void
	 */
	public function swallowErrors() {
		return self::fail('swallowErrors will not be available under PHPUnit. Please choose a different assertion method.');
	}



	/**
	 * =========================================================================
	 * List of SimpleTest assertions we can map *TO* (cribbed from):
	 * http://www.simpletest.org/en/unit_test_documentation.html
	 * These are the methods we can use to implement our "fake" phpunit
	 * assertions. Some of phpunit's assertions are too complex to be converted
	 * into SimpleTest assertions. Such cases below will result in a test
	 * failure.
	 * =========================================================================
	 */
	/*
	assertTrue($x)	Fail if $x is false
	assertFalse($x)	Fail if $x is true
	assertNull($x)	Fail if $x is set
	assertNotNull($x)	Fail if $x not set
	assertIsA($x, $t)	Fail if $x is not the class or type $t
	assertNotA($x, $t)	Fail if $x is of the class or type $t
	assertEqual($x, $y)	Fail if $x == $y is false
	assertNotEqual($x, $y)	Fail if $x == $y is true
	assertWithinMargin($x, $y, $m)	Fail if abs($x - $y) < $m is false
	assertOutsideMargin($x, $y, $m)	Fail if abs($x - $y) < $m is true
	assertIdentical($x, $y)	Fail if $x == $y is false or a type mismatch
	assertNotIdentical($x, $y)	Fail if $x == $y is true and types match
	assertReference($x, $y)	Fail unless $x and $y are the same variable
	assertClone($x, $y)	Fail unless $x and $y are identical copies
	assertPattern($p, $x)	Fail unless the regex $p matches $x
	assertNoPattern($p, $x)	Fail if the regex $p matches $x
	expectError($x)	Fail if matching error does not occour
	expectException($x)	Fail if matching exception is not thrown
	ignoreException($x)	Swallows any upcoming matching exception
	*/



	/**
	 * =========================================================================
	 * Below are all available PHPUnit assertions, cribbed from:
	 * https://raw.github.com/sebastianbergmann/phpunit/master/src/Framework/Assert/Functions.php
	 * They have been implemented in terms of available SimpleTest assertions
	 * or PHP primitive checks (where available). Assertions that can not be
	 * easily mapped will result in a test failure.
	 * =========================================================================
	 */

	/**
	 * Asserts that an array has a specified key.
	 *
	 * @param  mixed  $key
	 * @param  array|ArrayAccess  $array
	 * @param  string $message
	 * @since  Method available since Release 3.0.0
	 */
	protected function assertArrayHasKey($key, $array, $message = '') {
		return self::assertTrue(array_key_exists($key, $array), $message);
	}

	/**
	 * Asserts that an array does not have a specified key.
	 *
	 * @param  mixed  $key
	 * @param  array|ArrayAccess  $array
	 * @param  string $message
	 * @since  Method available since Release 3.0.0
	 */
	protected function assertArrayNotHasKey($key, $array, $message = '') {
		return self::assertTrue(!array_key_exists($key, $array), $message);
	}

	/**
	 * Asserts that a haystack that is stored in a static attribute of a class
	 * or an attribute of an object contains a needle.
	 *
	 * @param  mixed   $needle
	 * @param  string  $haystackAttributeName
	 * @param  mixed   $haystackClassOrObject
	 * @param  string  $message
	 * @param  boolean $ignoreCase
	 * @param  boolean $checkForObjectIdentity
	 * @param  boolean $checkForNonObjectIdentity
	 * @since  Method available since Release 3.0.0
	 */
	protected function assertAttributeContains($needle, $haystackAttributeName, $haystackClassOrObject, $message = '', $ignoreCase = FALSE, $checkForObjectIdentity = TRUE, $checkForNonObjectIdentity = FALSE) {
		return self::fail('@TODO: assertAttributeContains compatibility method is not implemented.' . $message);
	}

	/**
	 * Asserts that a haystack that is stored in a static attribute of a class
	 * or an attribute of an object contains only values of a given type.
	 *
	 * @param  string  $type
	 * @param  string  $haystackAttributeName
	 * @param  mixed   $haystackClassOrObject
	 * @param  boolean $isNativeType
	 * @param  string  $message
	 * @since  Method available since Release 3.1.4
	 */
	protected function assertAttributeContainsOnly($type, $haystackAttributeName, $haystackClassOrObject, $isNativeType = NULL, $message = '') {
		return self::fail('@TODO: assertAttributeContainsOnly compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts the number of elements of an array, Countable or Traversable
	 * that is stored in an attribute.
	 *
	 * @param integer $expectedCount
	 * @param string  $haystackAttributeName
	 * @param mixed   $haystackClassOrObject
	 * @param string  $message
	 * @since Method available since Release 3.6.0
	 */
	protected function assertAttributeCount($expectedCount, $haystackAttributeName, $haystackClassOrObject, $message = '') {
		return self::fail('@TODO: assertAttributeCount compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a static attribute of a class or an attribute of an object
	 * is empty.
	 *
	 * @param string $haystackAttributeName
	 * @param mixed  $haystackClassOrObject
	 * @param string $message
	 * @since Method available since Release 3.5.0
	 */
	protected function assertAttributeEmpty($haystackAttributeName, $haystackClassOrObject, $message = '') {
		return self::fail('@TODO: assertAttributeEmpty compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a variable is equal to an attribute of an object.
	 *
	 * @param  mixed   $expected
	 * @param  string  $actualAttributeName
	 * @param  string  $actualClassOrObject
	 * @param  string  $message
	 * @param  float   $delta
	 * @param  integer $maxDepth
	 * @param  boolean $canonicalize
	 * @param  boolean $ignoreCase
	 */
	protected function assertAttributeEquals($expected, $actualAttributeName, $actualClassOrObject, $message = '', $delta = 0, $maxDepth = 10, $canonicalize = FALSE, $ignoreCase = FALSE) {
		return self::fail('@TODO: assertAttributeEquals compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that an attribute is greater than another value.
	 *
	 * @param  mixed   $expected
	 * @param  string  $actualAttributeName
	 * @param  string  $actualClassOrObject
	 * @param  string  $message
	 * @since  Method available since Release 3.1.0
	 */
	protected function assertAttributeGreaterThan($expected, $actualAttributeName, $actualClassOrObject, $message = '') {
		return self::fail('@TODO: assertAttributeGreaterThan compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that an attribute is greater than or equal to another value.
	 *
	 * @param  mixed   $expected
	 * @param  string  $actualAttributeName
	 * @param  string  $actualClassOrObject
	 * @param  string  $message
	 * @since  Method available since Release 3.1.0
	 */
	protected function assertAttributeGreaterThanOrEqual($expected, $actualAttributeName, $actualClassOrObject, $message = '') {
		return self::fail('@TODO: assertAttributeGreaterThanOrEqual compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that an attribute is of a given type.
	 *
	 * @param string $expected
	 * @param string $attributeName
	 * @param mixed  $classOrObject
	 * @param string $message
	 * @since Method available since Release 3.5.0
	 */
	protected function assertAttributeInstanceOf($expected, $attributeName, $classOrObject, $message = '') {
		return self::fail('@TODO: assertAttributeInstanceOf compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that an attribute is of a given type.
	 *
	 * @param string $expected
	 * @param string $attributeName
	 * @param mixed  $classOrObject
	 * @param string $message
	 * @since Method available since Release 3.5.0
	 */
	protected function assertAttributeInternalType($expected, $attributeName, $classOrObject, $message = '') {
		return self::fail('@TODO: assertAttributeInternalType compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that an attribute is smaller than another value.
	 *
	 * @param  mixed   $expected
	 * @param  string  $actualAttributeName
	 * @param  string  $actualClassOrObject
	 * @param  string  $message
	 * @since  Method available since Release 3.1.0
	 */
	protected function assertAttributeLessThan($expected, $actualAttributeName, $actualClassOrObject, $message = '') {
		return self::fail('@TODO: assertAttributeLessThan compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that an attribute is smaller than or equal to another value.
	 *
	 * @param  mixed   $expected
	 * @param  string  $actualAttributeName
	 * @param  string  $actualClassOrObject
	 * @param  string  $message
	 * @since  Method available since Release 3.1.0
	 */
	protected function assertAttributeLessThanOrEqual($expected, $actualAttributeName, $actualClassOrObject, $message = '') {
		return self::fail('@TODO: assertAttributeLessThanOrEqual compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a haystack that is stored in a static attribute of a class
	 * or an attribute of an object does not contain a needle.
	 *
	 * @param  mixed   $needle
	 * @param  string  $haystackAttributeName
	 * @param  mixed   $haystackClassOrObject
	 * @param  string  $message
	 * @param  boolean $ignoreCase
	 * @param  boolean $checkForObjectIdentity
	 * @param  boolean $checkForNonObjectIdentity
	 * @since  Method available since Release 3.0.0
	 */
	protected function assertAttributeNotContains($needle, $haystackAttributeName, $haystackClassOrObject, $message = '', $ignoreCase = FALSE, $checkForObjectIdentity = TRUE, $checkForNonObjectIdentity = FALSE) {
		return self::fail('@TODO: assertAttributeNotContains compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a haystack that is stored in a static attribute of a class
	 * or an attribute of an object does not contain only values of a given
	 * type.
	 *
	 * @param  string  $type
	 * @param  string  $haystackAttributeName
	 * @param  mixed   $haystackClassOrObject
	 * @param  boolean $isNativeType
	 * @param  string  $message
	 * @since  Method available since Release 3.1.4
	 */
	protected function assertAttributeNotContainsOnly($type, $haystackAttributeName, $haystackClassOrObject, $isNativeType = NULL, $message = '') {
		return self::fail('@TODO: assertAttributeNotContainsOnly compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts the number of elements of an array, Countable or Traversable
	 * that is stored in an attribute.
	 *
	 * @param integer $expectedCount
	 * @param string  $haystackAttributeName
	 * @param mixed   $haystackClassOrObject
	 * @param string  $message
	 * @since Method available since Release 3.6.0
	 */
	protected function assertAttributeNotCount($expectedCount, $haystackAttributeName, $haystackClassOrObject, $message = '') {
		return self::fail('@TODO: assertAttributeNotCount compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a static attribute of a class or an attribute of an object
	 * is not empty.
	 *
	 * @param string $haystackAttributeName
	 * @param mixed  $haystackClassOrObject
	 * @param string $message
	 * @since Method available since Release 3.5.0
	 */
	protected function assertAttributeNotEmpty($haystackAttributeName, $haystackClassOrObject, $message = '') {
		return self::fail('@TODO: assertAttributeNotEmpty compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a variable is not equal to an attribute of an object.
	 *
	 * @param  mixed   $expected
	 * @param  string  $actualAttributeName
	 * @param  string  $actualClassOrObject
	 * @param  string  $message
	 * @param  float   $delta
	 * @param  integer $maxDepth
	 * @param  boolean $canonicalize
	 * @param  boolean $ignoreCase
	 */
	protected function assertAttributeNotEquals($expected, $actualAttributeName, $actualClassOrObject, $message = '', $delta = 0, $maxDepth = 10, $canonicalize = FALSE, $ignoreCase = FALSE) {
		return self::fail('@TODO: assertAttributeNotEquals compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that an attribute is of a given type.
	 *
	 * @param string $expected
	 * @param string $attributeName
	 * @param mixed  $classOrObject
	 * @param string $message
	 * @since Method available since Release 3.5.0
	 */
	protected function assertAttributeNotInstanceOf($expected, $attributeName, $classOrObject, $message = '') {
		return self::fail('@TODO: assertAttributeNotInstanceOf compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that an attribute is of a given type.
	 *
	 * @param string $expected
	 * @param string $attributeName
	 * @param mixed  $classOrObject
	 * @param string $message
	 * @since Method available since Release 3.5.0
	 */
	protected function assertAttributeNotInternalType($expected, $attributeName, $classOrObject, $message = '') {
		return self::fail('@TODO: assertAttributeNotInternalType compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a variable and an attribute of an object do not have the
	 * same type and value.
	 *
	 * @param  mixed  $expected
	 * @param  string $actualAttributeName
	 * @param  object $actualClassOrObject
	 * @param  string $message
	 */
	protected function assertAttributeNotSame($expected, $actualAttributeName, $actualClassOrObject, $message = '') {
		return self::fail('@TODO: assertAttributeNotSame compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a variable and an attribute of an object have the same type
	 * and value.
	 *
	 * @param  mixed  $expected
	 * @param  string $actualAttributeName
	 * @param  object $actualClassOrObject
	 * @param  string $message
	 */
	protected function assertAttributeSame($expected, $actualAttributeName, $actualClassOrObject, $message = '') {
		return self::fail('@TODO: assertAttributeSame compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a class has a specified attribute.
	 *
	 * @param  string $attributeName
	 * @param  string $className
	 * @param  string $message
	 * @since  Method available since Release 3.1.0
	 */
	protected function assertClassHasAttribute($attributeName, $className, $message = '') {
		return self::fail('@TODO: assertClassHasAttribute compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a class has a specified static attribute.
	 *
	 * @param  string $attributeName
	 * @param  string $className
	 * @param  string $message
	 * @since  Method available since Release 3.1.0
	 */
	protected function assertClassHasStaticAttribute($attributeName, $className, $message = '') {
		return self::fail('@TODO: assertClassHasStaticAttribute compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a class does not have a specified attribute.
	 *
	 * @param  string $attributeName
	 * @param  string $className
	 * @param  string $message
	 * @since  Method available since Release 3.1.0
	 */
	protected function assertClassNotHasAttribute($attributeName, $className, $message = '') {
		return self::fail('@TODO: assertClassNotHasAttribute compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a class does not have a specified static attribute.
	 *
	 * @param  string $attributeName
	 * @param  string $className
	 * @param  string $message
	 * @since  Method available since Release 3.1.0
	 */
	protected function assertClassNotHasStaticAttribute($attributeName, $className, $message = '') {
		return self::fail('@TODO: assertClassNotHasStaticAttribute compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a haystack contains a needle.
	 *
	 * @param  mixed   $needle
	 * @param  mixed   $haystack
	 * @param  string  $message
	 * @param  boolean $ignoreCase
	 * @param  boolean $checkForObjectIdentity
	 * @param  boolean $checkForNonObjectIdentity
	 * @since  Method available since Release 2.1.0
	 */
	protected function assertContains($needle, $haystack, $message = '', $ignoreCase = FALSE, $checkForObjectIdentity = TRUE, $checkForNonObjectIdentity = FALSE) {
		return self::fail('@TODO: assertContains compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a haystack contains only values of a given type.
	 *
	 * @param  string  $type
	 * @param  mixed   $haystack
	 * @param  boolean $isNativeType
	 * @param  string  $message
	 * @since  Method available since Release 3.1.4
	 */
	protected function assertContainsOnly($type, $haystack, $isNativeType = NULL, $message = '') {
		return self::fail('@TODO: assertContainsOnly compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a haystack contains only instances of a given classname
	 *
	 * @param string $classname
	 * @param array|Traversable $haystack
	 * @param string $message
	 */
	protected function assertContainsOnlyInstancesOf($classname, $haystack, $message = '') {
		return self::fail('@TODO: assertContainsOnlyInstancesOf compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts the number of elements of an array, Countable or Traversable.
	 *
	 * @param integer $expectedCount
	 * @param mixed   $haystack
	 * @param string  $message
	 */
	protected function assertCount($expectedCount, $haystack, $message = '') {
		return self::assertEqual(count($haystack), $expectedCount, $message);
	}

	/**
	 * Asserts that a variable is empty.
	 *
	 * @param  mixed   $actual
	 * @param  string  $message
	 * @throws PHPUnit_Framework_AssertionFailedError
	 */
	protected function assertEmpty($actual, $message = '') {
		return self::assertTrue(empty($actual), $message);
	}

	/**
	 * Asserts that a hierarchy of DOMElements matches.
	 *
	 * @param DOMElement $expectedElement
	 * @param DOMElement $actualElement
	 * @param boolean $checkAttributes
	 * @param string  $message
	 * @author Mattis Stordalen Flister <mattis@xait.no>
	 * @since  Method available since Release 3.3.0
	 */
	protected function assertEqualXMLStructure(DOMElement $expectedElement, DOMElement $actualElement, $checkAttributes = FALSE, $message = '') {
		return self::fail('@TODO: assertEqualXMLStructure compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that two variables are equal.
	 *
	 * @param  mixed   $expected
	 * @param  mixed   $actual
	 * @param  string  $message
	 * @param  float   $delta
	 * @param  integer $maxDepth
	 * @param  boolean $canonicalize
	 * @param  boolean $ignoreCase
	 */
	protected function assertEquals($expected, $actual, $message = '', $delta = 0, $maxDepth = 10, $canonicalize = FALSE, $ignoreCase = FALSE) {
		return self::assertEqual($actual, $expected, $message);
	}

	/**
	 * Asserts that a condition is false.
	 *
	 * @param  boolean  $condition
	 * @param  string   $message
	 * @throws PHPUnit_Framework_AssertionFailedError
	 */
	public function assertFalse($condition, $message = '') {
		return parent::assertFalse($condition, $message);
	}

	/**
	 * Asserts that the contents of one file is equal to the contents of another
	 * file.
	 *
	 * @param  string  $expected
	 * @param  string  $actual
	 * @param  string  $message
	 * @param  boolean $canonicalize
	 * @param  boolean $ignoreCase
	 * @since  Method available since Release 3.2.14
	 */
	protected function assertFileEquals($expected, $actual, $message = '', $canonicalize = FALSE, $ignoreCase = FALSE) {
		return self::fail('@TODO: assertFileEquals compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a file exists.
	 *
	 * @param  string $filename
	 * @param  string $message
	 * @since  Method available since Release 3.0.0
	 */
	protected function assertFileExists($filename, $message = '') {
		return self::assertTrue(file_exists($filename), $message);
	}

	/**
	 * Asserts that the contents of one file is not equal to the contents of
	 * another file.
	 *
	 * @param  string  $expected
	 * @param  string  $actual
	 * @param  string  $message
	 * @param  boolean $canonicalize
	 * @param  boolean $ignoreCase
	 * @since  Method available since Release 3.2.14
	 */
	protected function assertFileNotEquals($expected, $actual, $message = '', $canonicalize = FALSE, $ignoreCase = FALSE) {
		return self::fail('@TODO: assertFileNotEquals compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a file does not exist.
	 *
	 * @param  string $filename
	 * @param  string $message
	 * @since  Method available since Release 3.0.0
	 */
	protected function assertFileNotExists($filename, $message = '') {
		return self::assertTrue(!file_exists($filename), $message);
	}

	/**
	 * Asserts that a value is greater than another value.
	 *
	 * @param  mixed   $expected
	 * @param  mixed   $actual
	 * @param  string  $message
	 * @since  Method available since Release 3.1.0
	 */
	protected function assertGreaterThan($expected, $actual, $message = '') {
		return self::assertTrue(($actual > $expected), $message);
	}

	/**
	 * Asserts that a value is greater than or equal to another value.
	 *
	 * @param  mixed   $expected
	 * @param  mixed   $actual
	 * @param  string  $message
	 * @since  Method available since Release 3.1.0
	 */
	protected function assertGreaterThanOrEqual($expected, $actual, $message = '') {
		return self::assertTrue(($actual >= $expected), $message);
	}

	/**
	 * Asserts that a variable is of a given type.
	 *
	 * @param string $expected
	 * @param mixed  $actual
	 * @param string $message
	 * @since Method available since Release 3.5.0
	 */
	protected function assertInstanceOf($expected, $actual, $message = '') {
		return self::assertIsA($actual, $expected, $message);
	}

	/**
	 * Asserts that a variable is of a given type.
	 *
	 * @param string $expected
	 * @param mixed  $actual
	 * @param string $message
	 * @since Method available since Release 3.5.0
	 */
	protected function assertInternalType($expected, $actual, $message = '') {
		return self::assertIsA($actual, $expected, $message);
	}

	/**
	 * Asserts that a string is a valid JSON string.
	 *
	 * @param  string $filename
	 * @param  string $message
	 * @since  Method available since Release 3.7.20
	 */
	protected function assertJson($expectedJson, $message = '') {
		return self::fail('@TODO: assertJson compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that two JSON files are equal.
	 *
	 * @param  string $expectedFile
	 * @param  string $actualFile
	 * @param  string $message
	 */
	protected function assertJsonFileEqualsJsonFile($expectedFile, $actualFile, $message = '') {
		return self::fail('@TODO: assertJsonFileEqualsJsonFile compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that two JSON files are not equal.
	 *
	 * @param  string $expectedFile
	 * @param  string $actualFile
	 * @param  string $message
	 */
	protected function assertJsonFileNotEqualsJsonFile($expectedFile, $actualFile, $message = '') {
		return self::fail('@TODO: assertJsonFileNotEqualsJsonFile compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that the generated JSON encoded object and the content of the given file are equal.
	 *
	 * @param string $expectedFile
	 * @param string $actualJson
	 * @param string $message
	 */
	protected function assertJsonStringEqualsJsonFile($expectedFile, $actualJson, $message = '') {
		return self::fail('@TODO: assertJsonStringEqualsJsonFile compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that two given JSON encoded objects or arrays are equal.
	 *
	 * @param string $expectedJson
	 * @param string $actualJson
	 * @param string $message
	 */
	protected function assertJsonStringEqualsJsonString($expectedJson, $actualJson, $message = '') {
		return self::fail('@TODO: assertJsonStringEqualsJsonString compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that the generated JSON encoded object and the content of the given file are not equal.
	 *
	 * @param string $expectedFile
	 * @param string $actualJson
	 * @param string $message
	 */
	protected function assertJsonStringNotEqualsJsonFile($expectedFile, $actualJson, $message = '') {
		return self::fail('@TODO: assertJsonStringNotEqualsJsonFile compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that two given JSON encoded objects or arrays are not equal.
	 *
	 * @param string $expectedJson
	 * @param string $actualJson
	 * @param string $message
	 */
	protected function assertJsonStringNotEqualsJsonString($expectedJson, $actualJson, $message = '') {
		return self::fail('@TODO: assertJsonStringNotEqualsJsonString compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a value is smaller than another value.
	 *
	 * @param  mixed   $expected
	 * @param  mixed   $actual
	 * @param  string  $message
	 * @since  Method available since Release 3.1.0
	 */
	protected function assertLessThan($expected, $actual, $message = '') {
		return self::assertTrue(($actual < $expected), $message);
	}

	/**
	 * Asserts that a value is smaller than or equal to another value.
	 *
	 * @param  mixed   $expected
	 * @param  mixed   $actual
	 * @param  string  $message
	 * @since  Method available since Release 3.1.0
	 */
	protected function assertLessThanOrEqual($expected, $actual, $message = '') {
		return self::assertTrue(($actual <= $expected), $message);
	}

	/**
	 * Asserts that a haystack does not contain a needle.
	 *
	 * @param  mixed   $needle
	 * @param  mixed   $haystack
	 * @param  string  $message
	 * @param  boolean $ignoreCase
	 * @param  boolean $checkForObjectIdentity
	 * @param  boolean $checkForNonObjectIdentity
	 * @since  Method available since Release 2.1.0
	 */
	protected function assertNotContains($needle, $haystack, $message = '', $ignoreCase = FALSE, $checkForObjectIdentity = TRUE, $checkForNonObjectIdentity = FALSE) {
		return self::fail('@TODO: assertNotContains compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a haystack does not contain only values of a given type.
	 *
	 * @param  string  $type
	 * @param  mixed   $haystack
	 * @param  boolean $isNativeType
	 * @param  string  $message
	 * @since  Method available since Release 3.1.4
	 */
	protected function assertNotContainsOnly($type, $haystack, $isNativeType = NULL, $message = '') {
		return self::fail('@TODO: assertNotContainsOnly compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts the number of elements of an array, Countable or Traversable.
	 *
	 * @param integer $expectedCount
	 * @param mixed   $haystack
	 * @param string  $message
	 */
	protected function assertNotCount($expectedCount, $haystack, $message = '') {
		return self::assertNotEqual(count($haystack), $expectedCount, $message);
	}

	/**
	 * Asserts that a variable is not empty.
	 *
	 * @param  mixed   $actual
	 * @param  string  $message
	 * @throws PHPUnit_Framework_AssertionFailedError
	 */
	protected function assertNotEmpty($actual, $message = '') {
		return self::assertTrue(!empty($actual), $message);
	}

	/**
	 * Asserts that two variables are not equal.
	 *
	 * @param  mixed   $expected
	 * @param  mixed   $actual
	 * @param  string  $message
	 * @param  float   $delta
	 * @param  integer $maxDepth
	 * @param  boolean $canonicalize
	 * @param  boolean $ignoreCase
	 * @since  Method available since Release 2.3.0
	 */
	protected function assertNotEquals($expected, $actual, $message = '', $delta = 0, $maxDepth = 10, $canonicalize = FALSE, $ignoreCase = FALSE) {
		return self::assertNotEqual($actual, $expected, $message);
	}

	/**
	 * Asserts that a variable is not of a given type.
	 *
	 * @param string $expected
	 * @param mixed  $actual
	 * @param string $message
	 * @since Method available since Release 3.5.0
	 */
	protected function assertNotInstanceOf($expected, $actual, $message = '') {
		return self::assertNotA($actual, $expected, $message);
	}

	/**
	 * Asserts that a variable is not of a given type.
	 *
	 * @param string $expected
	 * @param mixed  $actual
	 * @param string $message
	 * @since Method available since Release 3.5.0
	 */
	protected function assertNotInternalType($expected, $actual, $message = '') {
		return self::assertNotA($actual, $expected, $message);
	}

	/**
	 * Asserts that a variable is not NULL.
	 *
	 * @param  mixed  $actual
	 * @param  string $message
	 */
	public function assertNotNull($actual, $message = '') {
		return parent::assertNotNull($actual, $message);
	}

	/**
	 * Asserts that a string does not match a given regular expression.
	 *
	 * @param  string $pattern
	 * @param  string $string
	 * @param  string $message
	 * @since  Method available since Release 2.1.0
	 */
	protected function assertNotRegExp($pattern, $string, $message = '') {
		return self::assertNoPattern($pattern, $string, $message);
	}

	/**
	 * Asserts that two variables do not have the same type and value.
	 * Used on objects, it asserts that two variables do not reference
	 * the same object.
	 *
	 * @param  mixed  $expected
	 * @param  mixed  $actual
	 * @param  string $message
	 */
	protected function assertNotSame($expected, $actual, $message = '') {
		return self::assertNotIdentical($actual, $expected, $message);
	}

	/**
	 * Assert that the size of two arrays (or `Countable` or `Traversable` objects)
	 * is not the same.
	 *
	 * @param array|Countable|Traversable $expected
	 * @param array|Countable|Traversable $actual
	 * @param string $message
	 */
	protected function assertNotSameSize($expected, $actual, $message = '') {
		return self::assertNotEqual(count($actual), count($expected), $message);
	}

	/**
	 * This assertion is the exact opposite of assertTag().
	 *
	 * Rather than asserting that $matcher results in a match, it asserts that
	 * $matcher does not match.
	 *
	 * @param  array   $matcher
	 * @param  string  $actual
	 * @param  string  $message
	 * @param  boolean $isHtml
	 * @since  Method available since Release 3.3.0
	 * @author Mike Naberezny <mike@maintainable.com>
	 * @author Derek DeVries <derek@maintainable.com>
	 */
	protected function assertNotTag($matcher, $actual, $message = '', $isHtml = TRUE) {
		return self::fail('@TODO: assertNotTag compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a variable is NULL.
	 *
	 * @param  mixed  $actual
	 * @param  string $message
	 */
	public function assertNull($actual, $message = '') {
		return parent::assertNull($actual, $message);
	}

	/**
	 * Asserts that an object has a specified attribute.
	 *
	 * @param  string $attributeName
	 * @param  object $object
	 * @param  string $message
	 * @since  Method available since Release 3.0.0
	 */
	protected function assertObjectHasAttribute($attributeName, $object, $message = '') {
		return self::fail('@TODO: assertObjectHasAttribute compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that an object does not have a specified attribute.
	 *
	 * @param  string $attributeName
	 * @param  object $object
	 * @param  string $message
	 * @since  Method available since Release 3.0.0
	 */
	protected function assertObjectNotHasAttribute($attributeName, $object, $message = '') {
		return self::fail('@TODO: assertObjectNotHasAttribute compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a string matches a given regular expression.
	 *
	 * @param  string $pattern
	 * @param  string $string
	 * @param  string $message
	 */
	protected function assertRegExp($pattern, $string, $message = '') {
		return self::assertPattern($pattern, $string, $message);
	}

	/**
	 * Asserts that two variables have the same type and value.
	 * Used on objects, it asserts that two variables reference
	 * the same object.
	 *
	 * @param  mixed  $expected
	 * @param  mixed  $actual
	 * @param  string $message
	 */
	protected function assertSame($expected, $actual, $message = '') {
		return self::assertIdentical($actual, $expected, $message);
	}

	/**
	 * Assert that the size of two arrays (or `Countable` or `Traversable` objects)
	 * is the same.
	 *
	 * @param array|Countable|Traversable $expected
	 * @param array|Countable|Traversable $actual
	 * @param string $message
	 */
	protected function assertSameSize($expected, $actual, $message = '') {
		return self::assertEqual(count($actual), count($expected), $message);
	}

	/**
	 * Assert the presence, absence, or count of elements in a document matching
	 * the CSS $selector, regardless of the contents of those elements.
	 *
	 * The first argument, $selector, is the CSS selector used to match
	 * the elements in the $actual document.
	 *
	 * The second argument, $count, can be either boolean or numeric.
	 * When boolean, it asserts for presence of elements matching the selector
	 * (TRUE) or absence of elements (FALSE).
	 * When numeric, it asserts the count of elements.
	 *
	 * assertSelectCount("#binder", true, $xml);  // any?
	 * assertSelectCount(".binder", 3, $xml); // exactly 3?
	 *
	 * @param  array   $selector
	 * @param  integer $count
	 * @param  mixed   $actual
	 * @param  string  $message
	 * @param  boolean $isHtml
	 * @since  Method available since Release 3.3.0
	 * @author Mike Naberezny <mike@maintainable.com>
	 * @author Derek DeVries <derek@maintainable.com>
	 */
	protected function assertSelectCount($selector, $count, $actual, $message = '', $isHtml = TRUE) {
		return self::fail('@TODO: assertSelectCount compatibility method is not implemented. ' . $message);
	}

	/**
	 * assertSelectEquals("#binder .name", "Chuck", true,  $xml);  // any?
	 * assertSelectEquals("#binder .name", "Chuck", false, $xml);  // none?
	 *
	 * @param  array   $selector
	 * @param  string  $content
	 * @param  integer $count
	 * @param  mixed   $actual
	 * @param  string  $message
	 * @param  boolean $isHtml
	 * @since  Method available since Release 3.3.0
	 * @author Mike Naberezny <mike@maintainable.com>
	 * @author Derek DeVries <derek@maintainable.com>
	 */
	protected function assertSelectEquals($selector, $content, $count, $actual, $message = '', $isHtml = TRUE) {
		return self::fail('@TODO: assertSelectEquals compatibility method is not implemented. ' . $message);
	}

	/**
	 * assertSelectRegExp("#binder .name", "/Mike|Derek/", true, $xml); // any?
	 * assertSelectRegExp("#binder .name", "/Mike|Derek/", 3, $xml);// 3?
	 *
	 * @param  array   $selector
	 * @param  string  $pattern
	 * @param  integer $count
	 * @param  mixed   $actual
	 * @param  string  $message
	 * @param  boolean $isHtml
	 * @since  Method available since Release 3.3.0
	 * @author Mike Naberezny <mike@maintainable.com>
	 * @author Derek DeVries <derek@maintainable.com>
	 */
	protected function assertSelectRegExp($selector, $pattern, $count, $actual, $message = '', $isHtml = TRUE) {
		return self::fail('@TODO: assertSelectRegExp compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a string ends not with a given prefix.
	 *
	 * @param  string $suffix
	 * @param  string $string
	 * @param  string $message
	 * @since  Method available since Release 3.4.0
	 */
	protected function assertStringEndsNotWith($suffix, $string, $message = '') {
		return self::fail('@TODO: assertStringEndsNotWith compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a string ends with a given prefix.
	 *
	 * @param  string $suffix
	 * @param  string $string
	 * @param  string $message
	 * @since  Method available since Release 3.4.0
	 */
	protected function assertStringEndsWith($suffix, $string, $message = '') {
		return self::fail('@TODO: assertStringEndsWith compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that the contents of a string is equal
	 * to the contents of a file.
	 *
	 * @param  string  $expectedFile
	 * @param  string  $actualString
	 * @param  string  $message
	 * @param  boolean $canonicalize
	 * @param  boolean $ignoreCase
	 * @since  Method available since Release 3.3.0
	 */
	protected function assertStringEqualsFile($expectedFile, $actualString, $message = '', $canonicalize = FALSE, $ignoreCase = FALSE) {
		return self::fail('@TODO: assertStringEqualsFile compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a string matches a given format string.
	 *
	 * @param  string $format
	 * @param  string $string
	 * @param  string $message
	 * @since  Method available since Release 3.5.0
	 */
	protected function assertStringMatchesFormat($format, $string, $message = '') {
		return self::fail('@TODO: assertStringMatchesFormat compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a string matches a given format file.
	 *
	 * @param  string $formatFile
	 * @param  string $string
	 * @param  string $message
	 * @since  Method available since Release 3.5.0
	 */
	protected function assertStringMatchesFormatFile($formatFile, $string, $message = '') {
		return self::fail('@TODO: assertStringMatchesFormatFile compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that the contents of a string is not equal
	 * to the contents of a file.
	 *
	 * @param  string  $expectedFile
	 * @param  string  $actualString
	 * @param  string  $message
	 * @param  boolean $canonicalize
	 * @param  boolean $ignoreCase
	 * @since  Method available since Release 3.3.0
	 */
	protected function assertStringNotEqualsFile($expectedFile, $actualString, $message = '', $canonicalize = FALSE, $ignoreCase = FALSE) {
		return self::fail('@TODO: assertStringNotEqualsFile compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a string does not match a given format string.
	 *
	 * @param  string $format
	 * @param  string $string
	 * @param  string $message
	 * @since  Method available since Release 3.5.0
	 */
	protected function assertStringNotMatchesFormat($format, $string, $message = '') {
		return self::fail('@TODO: assertStringNotMatchesFormat compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a string does not match a given format string.
	 *
	 * @param  string $formatFile
	 * @param  string $string
	 * @param  string $message
	 * @since  Method available since Release 3.5.0
	 */
	protected function assertStringNotMatchesFormatFile($formatFile, $string, $message = '') {
		return self::fail('@TODO: assertStringNotMatchesFormatFile compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a string starts not with a given prefix.
	 *
	 * @param  string $prefix
	 * @param  string $string
	 * @param  string $message
	 * @since  Method available since Release 3.4.0
	 */
	protected function assertStringStartsNotWith($prefix, $string, $message = '') {
		return self::fail('@TODO: assertStringStartsNotWith compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a string starts with a given prefix.
	 *
	 * @param  string $prefix
	 * @param  string $string
	 * @param  string $message
	 * @since  Method available since Release 3.4.0
	 */
	protected function assertStringStartsWith($prefix, $string, $message = '') {
		return self::fail('@TODO: assertStringStartsWith compatibility method is not implemented. ' . $message);
	}

	/**
	 * Evaluate an HTML or XML string and assert its structure and/or contents.
	 *
	 * The first argument ($matcher) is an associative array that specifies the
	 * match criteria for the assertion:
	 *
	 *  - `id`   : the node with the given id attribute must match the
	 * corresponsing value.
	 *  - `tag`  : the node type must match the corresponding value.
	 *  - `attributes`   : a hash. The node's attributres must match the
	 * corresponsing values in the hash.
	 *  - `content`  : The text content must match the given value.
	 *  - `parent`   : a hash. The node's parent must match the
	 * corresponsing hash.
	 *  - `child`: a hash. At least one of the node's immediate children
	 * must meet the criteria described by the hash.
	 *  - `ancestor` : a hash. At least one of the node's ancestors must
	 * meet the criteria described by the hash.
	 *  - `descendant`   : a hash. At least one of the node's descendants must
	 * meet the criteria described by the hash.
	 *  - `children` : a hash, for counting children of a node.
	 * Accepts the keys:
	 *- `count`: a number which must equal the number of children
	 *   that match
	 *- `less_than`: the number of matching children must be greater
	 *   than this number
	 *- `greater_than` : the number of matching children must be less than
	 *   this number
	 *- `only` : another hash consisting of the keys to use to match
	 *   on the children, and only matching children will be
	 *   counted
	 *
	 * <code>
	 * // Matcher that asserts that there is an element with an id="my_id".
	 * $matcher = array('id' => 'my_id');
	 *
	 * // Matcher that asserts that there is a "span" tag.
	 * $matcher = array('tag' => 'span');
	 *
	 * // Matcher that asserts that there is a "span" tag with the content
	 * // "Hello World".
	 * $matcher = array('tag' => 'span', 'content' => 'Hello World');
	 *
	 * // Matcher that asserts that there is a "span" tag with content matching
	 * // the regular expression pattern.
	 * $matcher = array('tag' => 'span', 'content' => 'regexp:/Try P(HP|ython)/');
	 *
	 * // Matcher that asserts that there is a "span" with an "list" class
	 * // attribute.
	 * $matcher = array(
	 *   'tag'=> 'span',
	 *   'attributes' => array('class' => 'list')
	 * );
	 *
	 * // Matcher that asserts that there is a "span" inside of a "div".
	 * $matcher = array(
	 *   'tag'=> 'span',
	 *   'parent' => array('tag' => 'div')
	 * );
	 *
	 * // Matcher that asserts that there is a "span" somewhere inside a
	 * // "table".
	 * $matcher = array(
	 *   'tag'  => 'span',
	 *   'ancestor' => array('tag' => 'table')
	 * );
	 *
	 * // Matcher that asserts that there is a "span" with at least one "em"
	 * // child.
	 * $matcher = array(
	 *   'tag'   => 'span',
	 *   'child' => array('tag' => 'em')
	 * );
	 *
	 * // Matcher that asserts that there is a "span" containing a (possibly
	 * // nested) "strong" tag.
	 * $matcher = array(
	 *   'tag'=> 'span',
	 *   'descendant' => array('tag' => 'strong')
	 * );
	 *
	 * // Matcher that asserts that there is a "span" containing 5-10 "em" tags
	 * // as immediate children.
	 * $matcher = array(
	 *   'tag'  => 'span',
	 *   'children' => array(
	 * 'less_than'=> 11,
	 * 'greater_than' => 4,
	 * 'only' => array('tag' => 'em')
	 *   )
	 * );
	 *
	 * // Matcher that asserts that there is a "div", with an "ul" ancestor and
	 * // a "li" parent (with class="enum"), and containing a "span" descendant
	 * // that contains an element with id="my_test" and the text "Hello World".
	 * $matcher = array(
	 *   'tag'=> 'div',
	 *   'ancestor'   => array('tag' => 'ul'),
	 *   'parent' => array(
	 * 'tag'=> 'li',
	 * 'attributes' => array('class' => 'enum')
	 *   ),
	 *   'descendant' => array(
	 * 'tag'   => 'span',
	 * 'child' => array(
	 *   'id'  => 'my_test',
	 *   'content' => 'Hello World'
	 * )
	 *   )
	 * );
	 *
	 * // Use assertTag() to apply a $matcher to a piece of $html.
	 * $this->assertTag($matcher, $html);
	 *
	 * // Use assertTag() to apply a $matcher to a piece of $xml.
	 * $this->assertTag($matcher, $xml, '', FALSE);
	 * </code>
	 *
	 * The second argument ($actual) is a string containing either HTML or
	 * XML text to be tested.
	 *
	 * The third argument ($message) is an optional message that will be
	 * used if the assertion fails.
	 *
	 * The fourth argument ($html) is an optional flag specifying whether
	 * to load the $actual string into a DOMDocument using the HTML or
	 * XML load strategy.  It is TRUE by default, which assumes the HTML
	 * load strategy.  In many cases, this will be acceptable for XML as well.
	 *
	 * @param  array   $matcher
	 * @param  string  $actual
	 * @param  string  $message
	 * @param  boolean $isHtml
	 * @since  Method available since Release 3.3.0
	 * @author Mike Naberezny <mike@maintainable.com>
	 * @author Derek DeVries <derek@maintainable.com>
	 */
	protected function assertTag($matcher, $actual, $message = '', $isHtml = TRUE) {
		return self::fail('@TODO: assertTag compatibility method is not implemented. ' . $message);
	}

	/**
	 * Evaluates a PHPUnit_Framework_Constraint matcher object.
	 *
	 * @param  mixed$value
	 * @param  PHPUnit_Framework_Constraint $constraint
	 * @param  string   $message
	 * @since  Method available since Release 3.0.0
	 */
	protected function assertThat($value, PHPUnit_Framework_Constraint $constraint, $message = '') {
		return self::fail('@TODO: assertThat compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that a condition is true.
	 *
	 * @param  boolean $condition
	 * @param  string  $message
	 * @throws PHPUnit_Framework_AssertionFailedError
	 */
	public function assertTrue($condition, $message = '') {
		return parent::assertTrue($condition, $message);
	}

	/**
	 * Asserts that two XML files are equal.
	 *
	 * @param  string $expectedFile
	 * @param  string $actualFile
	 * @param  string $message
	 * @since  Method available since Release 3.1.0
	 */
	protected function assertXmlFileEqualsXmlFile($expectedFile, $actualFile, $message = '') {
		return self::fail('@TODO: assertXmlFileEqualsXmlFile compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that two XML files are not equal.
	 *
	 * @param  string $expectedFile
	 * @param  string $actualFile
	 * @param  string $message
	 * @since  Method available since Release 3.1.0
	 */
	protected function assertXmlFileNotEqualsXmlFile($expectedFile, $actualFile, $message = '') {
		return self::fail('@TODO: assertXmlFileNotEqualsXmlFile compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that two XML documents are equal.
	 *
	 * @param  string $expectedFile
	 * @param  string $actualXml
	 * @param  string $message
	 * @since  Method available since Release 3.3.0
	 */
	protected function assertXmlStringEqualsXmlFile($expectedFile, $actualXml, $message = '') {
		return self::fail('@TODO: assertXmlStringEqualsXmlFile compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that two XML documents are equal.
	 *
	 * @param  string $expectedXml
	 * @param  string $actualXml
	 * @param  string $message
	 * @since  Method available since Release 3.1.0
	 */
	protected function assertXmlStringEqualsXmlString($expectedXml, $actualXml, $message = '') {
		return self::fail('@TODO: assertXmlStringEqualsXmlString compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that two XML documents are not equal.
	 *
	 * @param  string $expectedFile
	 * @param  string $actualXml
	 * @param  string $message
	 * @since  Method available since Release 3.3.0
	 */
	protected function assertXmlStringNotEqualsXmlFile($expectedFile, $actualXml, $message = '') {
		return self::fail('@TODO: assertXmlStringNotEqualsXmlFile compatibility method is not implemented. ' . $message);
	}

	/**
	 * Asserts that two XML documents are not equal.
	 *
	 * @param  string $expectedXml
	 * @param  string $actualXml
	 * @param  string $message
	 * @since  Method available since Release 3.1.0
	 */
	protected function assertXmlStringNotEqualsXmlString($expectedXml, $actualXml, $message = '') {
		return self::fail('@TODO: assertXmlStringNotEqualsXmlString compatibility method is not implemented. ' . $message);
	}
}
Here's a typical (and contrived) Cake 1.3 test case:

	<?php
	App::import('Model', 'MyModel');
	Mock::generate('MyModel');
	
	/**
	 * MyModel Test Case
	 */
	class MyModelTest extends CakeTestCase {
		public function testSomeMethod() {
			$mockedMyModel = new MockMyModel();
			$mockedMyModel->returns('someMethod', 'arg1', 'expected');

			$this->assertEqual($mockedMyModel->someMethod('arg1'), 'expected');
		}
	}

And here's the same test case using the FutureCakeTestCase class.

	<?php
	App::import('Lib', 'FutureCakeTestCase.FutureCakeTestCase');
	App::import('Model', 'MyModel');
	
	/**
	 * MyModel Test Case
	 */
	class MyModelTest extends FutureCakeTestCase {
		public function testSomeMethod() {
			$mockedMyModel = Mockery::mock('MyModel');
			$mockedMyModel->shouldReceive('someMethod')
				->with('arg1')
				->once()
				->andReturn('expected');

			$this->assertEquals('expected', $mockedMyModel->someMethod('arg1'));
		}
	}

The differences are:

* Using `App::import()` to load the custom test case class.
* Extending the test class from the custom test case.
* Mocking the object using Mockery instead of SimpleTest.
* Using a PHPUnit-style `assertEquals` assertion instead of SimpleTest's `assertEqual`.
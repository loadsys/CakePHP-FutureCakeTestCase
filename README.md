CakePHP-FutureCakeTestCase
==========================

This is a CakePHP **v1.3** plugin that is designed to allow you to write unit tests that will be more compatible with Cake 2.0 and PHPUnit. It does this by providing a subclass to the `CakeTestCase` class that exists in Cake 1.3. This subclass translates PHPUnit-style assertions like `$this->assertEquals('expected', $actual)` into SimpleTest-style assertions (`$this->assertEqual($actual, 'expected')`). In addition to this, the subclass pulls in support for the Mockery mocking framework, which works independently of both SimpleTest and PHPUnit.

The benefit to this is that the tests you write for your 1.3 project will be much more compatible with the testing framework that CakePHP v2.x uses. This eases the Cake version upgrade process considerably by making your test suite more reliable right when you need it most, and allowing you to focus on repairing your application code and not the tests themselves.

Here's another way to look at this: Cake v2.0 has backwards compatibility built into it that allows the "old style" `assertEqual()` methods to continue to work by mapping them to the "new" PHPUnit equivalents for you. (But this compatibility is only available in 2.0 and 2.1, so you still have to fix all of your tests eventually.) This plugin lets you do the opposite _before_ you upgrade. Hopefully this reduces the number of excuses for not having a full test suite written for your 1.3 Cake application.

### Caveats

* This plugin is most beneficial if you don't already have a large SimpleTest-based testsuite. The main purpose is to reduce the friction for _starting_ to write tests on a Cake 1.3 project by providing a way to make those tests more reliable after the Cake version upgrade to 2.0. If you already have an extensive SimpleTest suite, you can't get around repairing your tests to use PHPUnit syntax, so all this plugin offers in that case is the option to do it preemptively before the 2.0 upgrade.
* Since PHPUnit is much more advanced than SimpleTest, not all of PHPUnit's assertions are translated in the `FutureCakeTestCase` class. Doing so would require reimplementing a lot of PHPUnit's core functionality, which is a bad idea. With that in mind, if you try to use an assertion that isn't implemented the assertion will straight up fail. We're shooting for the 80/20 rule here, so all of the most common and generic assertions are mapped. (Feel free to submit pull requests for additional assertion mapping though.)
* After you eventually upgrade your 1.3 project to 2.x, your mocks will be in Mockery syntax instead of unified in PHPUnit, so it will continue to be a dependency. Mockery plays very nicely with PHPUnit though, so this isn't the absolute end of the world.

## Requirements

* PHP v5.3+
* [CakePHP v1.3](https://github.com/cakephp/cakephp/tree/1.3) **not 2.x compatible**. (That's the whole point after all.)
* [SimpleTest](http://www.simpletest.org/)
* [Mockery](https://github.com/padraic/mockery#mockery)

The [xdebug](http://xdebug.org) PHP extension isn't strictly required, but is probably a good idea to have anyway.


## Installation

* [Install Mockery](https://github.com/padraic/mockery#installation).
* Clone or submodule this repo as a plugin in your Cake 1.3 application's `plugins` folders:
		cd yourcakeproject/app/
		
		git clone https://github.com/loadsys/CakePHP-FutureCakeTestCase.git plugins/future_case_test_case
		# Or as a submodule:
		git submodule add https://github.com/loadsys/CakePHP-FutureCakeTestCase.git plugins/future_case_test_case


## Usage

* In your test files, add `App::import('Lib', 'FutureCakeTestCase.FutureCakeTestCase');` at the top.

* Change your test class definition from `MyTest extends CakeTestCase` to `MyTest extends FutureCakeTestCase`. Here's an example:
		<?php
		App::import('Lib', 'FutureCakeTestCase.FutureCakeTestCase');

		/**
		 * MyController Test Case
		 */
		class MyControllerTest extends FutureCakeTestCase {
			// (tests go here)
		}

* Use PHPUnit-syntax for [assertions](), [skipped and incomplete tests](), and [setUp/tearDown()]().

* [Create mocks using Mockery](https://github.com/padraic/mockery#simple-example) instead of SimpleTest. For example:
		testFoo() {
			$mockedMyClass = Mockery::mock('MyClass');
			$mockedMyClass->shouldReceive('foo')
				->with(5, m::any())
				->once()
				->andReturn(10);
			$this->assertEquals(10, $mockedMyClass->foo(5));
		}

* Run your tests like normal: `cake/console/cake testsuite app all`

* The `FutureCakeTestCase` class already includes a `::tearDown()` function that will call `Mockery::close()` for you. If you define your own tearDown methods, be sure to always call `parent::tearDown()` from it.


## Support

Create a GitHub [issue](https://github.com/loadsys/CakePHP-FutureCakeTestCase/issues). 

## Contributing

Please create a pull request for specific bug fixes or features.

## License

[MIT](https://github.com/loadsys/CakePHP-FutureCakeTestCase/blob/master/LICENSE)

## Copyright ##

[Loadsys Web Strategies](http://www.loadsys.com) 2014

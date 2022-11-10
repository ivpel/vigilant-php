# Vigilant

## This repo is archived. Now Vigilant project is here  [Vigilant kit](https://github.com/ivpel/vigilant-kit) 
You can fork it and do whatever you want:)


Minimalistic framework for functional/regression testing.

`php-webdriver` and `phpunit` bundled together, with some additional to make functional testing fast and easy.

**phpunit** - is main entrypoint for your tests to run and configure them.

**Vigilant** just provide additional methods to help with functional testing.
You still have all features which `phpunit` has (create new extensions, write hooks, implement listeners, etc.)
but with additional assertions (see, dontSee, seeCookie, etc.) and methods for interacting with web page (click, fillField,
scrollTo, etc.,).

## Install
```shell
composer require ivpel/vigilant
```

## Create first test
It will be good, if you are familiar with PHPUnit framework, if not - 
it is still ok.

Create file `VigilantTest.php` (or you can choose another name, but make sure to follow this 
pattern `{name}Test.php`) inside `tests/` directory.
```php
<?php

use Vigilant\WebDriver\RemoteWebDriver;
use Vigilant\Traits\InteractionTrait;

class VigilantTest extends \PHPUnit\Framework\TestCase
{
    use InteractionTrait;
    
    public function setUp(): void
    {
        # Starting browser session on our Selenium server
        $this->driver = RemoteWebDriver::createNewSession();
    }

    public function testFirstVigilantExample()
    {
        # Go to page https://phpunit.de/ 
        $this->get('https://phpunit.de/');
        
        # Assert that we don't see word Vigilant in page title
        $this->assertDontSeeInTitle('Vigilant');
        
        # Assert that we see tag h1 with text Welcome to PHPUnit
        $this->assertSee('//h1[text()="Welcome to PHPUnit!"]');

        # Clicking on button with selector '//a[@class="btn btn-start"]'
        $this->click('//a[@class="btn btn-start"]');
        
        # Asserting that we see in URI /getting-started/ 
        $this->assertSeeInUrl('/getting-started/');
    }

    public function tearDown(): void
    {
        # Close browser session after test completed
        $this->driver->close();
    }
}

```

### Run tests using `phpunit.xml.dist` configuration
You need to have Selenium server up and running.

In order to run the tests, we need to declare the environment variables that are used to run the tests. Let's do it through a 
`phpunit.xml.dist` file, which is the native way for the `PHPUnit` framework.
We will use the following variables:

**BASE_URL** - URL which will be used as base for all get() methods (you can leave it empty for this test).

**BROWSER** - browser you used in your selenium server.

**SELENIUM_HOST** - address of your selenium server.

**WAIT_TIMEOUT** - timeout for interactions before throwing error.
```shell
<?xml version="1.0" encoding="UTF-8"?>
<phpunit backupGlobals="false"
    <php>
        <!-- Environment variables -->
        <env name="BASE_URL" value=""/>
        <env name="BROWSER" value="CHROME"/>
        <env name="SELENIUM_HOST" value="http://127.0.0.1:4444/wd/hub"/> <!-- Add your selenium host address here -->
        <env name="WAIT_TIMEOUT" value="5"/>
    </php>
</phpunit>
```

Execute next command:
```shell
vendor/bin/phpunit tests/VigilantTest.php
```
If you configure your variables correctly you have to see next output:
```shell
PHPUnit 9.5.21 #StandWithUkraine

.                                                                   1 / 1 (100%)

Time: 00:01.821, Memory: 6.00 MB

OK (1 test, 3 assertions)

```
**Nice!**

### How `get()` method works when you add value to BASE_URL env?

If you configure as `<env name="BASE_URL" value="https://phpunit.de/"/>` then
method `get("/")` will provide you to this address https://phpunit.de/

If you need specific path - just add path as argument to `get()` method, it will concatenate them and provide you full path.

`$this->get("/documentation.html")` will return you this page `https://phpunit.de/documentation.html`

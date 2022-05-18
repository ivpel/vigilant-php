<?php

namespace Vigilant\WebDriver;

use Vigilant\Traits\InteractionTrait;
use Vigilant\Traits\LoggerTrait;

/**
 * Class Actions should be used when you need to use not-static method of trait InteractionTrait inside static methods
 * such as setUpBeforeClass().
 * Example of usage:
 *
 *     public static function setUpBeforeClass(): void
        {
            $driver = Driver::create();
            self::$actions = new Actions($driver);
            self::$actions->maximizeWindow();
        }
 * Now we have access to non-static from InteractionTrait inside static method.
 * @package Vigilant\WebDriver
 */
class Actions
{
    use InteractionTrait;
    use LoggerTrait;

    public function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;
    }
}

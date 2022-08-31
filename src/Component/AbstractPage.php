<?php

namespace Vigilant\Component;

use Vigilant\Traits\InteractionTrait;
use Vigilant\WebDriver\RemoteWebDriver;

class AbstractPage
{
    use InteractionTrait;

    /**
     * @var RemoteWebDriver
     */
    public RemoteWebDriver $driver;

    public function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;
    }
}
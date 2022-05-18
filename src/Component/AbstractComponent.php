<?php

namespace Vigilant\Component;

use Vigilant\WebDriver\RemoteWebDriver;
use Vigilant\Traits\InteractionTrait;

class AbstractComponent
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

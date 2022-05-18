<?php

namespace Vigilant\Traits;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverDimension;

/**
 * Trait BrowserTrait
 * @package Vigilant\Traits
 * @property RemoteWebDriver $driver
 */
trait BrowserTrait
{
    private function getBaseUrl()
    {
        return getenv('BASE_URL');
    }

    /**
     * Load a new web page in the current browser window.
     * Page address is building next way:
     * taking $baseUrl from environment variables (BASE_URL) and concatenate it with $pageUrl argument.
     *
     * @param string $pageUrl
     * @return AssertionsTrait|BrowserTrait|InteractionTrait
     */
    public function get(string $pageUrl): self
    {
        $this->log('Going to page %s', $pageUrl);
        $this->driver->get($this->getBaseUrl() . $pageUrl);
        return $this;
    }

    /**
     * Close active Driver session.
     */
    public function quit(): self
    {
        $this->log('Closing browser session');
        $this->driver->quit();
        return $this;
    }

    /**
     * Moves back in session history.
     * @return AssertionsTrait|BrowserTrait|InteractionTrait
     */
    public function pageBack(): self
    {
        $this->driver->navigate()->back();
        return $this;
    }

    /**
     * Moves forward in session history.
     * @return AssertionsTrait|BrowserTrait|InteractionTrait
     */
    public function pageForward(): self
    {
        $this->driver->navigate()->forward();
        return $this;
    }

    /**
     * Reloads current page.
     * @return AssertionsTrait|BrowserTrait|InteractionTrait
     */
    public function pageRefresh(): self
    {
        $this->driver->navigate()->refresh();
        return $this;
    }

    /**
     * Return current page title.
     *
     * @return string|null
     */
    public function pageTitle(): ?string
    {
        return $this->driver->getTitle();
    }

    /**
     * Make screenshot of current active tab.
     *
     * @param $name
     * @return AssertionsTrait|BrowserTrait|InteractionTrait
     */
    public function makeScreenshot($name): self
    {
        $this->driver->takeScreenshot($name);
        return $this;
    }

    /**
     * Maximize browser window resolution.
     *
     */
    public function maximizeWindow(): self
    {
        $this->log('Maximizing window resolution');
        $this->driver->manage()->window()->maximize();
        return $this;
    }

    /**
     * Resize current window according to provided width and height.
     *
     * @param $width
     * @param $height
     * @return AssertionsTrait|BrowserTrait|InteractionTrait
     */
    public function resizeWindow($width, $height): self
    {
        $this->log('Resizing window resolution to width: %s, height %s', $width, $height);
        $this->driver->manage()->window()->setSize(new WebDriverDimension($width, $height));
        return $this;
    }

    /**
     * Execute provided JavaScript code. Script arguments by default are null.
     *
     * @param string $jsScript
     * @param $scriptArguments
     * @return BrowserTrait
     */
    public function executeScript(string $jsScript, $scriptArguments = null)
    {
        $this->log(
            'Executing JS script:
                %s', $jsScript);
        $this->driver->executeScript($jsScript, $scriptArguments);
        return $this;
    }

    /**
     * Delete all cookies from current session.
     * @return AssertionsTrait|BrowserTrait|InteractionTrait
     */
    public function deleteAllCookies(): self
    {
        $this->log('Deleting all cookies');
        $this->driver->manage()->deleteAllCookies();
        return $this;
    }

    /**
     * Delete specific cookie from current session.
     * @param string $cookieName
     * @return AssertionsTrait|BrowserTrait|InteractionTrait
     */
    public function deleteCookie(string $cookieName): self
    {
        $this->log('Deleting cookie %s', $cookieName);
        $this->driver->manage()->deleteCookieNamed($cookieName);
        return $this;
    }

    /**
     * Set cookie for active session.
     * @param string $cookieName
     * @param string $cookieValue
     * @return AssertionsTrait|BrowserTrait|InteractionTrait
     */
    public function setCookie(string $cookieName, string $cookieValue): self
    {
        $this->log('Setting cookie [%s] with value [%s]', $cookieName, $cookieValue);
        $this->driver->manage()->addCookie(['name' => $cookieName, 'value' => $cookieValue]);
        return $this;
    }

    /**
     * Grab all cookies from active session.
     * @return AssertionsTrait|BrowserTrait|InteractionTrait
     */
    public function getAllCookies(): self
    {
        $this->driver->manage()->getCookies();
        return $this;
    }

    /**
     * Switch to frame located by ID
     * @param $frameID
     * @return AssertionsTrait|BrowserTrait|InteractionTrait $self
     */
    public function switchToFrame($frameID): self
    {
        $this->log('Switching to frame %s', $frameID);
        $this->driver->switchTo()->frame($frameID);
        return $this;
    }

    /**
     * Switch to default content
     * @return AssertionsTrait|BrowserTrait|InteractionTrait
     */
    public function switchToDefault(): self
    {
        $this->log('Switching to default content');
        $this->driver->switchTo()->defaultContent();
        return $this;
    }

    /**
     * Switch focus to active alert.
     * @return AssertionsTrait|BrowserTrait|InteractionTrait
     */
    public function switchToAlert(): self
    {
        $this->log('Switching to alert');
        $this->driver->switchTo()->alert();
        return $this;
    }
}

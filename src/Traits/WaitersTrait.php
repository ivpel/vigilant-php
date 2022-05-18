<?php


namespace Vigilant\Traits;


use Facebook\WebDriver\WebDriverExpectedCondition;

trait WaitersTrait
{
    use FinderTrait, LoggerTrait;

    private function getTimeout()
    {
        return getenv('WAIT_TIMEOUT');
    }

    private function getSearchTimeIntervalInMillisecond()
    {
        return getenv('SEARCH_TIME_INTERVAL');
    }

    public function waitForElementToBeClickable($elementSelector): self
    {
        $this->log('Waiting for %s to be clickable', $elementSelector);
        $this->driver->wait($this->getTimeout(), $this->getSearchTimeIntervalInMillisecond())->until(
            WebDriverExpectedCondition::elementToBeClickable($this->byXpathOrCss($elementSelector))
        );
        return $this;
    }

    public function waitForElementToBeVisible($elementSelector): self
    {
        $this->log('Waiting for %s to be visible', $elementSelector);
        $this->driver->wait($this->getTimeout(), $this->getSearchTimeIntervalInMillisecond())->until(
            WebDriverExpectedCondition::visibilityOfElementLocated($this->byXpathOrCss($elementSelector))
        );
        return $this;
    }

    public function waitForElementToBePresentInDom($elementSelector): self
    {
        $this->log('Waiting for %s to be presented in DOM', $elementSelector);
        $this->driver->wait($this->getTimeout(), $this->getSearchTimeIntervalInMillisecond())->until(
            WebDriverExpectedCondition::presenceOfElementLocated($this->byXpathOrCss($elementSelector))
        );
        return $this;
    }

    public function waitForElementToDisappear($elementSelector): self
    {
        $this->log('Waiting for %s to disappear', $elementSelector);
        $this->driver->wait($this->getTimeout(), $this->getSearchTimeIntervalInMillisecond())->until(
            WebDriverExpectedCondition::invisibilityOfElementLocated($this->byXpathOrCss($elementSelector))
        );
        return $this;
    }

    public function waitForElementToContainValue($elementSelector, $value): self
    {
        $this->log('Waiting for %s element to contain %s', [$elementSelector, $value]);
        $this->driver->wait($this->getTimeout(), $this->getSearchTimeIntervalInMillisecond())->until(
            WebDriverExpectedCondition::elementValueContains($this->byXpathOrCss($elementSelector), $value)
        );
        return $this;
    }

    public function waitForElementToContainText($elementSelector, $text): self
    {
        $this->log('Waiting for %s to contain %s', [$elementSelector, $text]);
        $this->driver->wait($this->getTimeout(), $this->getSearchTimeIntervalInMillisecond())->until(
            WebDriverExpectedCondition::elementTextContains($this->byXpathOrCss($elementSelector), $text)
        );
        return $this;
    }

    public function waitForElementTextIs($elementSelector, $text): self
    {
        $this->log('Waiting for %s text is %s', [$elementSelector, $text]);
        $this->driver->wait($this->getTimeout(), $this->getSearchTimeIntervalInMillisecond())->until(
            WebDriverExpectedCondition::elementTextIs($this->byXpathOrCss($elementSelector), $text)
        );
        return $this;
    }

    public function waitForAlertIsPresent(): self
    {
        $this->log('Waiting for Alert is present on the page');
        $this->driver->wait($this->getTimeout(), $this->getSearchTimeIntervalInMillisecond())->until(
            WebDriverExpectedCondition::alertIsPresent()
        );
        return $this;
    }

    /**
     * Explicit stop of script execution in seconds.
     *
     * @param int $seconds
     * @return self
     */
    public function strictWait(int $seconds): self
    {
        $this->log('Strict waiting for %s seconds', $seconds);
        sleep($seconds);
        return $this;
    }

}

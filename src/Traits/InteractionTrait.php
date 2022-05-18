<?php


namespace Vigilant\Traits;

use Facebook\WebDriver\Remote\RemoteWebDriver;

/**
 * Trait InteractionTrait
 * @package Vigilant\Traits
 * @property RemoteWebDriver $driver
 */
trait InteractionTrait
{
    use WaitersTrait, FinderTrait, BrowserTrait, AssertionsTrait, LoggerTrait;

    public function acceptAlert(): self
    {
        $this->log('Accepting alert');
        $this->driver->switchTo()->alert()->accept();
        return $this;
    }

    public function cancelAlert(): self
    {
        $this->log('Cancelling alert');
        $this->driver->switchTo()->alert()->dismiss();
        return $this;
    }

    public function typeInAlert($keys): self
    {
        $this->log('Typing inside alert');
        $this->driver->switchTo()->alert()->sendKeys($keys);
        return $this;
    }

    /**
     * Wait before element become visible and clickable and after that - click on the element after 2 seconds delay.
     * This delay is good in terms of emulation of real user behaviour and make tests much more stable and that's why
     * this method is called - safeClick.
     * Otherwise - NoSuchElement exception is throw.
     * ElementNotClickable is deprecated.
     *
     * @param string $elementSelector
     * @return self
     */
    public function safeClick(string $elementSelector): self
    {
        $this->log('Safe click on element %s ', $elementSelector);
        $this->strictWait(2);
        $this->waitForElementToBeVisible($elementSelector);
        $this->findElement($elementSelector)->click();
        return $this;
    }

    /**
     * Simple wait before element become visible and click on in straightway.
     *
     * @param string $elementSelector
     * @return self
     */
    public function click(string $elementSelector): self
    {
        $this->log('Click on element %s ', $elementSelector);
        $this->waitForElementToBeVisible($elementSelector);
        $this->findElement($elementSelector)->click();
        return $this;
    }

    /**
     * Scroll page to element identified by $elementSelector argument.
     * Then making two arrow down click to make sure element is not hidden behind sticky footer.
     *
     * @param string $elementSelector
     * @return self
     */
    public function scrollTo(string $elementSelector): self
    {
        $target = $this->findElement($elementSelector);
        $this->log('Scroll to element %s', $elementSelector);
        $this->executeScript('arguments[0].scrollIntoView({block: "center"})', [$target]);
        return $this;
    }


    /**
     * Return text from tag located by $elementSelector
     *
     * @param string $elementSelector
     * @return string
     */
    public function getTextFromElement(string $elementSelector): string
    {
        $this->log('Getting text from element %s', $elementSelector);
        $this->waitForElementToBeVisible($elementSelector);
        return $this->findElement($elementSelector)->getText();
    }

    /**
     * Wait before field become visible and after that fill it with $inputData.
     *
     * @param string $elementSelector
     * @param string $inputData
     * @return self
     */
    public function fillField(string $elementSelector, string $inputData): self
    {
        $this->log('Filling field %s', $elementSelector);
        $this->waitForElementToBeVisible($elementSelector);
        $this->findElement($elementSelector)->sendKeys($inputData);
        return $this;
    }

    /**
     * Wait before element become visible and move mouse on element.
     * Useful with different hover effects etc.
     *
     * @param string $elementSelector
     * @return self
     */
    public function moveMouseOnElement(string $elementSelector): self
    {
        $this->log('Move mouse cursor on element %s', $elementSelector);
        $this->waitForElementToBeVisible($elementSelector);
        $element = $this->findElement($elementSelector);
        $this->driver->action()->moveToElement($element)->perform();
        return $this;
    }

    /**
     * Press $key as general action in current browser session.
     *
     * @param string $key
     * @return self
     */
    public function pressKey(string $key): self
    {
        $this->log('Press key %s', $key);
        $this->driver->getKeyboard()->pressKey($key);
        return $this;
    }

    /**
     * Send $key to the active field.
     *
     * @param string $key
     * @return self
     */
    public function sendKey(string $key): self
    {
        $this->log('Sending key %s', $key);
        $this->driver->getKeyboard()->sendKeys($key);
        return $this;
    }

    /**
     * Submit form by Submit button selector.
     *
     * @param $elementSelector
     * @return self
     */
    public function submitForm($elementSelector): self
    {
        $this->log('Submitting form %s', $elementSelector);
        $this->driver->findElement($elementSelector)->submit();
        return $this;
    }

    /**
     * Find field by $elementSelector and clear it from any chars.
     *
     * @param $elementSelector
     * @return self
     */
    public function clearField($elementSelector): self
    {
        $this->log('Clearing field %s', $elementSelector);
        $this->waitForElementToBeVisible($elementSelector);
        $this->findElement($elementSelector)->clear();
        return $this;
    }

}

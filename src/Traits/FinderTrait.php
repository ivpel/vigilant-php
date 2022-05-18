<?php


namespace Vigilant\Traits;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriverBy;

/**
 * Trait FinderTrait
 * @package Vigilant\Traits
 * @property RemoteWebDriver $driver
 */
trait FinderTrait
{
    /**
     * Locates element whose class name contains the search value; compound class names are not permitted.
     *
     * @param string $className
     * @return RemoteWebElement The first element located using the mechanism. Exception is thrown if no element found.
     */
    public function findByClass(string $className): RemoteWebElement
    {
        return $this->driver->findElement(WebDriverBy::className($className));
    }

    /**
     * Locates all elements whose class name contains the search value; compound class names are not permitted.
     *
     * @param string $className
     * @return RemoteWebElement[] A list of all elements, or an empty array if nothing matches
     */
    public function findMultipleByClass(string $className): array
    {
        return $this->driver->findElements(WebDriverBy::className($className));
    }


    /**
     * Locates element matching a CSS selector.
     *
     * @param string $cssSelector
     * @return RemoteWebElement The first element located using the mechanism. Exception is thrown if no element found.
     */
    public function findByCss(string $cssSelector): RemoteWebElement
    {
        return $this->driver->findElement(WebDriverBy::cssSelector($cssSelector));
    }

    /**
     * Locates all elements matching a CSS selector.
     *
     * @param string $cssSelector
     * @return RemoteWebElement[] A list of all elements, or an empty array if nothing matches
     */
    public function findMultipleByCss(string $cssSelector): array
    {
        return $this->driver->findElements(WebDriverBy::cssSelector($cssSelector));
    }


    /**
     * Locates element whose ID attribute matches the search value.
     *
     * @param string $id
     * @return RemoteWebElement The first element located using the mechanism. Exception is thrown if no element found.
     */
    public function findById(string $id): RemoteWebElement
    {
        return $this->driver->findElement(WebDriverBy::id($id));
    }

    /**
     * Locates all elements whose ID attribute matches the search value.
     *
     * @param string $id
     * @return RemoteWebElement[] A list of all elements, or an empty array if nothing matches
     */
    public function findMultipleById(string $id): array
    {
        return $this->driver->findElements(WebDriverBy::id($id));
    }


    /**
     * Locates element whose NAME attribute matches the search value.
     *
     * @param string $name
     * @return RemoteWebElement The first element located using the mechanism. Exception is thrown if no element found.
     */
    public function findByName(string $name): RemoteWebElement
    {
        return $this->driver->findElement(WebDriverBy::name($name));
    }

    /**
     * Locates all elements whose NAME attribute matches the search value.
     *
     * @param string $name
     * @return RemoteWebElement[] A list of all elements, or an empty array if nothing matches
     */
    public function findMultipleByName(string $name): array
    {
        return $this->driver->findElements(WebDriverBy::name($name));
    }

    /**
     * Locates anchor element whose visible text matches the search value.
     *
     * @param string $linkText
     * @return RemoteWebElement The first element located using the mechanism. Exception is thrown if no element found.
     */
    public function findByLinkText(string $linkText): RemoteWebElement
    {
        return $this->driver->findElement(WebDriverBy::linkText($linkText));
    }

    /**
     * Locates all anchor elements whose visible text matches the search value.
     *
     * @param string $linkText
     * @return RemoteWebElement[] A list of all elements, or an empty array if nothing matches
     */
    public function findMultipleByLinkText(string $linkText): array
    {
        return $this->driver->findElements(WebDriverBy::linkText($linkText));
    }

    /**
     * Locates anchor element whose visible text partially matches the search value.
     *
     * @param string $partialLinkText
     * @return RemoteWebElement The first element located using the mechanism. Exception is thrown if no element found.
     */
    public function findByPartialLinkText(string $partialLinkText): RemoteWebElement
    {
        return $this->driver->findElement(WebDriverBy::partialLinkText($partialLinkText));
    }

    /**
     * Locates all anchor elements whose visible text partially matches the search value.
     *
     * @param string $partialLinkText
     * @return RemoteWebElement[] A list of all elements, or an empty array if nothing matches
     */
    public function findMultipleByPartialLinkText(string $partialLinkText): array
    {
        return $this->driver->findElements(WebDriverBy::partialLinkText($partialLinkText));
    }

    /**
     * Locates element whose tag name matches the search value.
     *
     * @param string $tagName
     * @return RemoteWebElement The first element located using the mechanism. Exception is thrown if no element found.
     */
    public function findByTag(string $tagName): RemoteWebElement
    {
        return $this->driver->findElement(WebDriverBy::tagName($tagName));
    }

    /**
     * Locates all elements whose tag name matches the search value.
     *
     * @param string $tagName
     * @return RemoteWebElement[] A list of all elements, or an empty array if nothing matches
     */
    public function findMultipleByTag(string $tagName): array
    {
        return $this->driver->findElements(WebDriverBy::tagName($tagName));
    }

    /**
     * Locates element matching an XPath expression.
     *
     * @param string $xpath
     * @return RemoteWebElement The first element located using the mechanism. Exception is thrown if no element found.
     */
    public function findByXpath(string $xpath): RemoteWebElement
    {
        return $this->driver->findElement(WebDriverBy::xpath($xpath));
    }

    /**
     * Locates all elements matching an XPath expression.
     *
     * @param string $xpath
     * @return RemoteWebElement[] A list of all elements, or an empty array if nothing matches
     */
    public function findMultipleByXpath(string $xpath): array
    {
        return $this->driver->findElements(WebDriverBy::xpath($xpath));
    }

    /**
     * Find element by XPATH or CSS depending on what pattern selector has.
     *
     * @param string $selector
     * @return RemoteWebElement
     */
    public function findElement(string $selector): RemoteWebElement
    {
        return $this->driver->findElement($this->byXpathOrCss($selector));
    }

    /**
     * Find element by XPATH or CSS depending on what pattern selector has.
     *
     * @param string $selector
     * @return RemoteWebElement[]
     */
    public function findMultiplyByXpathOrCss(string $selector): array
    {
        if (str_starts_with($selector, '//')) {
            return $this->findMultipleByXpath($selector);
        } else {
            return $this->findMultipleByCss($selector);
        }
    }

    public function byXpathOrCss($selector): WebDriverBy
    {
        if (str_starts_with($selector, '//')) {
            return WebDriverBy::xpath($selector);
        } else {
            return WebDriverBy::className($selector);
        }
    }
}

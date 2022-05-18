<?php

namespace Vigilant\Traits;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

trait AssertionsTrait
{
    use FinderTrait, WaitersTrait, BrowserTrait;

    public function countVisibleElements($elementSelector): int
    {
        $this->waitForElementToBeVisible($elementSelector);
        return count($this->findMultiplyByXpathOrCss($elementSelector));
    }

    public function countElementsInDom($elementSelector): int
    {
        $this->waitForElementToBePresentInDom($elementSelector);
        return count($this->findMultiplyByXpathOrCss($elementSelector));
    }

    /**
     * Assert that element is not visible in the current page.
     *
     * @param $elementSelector
     * @return AssertionsTrait|InteractionTrait
     */
    public function assertDontSee($elementSelector): self
    {

        if (is_array($elementSelector)) {
            foreach ($elementSelector as $item) {
                assertEquals(
                    0,
                    $this->countVisibleElements($item),
                    sprintf('Expected 0 elements, but found %s ', $this->countVisibleElements($item))
                );
            }
        } elseif (is_string($elementSelector)) {
            assertEquals(
                0,
                $this->countVisibleElements($elementSelector),
                sprintf('Expected 0 elements, but found %s ', $this->countVisibleElements($elementSelector))
            );
        }
        return $this;
    }

    /**
     * Check that title does not contain $titleString.
     *
     * @param string $titleString
     * @return AssertionsTrait|InteractionTrait
     */
    public function assertDontSeeInTitle(string $titleString): self
    {
        assertTrue(
            (!str_contains($this->pageTitle(), $titleString)),
            'Current page title contain ' . $titleString);
        return $this;
    }

    /**
     * Check that URL doest not contains string $urlPartString.
     *
     * @param string $urlPartString
     * @return AssertionsTrait|InteractionTrait
     */
    public function assertDontSeeInUrl(string $urlPartString): self
    {
        assertTrue(
            (!str_contains($this->driver->getCurrentURL(), $urlPartString)),
            'Current page URL contain ' . $urlPartString);
        return $this;
    }

    /**
     * Return True if $elementSelector is visible on the page.
     * As param can take single string or array of strings and every string
     * from the array will be checked for visibility.
     *
     * @param $elementSelector
     * @return AssertionsTrait|InteractionTrait
     */
    public function assertSee($elementSelector): self
    {
         if (is_array($elementSelector)) {
            foreach ($elementSelector as $item) {
                assertEquals(
                    1,
                    $this->countVisibleElements($item),
                    sprintf('Expected 1 element, but found %s ', $this->countVisibleElements($item))
                );
            }
        } elseif (is_string($elementSelector)) {
             assertEquals(
                 1,
                 $this->countVisibleElements($elementSelector),
                 sprintf('Expected 1 elements, but found %s ', $this->countVisibleElements($elementSelector))
             );
         }
         return $this;
    }

    /**
     * Return True if $elementSelector is visible on the page and quantity of that elements are equal to $qty.
     *
     * @param string $elementSelector
     * @param int $qty
     * @return AssertionsTrait|InteractionTrait
     */
    public function assertSeeElementsInQuantityOf(string $elementSelector, int $qty): self
    {
        assertEquals(
            $qty,
            $this->countVisibleElements($elementSelector),
            sprintf('Expected %s elements, but found %s ', $qty, $this->countVisibleElements($elementSelector))
        );
        return $this;
    }

    /**
     * Return True if $elementSelector is visible on the page and quantity of elements are > than 1.
     *
     * @param string $elementSelector
     * @return AssertionsTrait|InteractionTrait
     */
    public function assertSeeMany(string $elementSelector): self
    {
        assertTrue(
            ($this->countVisibleElements($elementSelector) > 1),
            sprintf('Expected quantity of elements > 1, but found %s', $this->countVisibleElements($elementSelector))
        );
        return $this;
    }

    /**
     * Return True if $elementSelector is visible on the page and quantity of elements are at least 1.
     *
     * @param string $elementSelector
     * @return AssertionsTrait|InteractionTrait
     */
    public function assertSeeAtLeastOne(string $elementSelector): self
    {
        assertTrue(
            ($this->countVisibleElements($elementSelector) > 0),
            sprintf('Expected at least 1, found %s', $this->countVisibleElements($elementSelector))
        );
        return $this;
    }

    /**
     * Return True if $elementSelector is presented in DOM in quantity of 1.
     *
     * @param string $elementSelector
     * @return AssertionsTrait|InteractionTrait
     */
    public function assertSeeElementInDom(string $elementSelector): self
    {
        assertTrue(
            $this->countElementsInDom($elementSelector) === 1,
            sprintf('Expected to see 1 element in DOM, found %s', $this->countElementsInDom($elementSelector))
        );
        return $this;
    }

    /**
     * Return True if $elementSelector is presented in DOM in quantity > 1.
     *
     * @param string $elementSelector
     * @return AssertionsTrait|InteractionTrait
     */
    public function assertSeeManyElementsInDom(string $elementSelector): self
    {
        assertTrue(
            $this->countElementsInDom($elementSelector) > 1,
            sprintf('Expected to see more than 1 elements in DOM, found %s', $this->countElementsInDom($elementSelector))
        );
        return $this;
    }

    /**
     * Check if title contain $titleString.
     *
     * @param string $titleString
     * @return AssertionsTrait|InteractionTrait
     */
    public function assertSeeInTitle(string $titleString): self
    {
        assertTrue(
            (str_contains($this->pageTitle(), $titleString)),
            'Page title does not contain ' . $titleString);
        return $this;
    }

    /**
     * Check if URL contains string $urlPartString.
     *
     * @param string $urlPartString
     * @return AssertionsTrait|InteractionTrait
     */
    public function assertSeeInUrl(string $urlPartString): self
    {
        assertTrue(
            (str_contains($this->driver->getCurrentURL(), $urlPartString)),
            'Current page URL does not contain ' . $urlPartString);
        return $this;
    }

}

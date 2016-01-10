<?php

use Behat\WebApiExtension\Context\WebApiContext;
use Behat\Behat\Context\SnippetAcceptingContext;
/**
 * Defines application features from the specific context.
 */
class FeatureContext extends WebApiContext implements SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }
}
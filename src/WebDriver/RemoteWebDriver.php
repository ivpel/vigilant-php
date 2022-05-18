<?php

namespace Vigilant\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;

class RemoteWebDriver extends \Facebook\WebDriver\Remote\RemoteWebDriver
{
    /**
     * @var DesiredCapabilities
     */
    private static DesiredCapabilities $desired_capabilities;

    private static function getBrowser()
    {
        return getenv('BROWSER');
    }

    private static function getHost()
    {
        return getenv('SELENIUM_HOST');
    }

    public static function getLogLevel()
    {
        return getenv('LOG_LEVEL');
    }

    public static function createNewSession(): RemoteWebDriver
    {
        self::$desired_capabilities = match (strtoupper(self::getBrowser())) {
            'CHROME' => DesiredCapabilities::chrome(),
            'FIREFOX' => DesiredCapabilities::firefox(),
            'EDGE' => DesiredCapabilities::microsoftEdge(),
        };
        return RemoteWebDriver::create(self::getHost(), self::$desired_capabilities, 3600000,3600000);
    }

    public function execute($command_name, $params = [])
    {
        if (self::getLogLevel() == 3) {
            $this->log(
                'Executing command "%s" with params %s',
                $command_name,
                json_encode($params, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            );
        }
        return parent::execute($command_name, $params);
    }

    /**
     * Log to output
     *
     * @param string $format The format string. May use "%" placeholders, in a same way as sprintf()
     * @param mixed ...$args Variable number of parameters inserted into $format string
     */
    protected function log(string $format, ...$args): void
    {
        echo '[' . date('Y-m-d H:i:s') . ']'
            . ' [WebDriver] '
            . vsprintf($format, $args)
            . "\n";
    }
}

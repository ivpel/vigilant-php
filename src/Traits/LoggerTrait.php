<?php


namespace Vigilant\Traits;


trait LoggerTrait
{
    private static function checkLogLevel(): bool
    {
        if(getenv('LOG_LEVEL') != 0)
        {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Use it as descriptive method inside tests and POM objects (when you want to describe some logic behind actions)
     * Output current step from tests or POM.
     *
     * @param string $format The format string. May use "%" placeholders, in a same way as sprintf()
     * @param mixed ...$args Variable number of parameters inserted into $format string
     */
    public function step(string $format, ...$args): self
    {
        if (getenv('LOG_LEVEL') >= 1) {
            echo $this->formatOutput($format, $args, 'STEP');
        }
        return $this;
    }

    /**
     * Log to output
     *
     * @param string $format The format string. May use "%" placeholders, in a same way as sprintf()
     * @param mixed ...$args Variable number of parameters inserted into $format string
     */
    public function log(string $format, ...$args): self
    {
        if (getenv('LOG_LEVEL') >= 2) {
            echo $this->formatOutput($format, $args, 'INFO');
        }
        return $this;
    }

    /**
     * Log warning to output. Unlike log(), it will be prefixed with "WARN: ".
     *
     * @param string $format The format string. May use "%" placeholders, in a same way as sprintf()
     * @param mixed ...$args Variable number of parameters inserted into $format string
     */

    public function warn(string $format, ...$args): self
    {
        if (getenv('LOG_LEVEL') >= 2) {
            echo $this->formatOutput($format, $args, 'WARN');
        }
        return $this;
    }

    /**
     * Format output
     *
     * @param string $format The format string. May use "%" placeholders, in a same way as sprintf()
     * @param array $args Array of arguments passed to original sprintf()-like function
     * @param string $type Specific log severity type (WARN, DEBUG) prefixed to output
     * @return string Formatted output
     */
    protected function formatOutput(string $format, array $args, string $type = ''): string
    {
        // If first item of arguments contains another array use it as arguments
        if (!empty($args) && is_array($args[0])) {
            $args = $args[0];
        }

        return '[' . date('Y-m-d H:i:s') . ']'
            . ($type ? " [$type]" : '') . ' '
            . vsprintf($format, $args)
            . "\n";
    }
}

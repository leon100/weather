<?php

namespace Leon\Weather\Logger;

use Psr\Log\LoggerInterface;

/**
 * @method emergency(string $message)
 * @method alert(string $message)
 * @method critical(string $message)
 * @method error(string $message)
 * @method warning(string $message)
 * @method notice(string $message)
 * @method info(string $message)
 * @method debug(string $message)
 */
class Logger
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __call($method, $parameters): void
    {
        if (method_exists($this->logger, $method)) {
            call_user_func_array([$this->logger, $method], $parameters);
        }
    }
}

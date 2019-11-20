<?php

namespace Luggsoft\Php\Common\Injectors;

use Exception;
use Throwable;

final class InjectorException extends Exception
{
    
    /**
     *
     * {@inheritdoc}
     */
    public function __construct(string $message = null, int $code = null, Throwable $previous = null)
    {
        if ($message === null) {
            $message = 'Failed to inject';
        }
        
        parent::__construct($message, $code, $previous);
    }
    
    /**
     *
     * @param string $name
     * @return string
     */
    public static function getParameterInjectionFailedMessage(string $name)
    {
        return sprintf('Failed to inject parameter "%s"', $name);
    }
    
    /**
     *
     * @param string $className
     * @return string
     */
    public static function getDefinitionInjectionFailedMessage(string $className)
    {
        return sprintf('Failed to inject definition "%s"', $className);
    }
    
}

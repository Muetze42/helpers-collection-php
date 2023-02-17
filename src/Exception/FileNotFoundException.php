<?php

namespace NormanHuth\Helpers\Exception;

use Exception;
use Throwable;

class FileNotFoundException extends Exception
{
    public function __construct(string $file = '', int $code = 404, ?Throwable $previous = null)
    {
        $message = sprintf('File `%s` not found', $file);

        parent::__construct($message, $code, $previous);
    }
}

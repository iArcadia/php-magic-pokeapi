<?php

namespace iArcadia\MagicPokeAPI\Exceptions;

use Exception;

/**
 * PokeAPI exception type for cURL request.
 *
 * @author Kévin Bibollet <bibollet.kevin@gmail.com>
 * @license MIT
 *
 * @extends Exception
 */
class PokeApiCUrlException extends Exception
{
    /**
     * Constructor method.
     *
     * @param string $message The displayed error message.
     * @param int $code The error code.
     * @param Exception|null $previous The previous exception.
     */
    public function __construct($code = 0, Exception $previous = null)
    {
        parent::__construct($this->getCodeMessage($code), $code, $previous);
    }
    
    protected function getCodeMessage($code)
    {
        $message = 'Unknown Exception';
        
        switch ($code)
        {
            case 0: $message = 'No Message'; break;
            
            case 100: $message = 'Continue'; break;
            case 101: $message = 'Switching Protocols'; break;
                
            case 200: $message = 'OK'; break;
            case 201: $message = 'Created'; break;
            case 202: $message = 'Accepted'; break;
            case 203: $message = 'Non-Authoritative Information'; break;
            case 204: $message = 'No Content'; break;
            case 205: $message = 'Reset Content'; break;
            case 206: $message = 'Partial Content'; break;
                
            case 300: $message = 'Multiplace Choices'; break;
            case 301: $message = 'Moved Permanently'; break;
            case 302: $message = 'Found'; break;
            case 303: $message = 'See Other'; break;
            case 304: $message = 'Not Modified'; break;
            case 305: $message = 'Use Proxy'; break;
            case 306: $message = '(Unused)'; break;
            case 307: $message = 'Temporary Redirect'; break;
                
            case 400: $message = 'Bad Request'; break;
            case 401: $message = 'Unauthorized'; break;
            case 402: $message = 'Payment Required'; break;
            case 403: $message = 'Forbidden'; break;
            case 404: $message = 'Not Found'; break;
            case 405: $message = 'Method Not Allowed'; break;
            case 406: $message = 'Not Acceptable'; break;
            case 407: $message = 'Proxy Authentication Required'; break;
            case 408: $message = 'Request Timeout'; break;
            case 409: $message = 'Conflict'; break;
            case 410: $message = 'Gone'; break;
            case 411: $message = 'Length Required'; break;
            case 412: $message = 'Precondition Failed'; break;
            case 413: $message = 'Request Entity Too Large'; break;
            case 414: $message = 'Request-URI Too Long'; break;
            case 415: $message = 'Unsupported media Type'; break;
            case 416: $message = 'Requested Range Not Satisfiable'; break;
            case 417: $message = 'Expeectation Failed;'; break;
                
            case 500: $message = 'Internal Server Error'; break;
            case 501: $message = 'Not Implemented'; break;
            case 502: $message = 'Bad Gateway'; break;
            case 503: $message = 'Service Unvailable'; break;
            case 504: $message = 'Gateway Timeout'; break;
            case 505: $message = 'HTTP Version Not Supported'; break;
        }
        
        return $message;
    }
}
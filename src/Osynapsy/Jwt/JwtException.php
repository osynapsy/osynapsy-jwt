<?php

/*
 * This file is part of the Osynapsy package.
 *
 * (c) Pietro Celeste <p.celeste@osynapsy.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Osynapsy\Jwt;

class JwtException extends \Exception
{
    protected $submessage;
    
    public function __construct($message = "", $code = 0, \Throwable $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setInfoMessage($message)
    {
        $this->submessage = $message;
    }

    public function getInfoMessage()
    {
        return $this->submessage;
    }
}

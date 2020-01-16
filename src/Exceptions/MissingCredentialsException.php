<?php

namespace Netflex\Exceptions;

use Exception;

class MissingCredentialsException extends Exception
{
  public function __construct()
  {
    parent::__construct('Missing Netflex API credentials, please verify your configuration');
  }
}

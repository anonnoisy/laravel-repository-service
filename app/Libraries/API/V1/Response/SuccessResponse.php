<?php

namespace App\Libraries\API\V1\Response;

class SuccessResponse extends Response
{
  public function __construct(string $message = "", array $data = [], int $statusCode = 200)
  {
    parent::__construct($message, $data, $statusCode);
  }
}

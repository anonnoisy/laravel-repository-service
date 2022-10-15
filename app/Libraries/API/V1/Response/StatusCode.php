<?php

namespace App\Libraries\API\V1\Response;

class StatusCode
{
  const OK = 200;
  const CREATED = 201;
  const NO_CONTENT = 204;

  const BAD_REQUEST = 400;
  const UNAUTHORIZED = 401;
  const FORBIDDEN = 403;
  const NOT_FOUND = 404;
  const UNPROCESSABLE = 422;
  const ERROR_CODE = 500;
}

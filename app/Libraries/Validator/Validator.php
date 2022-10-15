<?php

namespace App\Libraries\Validator;

use Illuminate\Support\Facades\Validator;

Validator::extend('alpha_space', function ($attribute, $value) {
  return is_string($value) && preg_match('/^[\pL\pM]+$/u', $value);
});

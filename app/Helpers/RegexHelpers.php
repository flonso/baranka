<?php

namespace App\Helpers;

class RegexHelpers {
  const NAME_REGEX = "/^[\p{L}\p{Pd}\p{Zs}'’\.]*$/u";
  const INTEGER_REGEX = "/^[1-9][0-9]*$/";
  const FLOAT_REGEX = "/^(0|[1-9][0-9]*)(\.[0-9]+){0,1}$/";
}
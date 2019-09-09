<?php

namespace App\Helpers;

class RegexHelpers {
  // https://www.php.net/manual/fr/regexp.reference.unicode.php

  const NAME_REGEX = "/^[\p{L}\p{Pd}\p{Zs}'’\.]*$/u";
  const NAME_REGEX_WITH_NUMBERS = "/^[0-9\p{L}\p{Pd}\p{Zs}'’\.]*$/u";
  const INTEGER_REGEX = "/^-?([1-9][0-9]*|0)$/";
  const FLOAT_REGEX = "/^(0|[1-9][0-9]*)(\.[0-9]+){0,1}$/";
}
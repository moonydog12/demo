<?php

namespace Http\Forms;

use Core\ValidationException;
use Core\Validator;

class LoginForm
{
  protected $errors = [];
  public $attributes;

  public function __construct($attributes)
  {
    $this->attributes = $attributes;
    if (!Validator::email($attributes['email'])) {
      $this->errors['email'] = 'Please provide an valid email address.';
    }

    if (!Validator::string($attributes['password'])) {
      $this->errors['password'] = 'Please provide a valid password.';
    }
  }

  public static function validate($attributes)
  {
    $instance = new static($attributes);

    // if ($instance->failed()) {
    //   $instance->throw();
    // }

    // return $instance;
    return $instance->failed() ? $instance->throw() : $instance;
  }

  public function throw()
  {
    ValidationException::throw($this->getErrors(), $this->attributes);
  }

  public function failed()
  {
    return count($this->errors);
  }

  public function getErrors()
  {
    return $this->errors;
  }

  public function addError($field, $message)
  {
    $this->errors[$field] = $message;
    return $this;
  }
}

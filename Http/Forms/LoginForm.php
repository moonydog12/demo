<?php

namespace Http\Forms;

use Core\Validator;

class LoginForm
{
  protected $errors = [];

  public function validate($email, $password)
  {
    if (!Validator::email($email)) {
      $this->errors['email'] = 'Please provide an valid email address.';
    }

    if (!Validator::string($password, 7, 255)) {
      $this->errors['password'] = 'Please provide a valid password.';
    }

    return empty($this->errors);
  }

  public function getErrors()
  {
    return $this->errors;
  }
}

<?php

use Core\Authenticator;
use Core\Session;
use Core\ValidationException;
use Http\Forms\LoginForm;

$auth = new Authenticator();

try {
  $form = LoginForm::validate(
    $attributes = [
      'email' => $_POST['email'],
      'password' => $_POST['password'],
    ]
  );
} catch (ValidationException $exception) {
  Session::flash('errors', $exception->errors);
  Session::flash('old', $exception->old);
  return redirect('/login');
}

if ($auth->attempt($attributes['email'], $attributes['password'])) {
  redirect('/');
}

// password validation fail
$form->addError(
  'email',
  'No matching accounts found for that email and password.'
);

<?php

use Core\Authenticator;
use Http\Forms\LoginForm;

$auth = new Authenticator();

$form = LoginForm::validate(
  $attributes = [
    'email' => $_POST['email'],
    'password' => $_POST['password'],
  ]
);

$signedIn = $auth->attempt($attributes['email'], $attributes['password']);

// password validation fail
if (!$signedIn) {
  $form
    ->addError(
      'email',
      'No matching accounts found for that email and password.'
    )
    ->throw();
}

redirect('/');

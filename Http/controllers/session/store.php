<?php

use Core\Authenticator;
use Core\Session;
use Http\Forms\LoginForm;

$email = $_POST['email'];
$password = $_POST['password'];
$form = new LoginForm();

if ($form->validate($email, $password)) {
  $auth = new Authenticator();

  if ($auth->attempt($email, $password)) {
    redirect('/');
  }

  // password validation fail
  $form->addError(
    'email',
    'No matching accounts found for that email and password.'
  );
}

Session::flash('errors', $form->getErrors());

return redirect('/login');

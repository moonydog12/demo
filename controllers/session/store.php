<?php

use Core\App;
use Core\Database;
use Core\Validator;

$email = $_POST['email'];
$password = $_POST['password'];

$db = App::resolve(Database::class);

// validate the form inputs.
$errors = [];
if (!Validator::email($email)) {
  $errors['email'] = 'Please provide an valid email address.';
}

if (!Validator::string($password, 7, 255)) {
  $errors['password'] = 'Please provide a valid password.';
}

if (!empty($errors)) {
  return view('session/create.view.php', [
    'errors' => $errors
  ]);
}

// match the credentials
$user = $db->query('SELECT * FROM users WHERE email = :email', [
  'email' => $email,
])->find();

if ($user) {
  // we have a user, but we don't know if the password matches what we have in the db
  if (password_verify($password, $user['password'])) {
    // log in the user if the credentials match
    login([
      'email' => $email
    ]);

    header('location: /');
    exit();
  }
}

// password validation fail
return view('session/create.view.php', [
  'errors' => [
    'email' => 'No matching accounts found for that email and password.'
  ]
]);

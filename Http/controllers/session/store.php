<?php

use Core\App;
use Core\Database;
use Http\Forms\LoginForm;

$email = $_POST['email'];
$password = $_POST['password'];

$db = App::resolve(Database::class);

$form = new LoginForm();

if (!$form->validate($email, $password)) {
  return view('session/create.view.php', [
    'errors' => $form->getErrors()
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

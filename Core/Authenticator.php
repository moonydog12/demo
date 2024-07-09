<?php

namespace Core;

class Authenticator
{
  public function attempt($email, $password)
  {
    // match the credentials
    $user = App::resolve(Database::class)->query('SELECT * FROM users WHERE email = :email', [
      'email' => $email,
    ])->find();

    if ($user) {
      // we have a user, but we don't know if the password matches what we have in the db
      if (password_verify($password, $user['password'])) {
        // log in the user if the credentials match
        $this->login([
          'email' => $email
        ]);

        return true;
      }
    }

    return false;
  }

  public function login($user)
  {
    $_SESSION['user'] = [
      'email' => $user['email']
    ];

    // update the session id with regenerated one
    session_regenerate_id(true);
  }

  public function logout()
  {
    // clear out session
    $_SESSION = [];
    session_destroy();

    // delete cookie
    $params = session_get_cookie_params();
    setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain']);
  }
}

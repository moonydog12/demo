<?php

use Core\Response;

function dd($value)
{
  echo '<pre>';
  var_dump($value);
  echo '</pre>';
  die();
}

function urlIs($value)
{
  return  $_SERVER['REQUEST_URI'] === $value;
}

function abort($code = 404)
{
  http_response_code($code);
  require base_path("views/$code.php");
  die();
}

function authorize($condition, $status = Response::FORBIDDEN)
{
  if (!$condition) {
    abort($status);
  }
}

function base_path($path)
{
  return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
  // turn the set of array into variables
  extract($attributes);
  require base_path('views/' . $path); // /views/index.view.php
}

function login($user)
{
  $_SESSION['user'] = [
    'email' => $user['email']
  ];

  // update the session id with regenerated one
  session_regenerate_id(true);
}

function logout()
{
  // clear out session
  $_SESSION = [];
  session_destroy();

  // delete cookie
  $params = session_get_cookie_params();
  setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain']);
}

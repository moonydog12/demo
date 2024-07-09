<?php

namespace Core\Middleware;

class Middleware
{
  const MAP = [
    'guest' => Guest::class,
    'auth' => Auth::class,
  ];

  public static function resolve($key)
  {
    // 先檢查有沒有 key
    if (!$key) {
      return;
    }

    $middleware = static::MAP[$key] ?? false;

    if (!$middleware) {
      throw new \Exception("No matching middleware found for key '{$key}'.");
    }
    (new $middleware())->handle();
  }
}

<?php
namespace Core;

class Router {
  protected array $routes = [];
  private string $prefix;
  public Controller $controller;
  public Request $request;
  public Response $response;
  function __construct(Request $request, Response $response) {
    $this->request = $request;
    $this->response = $response;
    $this->prefix = '';
  }
  public function prefix(string $prefix) {
    $this->prefix = $prefix;
    if ($this->prefix !== '') {
      $this->prefix = '/' . $prefix;
    }
  }

  public function get(...$args) {
    switch (count($args)) {
      case 2:
        $url = $args[0];
        $callback = $args[1];
        $path = $this->prefix . $url;
        $this->routes['GET'][$path]['callback'] = $callback;
        $this->routes['GET'][$path]['middlewares'] = null;
        break;
      case 3:
        $url = $args[0];
        $middlewares = $args[1];
        $callback = $args[2];
        $path = $this->prefix . $url;
        $this->routes['GET'][$path]['callback'] = $callback;
        $this->routes['GET'][$path]['middlewares'] = $middlewares;
        break;

      default:
        throw new \Exception('Error Processing Request', 1);
        break;
    }
  }

  public function post(...$args) {
    switch (count($args)) {
      case 2:
        $url = $args[0];
        $callback = $args[1];
        $path = $this->prefix . $url;
        $this->routes['POST'][$path]['callback'] = $callback;
        $this->routes['POST'][$path]['middlewares'] = null;
        break;
      case 3:
        $url = $args[0];
        $middlewares = $args[1];
        $callback = $args[2];
        $path = $this->prefix . $url;
        $this->routes['POST'][$path]['callback'] = $callback;
        $this->routes['POST'][$path]['middlewares'] = $middlewares;
        break;

      default:
        throw new \Exception('Error Processing Request', 1);
        break;
    }
  }
  public function handle() {
    $method = $this->request->method();
    $path = $this->request->path();

    foreach ($this->routes[$method] as $key => $infoRoute) {
      $callback = $infoRoute['callback'];
      $middlewares = $infoRoute['middlewares'];
      if ($path === $key) {
        return $this->resolve($callback, $middlewares);
      }

      preg_match_all('#\{(.*?):(.*?)\}#', $key, $match);
      $listParams = $match[1];

      if (count($match[0]) !== 0) {
        $patternRoute = preg_replace_callback(
          '#\{(.*?):(.*?)\}#',
          fn($matches) => '(' . $matches[2] . ')',
          $key
        );
        $patternRoute = '/^' . str_replace('/', '\/', $patternRoute) . '\/?$/';

        $isMatch = preg_match_all($patternRoute, $path, $matches);
        if ($isMatch) {
          unset($matches[0]);
          $matches = array_column(array_values($matches), 0);
          $result = array_combine($listParams, $matches);
          $this->request->setParams($result);
          return $this->resolve($callback, $middlewares);
        }
      }
    }

    return Controller::error($this->response);
  }

  public function resolve(array|callable $callback, ?array $middlewares) {
    $this->resolveMiddlewares($middlewares);
    return call_user_func($callback, $this->request, $this->response);
  }

  public function executeMiddleware(callable|array $middleware) {
    return call_user_func($middleware, $this->request, $this->response);
  }

  public function resolveMiddlewares(?array $middlewares) {
    if (isset($middlewares)) {
      // NOTE: handle middleware
      foreach ($middlewares as $middleware) {
        $this->executeMiddleware($middleware);
      }
    }
  }
}
?>

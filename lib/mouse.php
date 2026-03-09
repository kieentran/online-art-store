<?php
class Mouse {
  private static $instance;
  private $routes = [];
  private $route_vars = [];

  public static function get_instance() {
    if (!self::$instance) {
      self::$instance = new Mouse();
    }
    return self::$instance;
  }

  public function get($pattern, $callback) {
    $this->register("GET", $pattern, $callback);
  }

  public function post($pattern, $callback) {
    $this->register("POST", $pattern, $callback);
  }

  private function register($method, $pattern, $callback) {
    // Store the original pattern to extract parameter names
    $this->routes[] = [$method, $pattern, $callback];
  }

  public function resolve() {
    $method = $_SERVER["REQUEST_METHOD"];
    $uri = explode("?", $_SERVER["REQUEST_URI"])[0];

    // Remove base folder if the app is in /online-art-store/
    $script_name = dirname($_SERVER["SCRIPT_NAME"]);
    if ($script_name !== '/' && strpos($uri, $script_name) === 0) {
      $uri = substr($uri, strlen($script_name));
    }

    foreach ($this->routes as [$route_method, $route_pattern, $callback]) {
      if ($method === $route_method) {
        // Extract parameter names from the pattern
        $param_names = [];
        if (preg_match_all('/:(\w+)/', $route_pattern, $matches)) {
          $param_names = $matches[1];
        }
        
        // Convert route pattern to regex
        $regex_pattern = preg_replace('/:(\w+)/', '([^/]+)', $route_pattern);
        $regex_pattern = "#^" . $regex_pattern . "$#";
        
        if (preg_match($regex_pattern, $uri, $matches)) {
          array_shift($matches); // Remove full match
          
          // Map parameter names to values
          $this->route_vars = [];
          foreach ($param_names as $index => $name) {
            if (isset($matches[$index])) {
              $this->route_vars[$name] = $matches[$index];
            }
          }
          
          return $callback($this);
        }
      }
    }

    http_response_code(404);
    echo "404 - Page Not Found";
  }

  public function route_var($key) {
    return $this->route_vars[$key] ?? null;
  }

  public function render($view, $data = []) {
    extract($data);
    $content = "views/pages/{$view}.php";
    if (!file_exists($content)) throw new Exception("View not found: $view");
    include "views/layouts/standard.php";
  }

  public function run() {
    $this->resolve();
  }
}
?>
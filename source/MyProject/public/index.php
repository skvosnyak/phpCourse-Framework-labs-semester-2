<?php
function myAutoLoader(string $className)
{
  $relativePath = str_replace('MyProject\\', '', $className);
  $path = '/var/www/src/' . str_replace('\\', '/', $relativePath) . '.php';
  error_log("Trying to load: " . $path); 
  require_once $path;
}
spl_autoload_register('myAutoLoader');

$route = $_GET['route'] ?? '';
$routes = require __DIR__ . '/../src/routes.php';
$isRouteFound = false;

foreach ($routes as $pattern => $controllerAndAction) {
  preg_match($pattern, $route, $matches);
  if (!empty($matches)) {
    $isRouteFound = true;
    break;
  }
}

if (!$isRouteFound) {
  echo "Page not found";
  return;
}
unset($matches[0]);

$controllerName = $controllerAndAction[0];
$actionName = $controllerAndAction[1];
$controller = new $controllerName();
$controller->$actionName(...$matches);

<?php

/**
 * Classe Router - Système de routes dynamiques
 */
class Router {
    private $routes = [];
    private $notFoundCallback;
    
    /**
     * Ajoute une route GET
     */
    public function get($pattern, $callback) {
        return $this->addRoute('GET', $pattern, $callback);
    }
    
    /**
     * Ajoute une route POST
     */
    public function post($pattern, $callback) {
        return $this->addRoute('POST', $pattern, $callback);
    }
    
    /**
     * Ajoute une route pour n'importe quelle méthode HTTP
     */
    public function addRoute($method, $pattern, $callback) {
        $pattern = '/^' . str_replace('/', '\/', preg_replace('/{:([^\/]+)}/', '([^\/]+)', $pattern)) . '$/';
        $this->routes[$method][] = [
            'pattern' => $pattern,
            'callback' => $callback
        ];
        return $this;
    }
    
    /**
     * Définit la fonction à exécuter lorsqu'aucune route ne correspond
     */
    public function notFound($callback) {
        $this->notFoundCallback = $callback;
        return $this;
    }
    
    /**
     * Exécute le routeur
     */
    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : (
               isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '/');
        
        // Chercher une route correspondante
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route) {
                if (preg_match($route['pattern'], $uri, $matches)) {
                    array_shift($matches);
                    call_user_func_array($route['callback'], $matches);
                    return;
                }
            }
        }
        
        // Aucune route trouvée
        if ($this->notFoundCallback) {
            call_user_func($this->notFoundCallback);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo '404 Page Not Found';
        }
    }
}

?>
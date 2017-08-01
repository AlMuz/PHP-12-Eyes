<?php
namespace NewsSite;
use NewsSite\Controllers\HomeController;
use NewsSite\Controllers\NewsController;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class Application
{
    private $dispatcher;
    public function __construct()
    {
        $this->dispatcher = $this->configureRoutes();
    }
    public function getContainer() : Container
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->setParameter('resource.views', __DIR__ . '/views/');
        $containerBuilder->register('database', '\Medoo\Medoo')
            ->addArgument(
                [
                    'database_type' => 'mysql',
                    'database_name' => 'bootcamp',
                    'server' => 'localhost',
                    'username' => 'root',
                    'password' => ''
                ]
            );
        $containerBuilder->register('repository.news', '\NewsSite\Repositories\NewsRepository')
            ->addArgument(new Reference('database'));

        $containerBuilder->register('model.news', '\NewsSite\Models\News')
            ->addArgument(new Reference('repository.news'));
        $containerBuilder->register('model.singleNew', '\NewsSite\Models\News')
            ->addArgument(new Reference('repository.news'));

        $containerBuilder->register('twig.loader', '\Twig_Loader_Filesystem')
            ->addArgument('%resource.views%');
        $containerBuilder->register('twig.env', '\Twig_Environment')
            ->addArgument(new Reference('twig.loader'))
            ->addArgument(['cache' => false]);

        return new Container($containerBuilder);
    }
    public function handle($httpMethod, $uri)
    {
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);
        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        $response = '';
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                //http_response_code(404);
                header('HTTP/1.1 404 Not Found');
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                $response = call_user_func_array($handler, $vars);
                break;
        }
        return $response;
    }
    protected function configureRoutes()
    {
        $dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
            $home = new HomeController($this->getContainer());
            $news = new NewsController($this->getContainer());

            $r->addRoute('GET', '/', [$home, 'homeAction']);
            $r->addRoute('GET', '/news', [$news, 'newsAction']);
            $r->addRoute('GET', '/news/{id}', [$news, 'singleNewsAction']);
        });
        return $dispatcher;
    }
}

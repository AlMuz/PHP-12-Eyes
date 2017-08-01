<?php
namespace NewsSite\Controllers;
use NewsSite\ContainerInterface;
abstract class AbstractController implements ControllerInterface
{
    /** @var ContainerInterface */
    protected $container;
    /** @var \Twig_Environment */
    protected $twig;
    public function __construct(ContainerInterface $dependencyContainer)
    {
        $this->container = $dependencyContainer;
        $this->twig = $dependencyContainer->get('twig.env');
    }
    public function render(string $template, array $content = []) : string
    {
        dump($content);
        return $this->twig->render($template, $content);
    }
}
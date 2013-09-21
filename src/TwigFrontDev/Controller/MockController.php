<?php

namespace TwigFrontDev\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 */
class MockController
{

    /**
     *
     * @var array
     */
    protected $pages;

    public function __construct($pages)
    {
        $this->pages = $this->checkAllPagesConfig((array) $pages);
    }

    /**
     * check all mock pages configuration
     * 
     * @param array $pagesConfig
     * 
     * @return array
     */
    protected function checkAllPagesConfig(array $pagesConfig) 
    {
        $cleanPagesConfig = array();
        foreach ($pagesConfig as $route => $config) {
            $cleanPagesConfig[$route] = $this->checkPageConfig($config);
        }
        return $cleanPagesConfig;
    }
    
    /**
     * check mock page configuration
     * 
     * @param array $config
     * 
     * @return array
     */
    protected function checkPageConfig(array $config)
    {
        $config = array_merge(array(
            'name' => '',
            'desc' => '',
            'url' => '',
            'default' => array(),
            'method' => 'get',
            'format' => 'html',
            'status' => 200,
            'template' => '',
            'variables' => array(),
        ), $config);

        $config['status'] = (int) $config['status'];
        
        $method = !empty($config['method']) ? strtolower($config['method']) : 'get';
        $method = in_array($method, array('get', 'post', 'put', 'delete')) ? $method : 'get';
        $config['method'] = $method;

        if (!isset($config['variables']) || !is_array($config['variables'])) {
            $config['variables'] = array();
        }
        
        if (!isset($config['default']) || !is_array($config['default'])) {
            $config['default'] = array();
        }

        if (preg_match('/\{(.+)\}/', $config['url'], $params) !== false ){
            if (!empty($params)) {
                array_shift($params);
                if (!empty($params)) {
                    $defaultParams = array();
                    foreach ($params as $param) {
                        $defaultParams[$param] = '';
                    }
                    $config['default'] = array_merge($defaultParams, $config['default']);
                }
            }
        }
        
        return $config;
    }
    
    /**
     * Mock pages list
     * 
     * @param Request $request
     * @param Application $app
     * 
     * @return Response
     */
    public function indexAction(Request $request, Application $app)
    {
        return new Response(
            $app['twig']->render(
                'TwigFrontDev/index.html.twig', 
                array(
                    'pages' => $this->pages
                )
            )
        );
    }

    /**
     * create all mock pages controllers
     * 
     * @param Application $app
     */
    public function createMockPagesControllers(Application $app)
    {
        foreach ($this->pages as $route => $config) {
            call_user_func(array($app, $config['method']), $config['url'], function (Request $request, Application $app) use ($config) {
                $variables = array_merge($request->get('_route_params'), $config['variables']);
                
                $headers = array();
                switch ($config['format']) {
                    case 'javascript':
                    case 'js':
                        $headers['Content-Type'] = 'application/javascript';
                        break;
                    case 'json':
                        $headers['Content-Type'] = 'application/json';
                        break;
                    case 'css':
                        $headers['Content-Type'] = 'text/css';
                        break;
                    case 'rdf':
                        $headers['Content-Type'] = 'application/rdf+xml';
                        break;
                    case 'atom':
                        $headers['Content-Type'] = 'application/atom+xml';
                        break;
                    case 'rss':
                        $headers['Content-Type'] = 'application/rss+xml';
                        break;
                    case 'xsl':
                    case 'xsd':
                    case 'xliff':
                    case 'xml':
                        $headers['Content-Type'] = 'text/xml';
                        break;
                    case 'txt':
                        $headers['Content-Type'] = 'text/plain';
                        break;
                    case 'html':
                    default:
                        $headers['Content-Type'] = 'text/html';
                        break;
                }
                
                return new Response(
                    $app['twig']->render($config['template'], $variables),
                    $config['status'] ?: 200,
                    $headers
                );
            })->bind($route);
        }
    }
}

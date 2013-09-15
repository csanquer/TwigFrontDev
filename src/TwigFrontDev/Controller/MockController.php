<?php

namespace TwigFrontDev\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

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
        $this->pages = (array) $pages;
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
        var_dump($config);
        $config = array_merge(array(
            'name' => '',
            'desc' => '',
            'url' => '',
            'default' => array(),
            'method' => 'get',
            'template' => '',
            'variables' => array(),
        ), $config);

        $method = !empty($config['method']) ? strtolower($config['method']) : 'get';
        $method = in_array($method, array('get', 'post', 'put', 'delete')) ? $method : 'get';
        $config['method'] = $method;

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
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Silex\Application $app
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, Application $app)
    {
        return $app['twig']->render('TwigFrontDev/index.html.twig', array(
            'pages' => $this->pages
        ));
    }

    /**
     * create all mock pages controllers
     * 
     * @param \Silex\Application $app
     */
    public function createMockPagesControllers(Application $app)
    {
        foreach ($this->pages as $route => $config) {
            $config = $this->checkPageConfig($config);
            
            call_user_func(array($app, $config['method']), $config['url'], function (Request $request, Application $app) use ($config) {
                $variables = array_merge($request->get('_route_params'), $config['variables']);
                
                return $app['twig']->render($config['template'], $variables);
            })->bind($route);
        }
    }
}

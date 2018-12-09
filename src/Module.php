<?php

namespace Gazlab\Admin;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Config;
use Phalcon\Avatar\Gravatar;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Breadcrumbs;
use Phalcon\Logger\Adapter\File as FileLogger;

class Module implements ModuleDefinitionInterface
{
    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'Gazlab\Admin\Controllers' => __DIR__ . '/controllers/',
            'Gazlab\Admin\Models'      => __DIR__ . '/models/',
            'Gazlab'                   => __DIR__ . '/library/',
            'GazlabAdmin'              => __DIR__ . '/components/',
        ])->registerDirs(
            [
                APP_PATH . '/modules/admin/controllers/',
                APP_PATH . '/common/models/'
            ]
        );

        $loader->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        /**
         * Try to load local configuration
         */
        if (file_exists(__DIR__ . '/config/config.php')) {
            
            $config = $di['config'];
            
            $override = new Config(include __DIR__ . '/config/config.php');

            if ($config instanceof Config) {
                $config->merge($override);
            } else {
                $config = $override;
            }

            $pathConfig = APP_PATH . '/modules/admin/config/config.php';
            if (file_exists($pathConfig)){
                $config->merge(include $pathConfig);
            }
        }

        /**
         * Setting up the view component
         */
        $di['view'] = function () {
            $config = $this->getConfig();

            $view = new View();
            $view->setViewsDir($config->get('application')->viewsDir);
            $view->setLayoutsDir(__DIR__ . '/views/layouts/');
            $view->setMainView(__DIR__ . '/views/index');
            
            $view->registerEngines([
                '.volt'  => 'voltShared',
                '.phtml' => PhpEngine::class
            ]);

            return $view;
        };

        /**
         * Database connection is created based in the parameters defined in the configuration file
         */
        $di['db'] = function () {
            $config = $this->getConfig();

            $dbConfig = $config->database->toArray();

            $dbAdapter = '\Phalcon\Db\Adapter\Pdo\\' . $dbConfig['adapter'];
            unset($config['adapter']);

            $connection = new $dbAdapter($dbConfig);

            if (ENVIRONMENT === 'development'){
                $eventsManager = new EventsManager();

                $path = APP_PATH . '/logs';
                @mkdir($path);
                $logger = new FileLogger($path . '/'.date('Ymd').'.log');

                $eventsManager->attach(
                    'db:beforeQuery',
                    function ($event, $connection) use ($logger) {
                        $logger->info(
                            "\n\t[QUERY] " . $connection->getSQLStatement() . (!is_null($connection->getSqlVariables()) ? "\n\t[PARAMS] " . json_encode($connection->getSqlVariables()) : null)
                        );
                    }
                );

                $connection->setEventsManager($eventsManager);
            }

            return $connection;
        };

        $di->setShared('gravatar', function () use ($config) {
            $gravatar = new Gravatar($config->gravatar);
        
            return $gravatar;
        });

        $di->set('flashSession', function () {
            return new FlashSession([
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning'
            ]);
        });

        $di->set('acl', function (){
            $acl = new \Gazlab\Acl();

            $pr = $this->getShared('config')->privateResources->toArray();

            $connection = $this->getShared('db');
            $sql = "SELECT * FROM gazlab_permissions";
            foreach ($connection->fetchAll($sql) as $permission) {
                if (!isset($pr[$permission['resource']])){
                    $pr[$permission['resource']] = [];
                }
                array_push($pr[$permission['resource']], $permission['action']);
            }
            
            $acl->addPrivateResources($pr);
            return $acl;
        });
        
        $di->set(
            'dispatcher',
            function () use ($config){
                $pr = $config->privateResources->toArray();
                
                $eventsManager = new EventsManager();
                
                $eventsManager->attach(
                    'dispatch:beforeDispatchLoop',
                    function (Event $event, MvcDispatcher $dispatcher) use ($pr){
                        if (!in_array($dispatcher->getControllerName(), array_keys($pr))){
                            $dispatcher->setNamespaceName('');
                        }
                    }
                );
        
                $dispatcher = new MvcDispatcher();
        
                // Bind the eventsManager to the view component
                $dispatcher->setEventsManager($eventsManager);
        
                return $dispatcher;
            },
            true
        );

        $di->setShared('breadcrumbs', function () {
            $breadcrumbs = new Breadcrumbs;
            $breadcrumbs->setSeparator('');
            $breadcrumbs->setLastNotLinked(true);

            return $breadcrumbs;
        });
    }
}

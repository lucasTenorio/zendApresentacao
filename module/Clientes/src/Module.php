<?php

namespace Clientes;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

     public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\ClientesTable::class => function($container) {
                    $tableGateway = $container->get(Model\ClientesTableGateway::class);
                    return new Model\ClientesTable($tableGateway);
                },
                Model\ClientesTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Clientes());
                    return new TableGateway('clientes', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }


    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ClientesController::class => function($container) {
                    return new Controller\ClientesController(
                        $container->get(Model\ClientesTable::class)
                    );
                },
            ],
        ];
    }
}



?>
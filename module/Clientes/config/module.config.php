<?php
namespace Clientes;
use Zend\Router\Http\Segment;

return [

    'router' => [
        'routes' => [
            'clientes' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/clientes[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ClientesController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'clientes' => __DIR__ . '/../view',
        ],
    ],
];
?>
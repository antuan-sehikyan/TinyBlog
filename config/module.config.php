<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'TinyBlog\Controller\Index' => 'TinyBlog\Controller\IndexController',
            'TinyBlog\Controller\Category' => 'TinyBlog\Controller\CategoryController',
        ),
    ),
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                'TinyBlog' => __DIR__ . '/../public',
            ),
        ),
    ),    
    'router' => array(
        'routes' => array(
            'tiny-blog' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/tiny-blog[/:action][/:title][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'title' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',                        
                    ),
                    'defaults' => array(
                        'controller' => 'TinyBlog\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'category' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/blog/category[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'TinyBlog\Controller\Category',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'TinyBlog_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/TinyBlog/Entity',
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                   'TinyBlog\Entity' => 'TinyBlog_driver',
                )
            )
        )
    ),
);

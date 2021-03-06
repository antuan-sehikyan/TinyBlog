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
        'template_map' => array(
            'tiny-blog/index/index' => __DIR__ . '/../view/tiny-blog/index/index.phtml',
            'tiny-blog/index/add' => __DIR__ . '/../view/tiny-blog/index/add.phtml',
            'tiny-blog/index/edit' => __DIR__ . '/../view/tiny-blog/index/edit.phtml',
            'tiny-blog/index/delete' => __DIR__ . '/../view/tiny-blog/index/delete.phtml',

            'tiny-blog/category/index' => __DIR__ . '/../view/tiny-blog/category/index.phtml',
            'tiny-blog/category/add' => __DIR__ . '/../view/tiny-blog/category/add.phtml',
            'tiny-blog/category/edit' => __DIR__ . '/../view/tiny-blog/category/edit.phtml',
            'tiny-blog/category/delete' => __DIR__ . '/../view/tiny-blog/category/delete.phtml'
        )
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

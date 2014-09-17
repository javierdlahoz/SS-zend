<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Transaction;

return array(

    'controllers' => array(
        'invokables' => array(
            'Transaction\Controller\Transaction' => 'Transaction\Controller\TransactionController'
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'transactionService' => function ($serviceManager){
                    return new Service\TransactionService($serviceManager);
                },
            'transactionAdapter' => function ($serviceManager){
                    return new Adapter\TransactionAdapter($serviceManager);
                }
        )
    ),

    'router' => array(
        'routes' => array(
            'transaction' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/transaction',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Transaction\Controller',
                        'controller'    => 'Transaction',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            'transaction-rest' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Transaction\Controller',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/:controller',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Campaign;

return array(

    'controllers' => array(
        'invokables' => array(
            'Campaign\Controller\Campaign' => 'Campaign\Controller\CampaignController'
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'campaignService' => function ($serviceManager){
                    return new Service\CampaignService($serviceManager);
                }
        )
    ),

    'router' => array(
        'routes' => array(
            'campaign' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/campaign',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Campaign\Controller',
                        'controller'    => 'Campaign',
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
            'campaign-rest' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Campaign\Controller',
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
    'doctrine' => array(
        'driver' => array(
            'campaign_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Campaign/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Campaign\Entity' =>  'campaign_entity'
                ),
            ),
        ),
    ),
);
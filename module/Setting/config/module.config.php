<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Setting;

return array(

    'controllers' => array(
        'invokables' => array(
            'Setting\Controller\Setting' => 'Setting\Controller\SettingController'
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'settingService' => function ($serviceManager){
                    return new Service\SettingService($serviceManager);
                },
            'customerSettingService' => function ($serviceManager){
                    return new Service\CustomerSettingsService($serviceManager);
                },
            'campaignSettingsService' => function ($serviceManager){
                    return new Service\CampaignSettingsService($serviceManager);
            }
        )
    ),

    'router' => array(
        'routes' => array(
            'setting' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/setting',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Setting\Controller',
                        'controller'    => 'Setting',
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
            'setting-rest' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Setting\Controller',
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
            'setting_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Setting/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Setting\Entity' =>  'setting_entity',
                ),
            ),
        ),
    ),
);
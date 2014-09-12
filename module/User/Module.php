<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User;



use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;


class Module implements AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{

	
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $eventManager->getSharedManager();
    }


    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'zfcuser_register_form' => function ($sm) {
                    $options = $sm->get('zfcuser_module_options');
                    $form = new Validator\Register(null, $options);
                    $form->setInputFilter(new Validator\RegisterFilter(
                        new \ZfcUser\Validator\NoRecordExists(array(
                            'mapper' => $sm->get('zfcuser_user_mapper'),
                            'key'    => 'email'
                        )),
                        new \ZfcUser\Validator\NoRecordExists(array(
                            'mapper' => $sm->get('zfcuser_user_mapper'),
                            'key'    => 'username'
                        )),
                        $options
                    ));
                    return $form;
                },

                'zfcuser_change_password_form' => function ($sm) {
                        $options = $sm->get('zfcuser_module_options');
                        $form = new Validator\ChangePassword(null, $sm->get('zfcuser_module_options'));
                        $form->setInputFilter(new Validator\ChangePasswordFilter($options));
                        return $form;
                },
            )
        );
    }
}
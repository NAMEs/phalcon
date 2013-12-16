<?php

use Phalcon\Events\Event,
    Phalcon\Mvc\User\Plugin,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Acl;

class Security extends Plugin {

    public function __construct($dependencyInjector) {
        $this->_dependencyInjector = $dependencyInjector;
    }

    public function getAcl() {
        if (!isset($this->persistent->acl)) {
            $acl = new Phalcon\Acl\Adapter\Memory();
            $acl->setDefaultAction(Phalcon\Acl::DENY);
            
            // TODO: VER COMO TOMAR DE LA BD.
            
            //Register roles
            $roles = array(
                'administradores' => new Phalcon\Acl\Role('Administradores')
            );
            foreach ($roles as $role) {
                $acl->addRole($role);
            }

            $adminResources = array(
                'proveedores' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
                'direcciones' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
            );
            foreach ($adminResources as $resource => $actions) {
                $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
            }
            
            $publicResources = array(
                'index' => array('index'),
            );
            foreach ($publicResources as $resource => $actions) {
                $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
            }

            //Grant access to public areas to both users and guests
            foreach ($roles as $role) {
                foreach ($publicResources as $resource => $actions) {
                    $acl->allow($role->getName(), $resource, '*');
                }
            }

            //Grant acess to private area to role Users
            foreach ($adminResources as $resource => $actions) {
                foreach ($actions as $action) {
                    $acl->allow('Users', $resource, $action);
                }
            }

            //The acl is stored in session, APC would be useful here too
            $this->persistent->acl = $acl;
        }
        
        return $this->persistent->acl;
    }

    /**
     * This action is executed before execute any action in the application
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher) {

        $auth = $this->session->get('auth');
        if (!$auth) {
            $role = 'Guests';
        } else {
            $role = 'Users';
        }

        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        $acl = $this->getAcl();

        $allowed = $acl->isAllowed($role, $controller, $action);
        if ($allowed != Acl::ALLOW) {
            $this->flash->error("You don't have access to this module");
            $dispatcher->forward(
                    array(
                        'controller' => 'index',
                        'action' => 'index'
                    )
            );
            return false;
        }
    }

}

<?php

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

class RolesController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for roles
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Roles", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "rol_id";

        $roles = Roles::find($parameters);
        if (count($roles) == 0) {
            $this->flash->notice("The search did not find any roles");
            return $this->dispatcher->forward(array(
                "controller" => "roles",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $roles,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displayes the creation form
     */
    public function newAction()
    {
        
    }

    /**
     * Edits a role
     *
     * @param string $rol_id
     */
    public function editAction($rol_id)
    {

        if (!$this->request->isPost()) {

            $role = Roles::findFirstByrol_id($rol_id);
            if (!$role) {
                $this->flash->error("role was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "roles",
                    "action" => "index"
                ));
            }

            $this->view->rol_id = $role->rol_id;

            $this->tag->setDefault("rol_id", $role->rol_id);
            $this->tag->setDefault("rol_nombre", $role->rol_nombre);
            
        }
    }

    /**
     * Creates a new role
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "roles",
                "action" => "index"
            ));
        }

        $role = new Roles();

        $role->rol_id = $this->request->getPost("rol_id");
        $role->rol_nombre = $this->request->getPost("rol_nombre");
        

        if (!$role->save()) {
            foreach ($role->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "roles",
                "action" => "new"
            ));
        }

        $this->flash->success("role was created successfully");
        return $this->dispatcher->forward(array(
            "controller" => "roles",
            "action" => "index"
        ));

    }

    /**
     * Saves a role edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "roles",
                "action" => "index"
            ));
        }

        $rol_id = $this->request->getPost("rol_id");

        $role = Roles::findFirstByrol_id($rol_id);
        if (!$role) {
            $this->flash->error("role does not exist " . $rol_id);
            return $this->dispatcher->forward(array(
                "controller" => "roles",
                "action" => "index"
            ));
        }

        $role->rol_id = $this->request->getPost("rol_id");
        $role->rol_nombre = $this->request->getPost("rol_nombre");
        

        if (!$role->save()) {

            foreach ($role->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "roles",
                "action" => "edit",
                "params" => array($role->rol_id)
            ));
        }

        $this->flash->success("role was updated successfully");
        return $this->dispatcher->forward(array(
            "controller" => "roles",
            "action" => "index"
        ));

    }

    /**
     * Deletes a role
     *
     * @param string $rol_id
     */
    public function deleteAction($rol_id)
    {

        $role = Roles::findFirstByrol_id($rol_id);
        if (!$role) {
            $this->flash->error("role was not found");
            return $this->dispatcher->forward(array(
                "controller" => "roles",
                "action" => "index"
            ));
        }

        if (!$role->delete()) {

            foreach ($role->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "roles",
                "action" => "search"
            ));
        }

        $this->flash->success("role was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "roles",
            "action" => "index"
        ));
    }

}

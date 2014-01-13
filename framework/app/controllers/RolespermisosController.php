<?php

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

class RolesPermisosController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for roles_permisos
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "RolesPermisos", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");            
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "rol_permiso_id";

        $roles_permisos = RolesPermisos::find($parameters);
        if (count($roles_permisos) == 0) {
            $this->flash->notice("The search did not find any roles_permisos");
            return $this->dispatcher->forward(array(
                "controller" => "roles_permisos",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $roles_permisos,
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
     * Edits a roles_permiso
     *
     * @param string $rol_permiso_id
     */
    public function editAction($rol_permiso_id)
    {

        if (!$this->request->isPost()) {

            $roles_permiso = RolesPermisos::findFirstById($rol_permiso_id);
            if (!$roles_permiso) {
                $this->flash->error("roles_permiso was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "roles_permisos",
                    "action" => "index"
                ));
            }

            $this->view->rol_permiso_id = $roles_permiso->rol_permiso_id;

            $this->tag->setDefault("rol_permiso_id", $roles_permiso->rol_permiso_id);
            $this->tag->setDefault("rol_id", $roles_permiso->rol_id);
            $this->tag->setDefault("permiso_id", $roles_permiso->permiso_id);
            
        }
    }

    /**
     * Creates a new roles_permiso
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "roles_permisos",
                "action" => "index"
            ));
        }

        $roles_permiso = new RolesPermisos();

        $roles_permiso->rol_permiso_id = $this->request->getPost("rol_permiso_id");
        $roles_permiso->rol_id = $this->request->getPost("rol_id");
        $roles_permiso->permiso_id = $this->request->getPost("permiso_id");
        

        if (!$roles_permiso->save()) {
            foreach ($roles_permiso->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "roles_permisos",
                "action" => "new"
            ));
        }

        $this->flash->success("roles_permiso was created successfully");
        return $this->dispatcher->forward(array(
            "controller" => "roles_permisos",
            "action" => "index"
        ));

    }

    /**
     * Saves a roles_permiso edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "roles_permisos",
                "action" => "index"
            ));
        }

        $rol_permiso_id = $this->request->getPost("rol_permiso_id");

        $roles_permiso = RolesPermisos::findFirstByrol_permiso_id($rol_permiso_id);
        if (!$roles_permiso) {
            $this->flash->error("roles_permiso does not exist " . $rol_permiso_id);
            return $this->dispatcher->forward(array(
                "controller" => "roles_permisos",
                "action" => "index"
            ));
        }

        $roles_permiso->rol_permiso_id = $this->request->getPost("rol_permiso_id");
        $roles_permiso->rol_id = $this->request->getPost("rol_id");
        $roles_permiso->permiso_id = $this->request->getPost("permiso_id");
        

        if (!$roles_permiso->save()) {

            foreach ($roles_permiso->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "roles_permisos",
                "action" => "edit",
                "params" => array($roles_permiso->rol_permiso_id)
            ));
        }

        $this->flash->success("roles_permiso was updated successfully");
        return $this->dispatcher->forward(array(
            "controller" => "roles_permisos",
            "action" => "index"
        ));

    }

    /**
     * Deletes a roles_permiso
     *
     * @param string $rol_permiso_id
     */
    public function deleteAction($rol_permiso_id)
    {

        $roles_permiso = RolesPermisos::findFirstByrol_permiso_id($rol_permiso_id);
        if (!$roles_permiso) {
            $this->flash->error("roles_permiso was not found");
            return $this->dispatcher->forward(array(
                "controller" => "roles_permisos",
                "action" => "index"
            ));
        }

        if (!$roles_permiso->delete()) {

            foreach ($roles_permiso->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "roles_permisos",
                "action" => "search"
            ));
        }

        $this->flash->success("roles_permiso was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "roles_permisos",
            "action" => "index"
        ));
    }

}

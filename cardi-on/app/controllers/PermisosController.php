<?php

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

class PermisosController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for permisos
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Permisos", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "permiso_id";

        $permisos = Permisos::find($parameters);
        if (count($permisos) == 0) {
            $this->flash->notice("The search did not find any permisos");
            return $this->dispatcher->forward(array(
                "controller" => "permisos",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $permisos,
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
     * Edits a permiso
     *
     * @param string $permiso_id
     */
    public function editAction($permiso_id)
    {

        if (!$this->request->isPost()) {

            $permiso = Permisos::findFirstBypermiso_id($permiso_id);
            if (!$permiso) {
                $this->flash->error("permiso was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "permisos",
                    "action" => "index"
                ));
            }

            $this->view->permiso_id = $permiso->permiso_id;

            $this->tag->setDefault("permiso_id", $permiso->permiso_id);
            $this->tag->setDefault("permiso_nombre", $permiso->permiso_nombre);
            $this->tag->setDefault("permiso_descripcion", $permiso->permiso_descripcion);
            $this->tag->setDefault("permiso_controller", $permiso->permiso_controller);
            $this->tag->setDefault("permiso_accion", $permiso->permiso_accion);
            
        }
    }

    /**
     * Creates a new permiso
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "permisos",
                "action" => "index"
            ));
        }

        $permiso = new Permisos();

        $permiso->permiso_id = $this->request->getPost("permiso_id");
        $permiso->permiso_nombre = $this->request->getPost("permiso_nombre");
        $permiso->permiso_descripcion = $this->request->getPost("permiso_descripcion");
        $permiso->permiso_controller = $this->request->getPost("permiso_controller");
        $permiso->permiso_accion = $this->request->getPost("permiso_accion");
        

        if (!$permiso->save()) {
            foreach ($permiso->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "permisos",
                "action" => "new"
            ));
        }

        $this->flash->success("permiso was created successfully");
        return $this->dispatcher->forward(array(
            "controller" => "permisos",
            "action" => "index"
        ));

    }

    /**
     * Saves a permiso edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "permisos",
                "action" => "index"
            ));
        }

        $permiso_id = $this->request->getPost("permiso_id");

        $permiso = Permisos::findFirstBypermiso_id($permiso_id);
        if (!$permiso) {
            $this->flash->error("permiso does not exist " . $permiso_id);
            return $this->dispatcher->forward(array(
                "controller" => "permisos",
                "action" => "index"
            ));
        }

        $permiso->permiso_id = $this->request->getPost("permiso_id");
        $permiso->permiso_nombre = $this->request->getPost("permiso_nombre");
        $permiso->permiso_descripcion = $this->request->getPost("permiso_descripcion");
        $permiso->permiso_controller = $this->request->getPost("permiso_controller");
        $permiso->permiso_accion = $this->request->getPost("permiso_accion");
        

        if (!$permiso->save()) {

            foreach ($permiso->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "permisos",
                "action" => "edit",
                "params" => array($permiso->permiso_id)
            ));
        }

        $this->flash->success("permiso was updated successfully");
        return $this->dispatcher->forward(array(
            "controller" => "permisos",
            "action" => "index"
        ));

    }

    /**
     * Deletes a permiso
     *
     * @param string $permiso_id
     */
    public function deleteAction($permiso_id)
    {

        $permiso = Permisos::findFirstBypermiso_id($permiso_id);
        if (!$permiso) {
            $this->flash->error("permiso was not found");
            return $this->dispatcher->forward(array(
                "controller" => "permisos",
                "action" => "index"
            ));
        }

        if (!$permiso->delete()) {

            foreach ($permiso->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "permisos",
                "action" => "search"
            ));
        }

        $this->flash->success("permiso was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "permisos",
            "action" => "index"
        ));
    }

}

<?php

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

class ProveedoresDireccionesController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for proveedores_direcciones
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "ProveedoresDirecciones", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "proveedor_direccion_id";

        $proveedores_direcciones = ProveedoresDirecciones::find($parameters);
        if (count($proveedores_direcciones) == 0) {
            $this->flash->notice("The search did not find any proveedores_direcciones");
            return $this->dispatcher->forward(array(
                "controller" => "proveedores_direcciones",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $proveedores_direcciones,
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
     * Edits a proveedores_direccione
     *
     * @param string $proveedor_direccion_id
     */
    public function editAction($proveedor_direccion_id)
    {

        if (!$this->request->isPost()) {

            $proveedores_direccione = ProveedoresDirecciones::findFirstByproveedor_direccion_id($proveedor_direccion_id);
            if (!$proveedores_direccione) {
                $this->flash->error("proveedores_direccione was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "proveedores_direcciones",
                    "action" => "index"
                ));
            }

            $this->view->proveedor_direccion_id = $proveedores_direccione->proveedor_direccion_id;

            $this->tag->setDefault("proveedor_direccion_id", $proveedores_direccione->proveedor_direccion_id);
            $this->tag->setDefault("proveedor_id", $proveedores_direccione->proveedor_id);
            $this->tag->setDefault("direccion_id", $proveedores_direccione->direccion_id);
            
        }
    }

    /**
     * Creates a new proveedores_direccione
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "proveedores_direcciones",
                "action" => "index"
            ));
        }

        $proveedores_direccione = new ProveedoresDirecciones();

        $proveedores_direccione->proveedor_direccion_id = $this->request->getPost("proveedor_direccion_id");
        $proveedores_direccione->proveedor_id = $this->request->getPost("proveedor_id");
        $proveedores_direccione->direccion_id = $this->request->getPost("direccion_id");
        

        if (!$proveedores_direccione->save()) {
            foreach ($proveedores_direccione->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "proveedores_direcciones",
                "action" => "new"
            ));
        }

        $this->flash->success("proveedores_direccione was created successfully");
        return $this->dispatcher->forward(array(
            "controller" => "proveedores_direcciones",
            "action" => "index"
        ));

    }

    /**
     * Saves a proveedores_direccione edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "proveedores_direcciones",
                "action" => "index"
            ));
        }

        $proveedor_direccion_id = $this->request->getPost("proveedor_direccion_id");

        $proveedores_direccione = ProveedoresDirecciones::findFirstByproveedor_direccion_id($proveedor_direccion_id);
        if (!$proveedores_direccione) {
            $this->flash->error("proveedores_direccione does not exist " . $proveedor_direccion_id);
            return $this->dispatcher->forward(array(
                "controller" => "proveedores_direcciones",
                "action" => "index"
            ));
        }

        $proveedores_direccione->proveedor_direccion_id = $this->request->getPost("proveedor_direccion_id");
        $proveedores_direccione->proveedor_id = $this->request->getPost("proveedor_id");
        $proveedores_direccione->direccion_id = $this->request->getPost("direccion_id");
        

        if (!$proveedores_direccione->save()) {

            foreach ($proveedores_direccione->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "proveedores_direcciones",
                "action" => "edit",
                "params" => array($proveedores_direccione->proveedor_direccion_id)
            ));
        }

        $this->flash->success("proveedores_direccione was updated successfully");
        return $this->dispatcher->forward(array(
            "controller" => "proveedores_direcciones",
            "action" => "index"
        ));

    }

    /**
     * Deletes a proveedores_direccione
     *
     * @param string $proveedor_direccion_id
     */
    public function deleteAction($proveedor_direccion_id)
    {

        $proveedores_direccione = ProveedoresDirecciones::findFirstByproveedor_direccion_id($proveedor_direccion_id);
        if (!$proveedores_direccione) {
            $this->flash->error("proveedores_direccione was not found");
            return $this->dispatcher->forward(array(
                "controller" => "proveedores_direcciones",
                "action" => "index"
            ));
        }

        if (!$proveedores_direccione->delete()) {

            foreach ($proveedores_direccione->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "proveedores_direcciones",
                "action" => "search"
            ));
        }

        $this->flash->success("proveedores_direccione was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "proveedores_direcciones",
            "action" => "index"
        ));
    }

}

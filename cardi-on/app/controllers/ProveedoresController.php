<?php

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

class ProveedoresController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for proveedores
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Proveedores", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "proveedor_id";

        $proveedores = Proveedores::find($parameters);
        if (count($proveedores) == 0) {
            $this->flash->notice("The search did not find any proveedores");
            return $this->dispatcher->forward(array(
                "controller" => "proveedores",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $proveedores,
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
     * Edits a proveedore
     *
     * @param string $proveedor_id
     */
    public function editAction($proveedor_id)
    {

        if (!$this->request->isPost()) {

            $proveedore = Proveedores::findFirstByproveedor_id($proveedor_id);
            if (!$proveedore) {
                $this->flash->error("proveedore was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "proveedores",
                    "action" => "index"
                ));
            }

            $this->view->proveedor_id = $proveedore->proveedor_id;

            $this->tag->setDefault("proveedor_id", $proveedore->proveedor_id);
            $this->tag->setDefault("proveedor_nombre", $proveedore->proveedor_nombre);
            $this->tag->setDefault("proveedor_email", $proveedore->proveedor_email);
            $this->tag->setDefault("proveedor_telefono", $proveedore->proveedor_telefono);
            $this->tag->setDefault("proveedor_celular", $proveedore->proveedor_celular);
            
        }
    }

    /**
     * Creates a new proveedore
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "proveedores",
                "action" => "index"
            ));
        }

        $proveedore = new Proveedores();

        $proveedore->proveedor_id = $this->request->getPost("proveedor_id");
        $proveedore->proveedor_nombre = $this->request->getPost("proveedor_nombre");
        $proveedore->proveedor_email = $this->request->getPost("proveedor_email");
        $proveedore->proveedor_telefono = $this->request->getPost("proveedor_telefono");
        $proveedore->proveedor_celular = $this->request->getPost("proveedor_celular");
        

        if (!$proveedore->save()) {
            foreach ($proveedore->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "proveedores",
                "action" => "new"
            ));
        }

        $this->flash->success("proveedore was created successfully");
        return $this->dispatcher->forward(array(
            "controller" => "proveedores",
            "action" => "index"
        ));

    }

    /**
     * Saves a proveedore edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "proveedores",
                "action" => "index"
            ));
        }

        $proveedor_id = $this->request->getPost("proveedor_id");

        $proveedore = Proveedores::findFirstByproveedor_id($proveedor_id);
        if (!$proveedore) {
            $this->flash->error("proveedore does not exist " . $proveedor_id);
            return $this->dispatcher->forward(array(
                "controller" => "proveedores",
                "action" => "index"
            ));
        }

        $proveedore->proveedor_id = $this->request->getPost("proveedor_id");
        $proveedore->proveedor_nombre = $this->request->getPost("proveedor_nombre");
        $proveedore->proveedor_email = $this->request->getPost("proveedor_email");
        $proveedore->proveedor_telefono = $this->request->getPost("proveedor_telefono");
        $proveedore->proveedor_celular = $this->request->getPost("proveedor_celular");
        

        if (!$proveedore->save()) {

            foreach ($proveedore->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "proveedores",
                "action" => "edit",
                "params" => array($proveedore->proveedor_id)
            ));
        }

        $this->flash->success("proveedore was updated successfully");
        return $this->dispatcher->forward(array(
            "controller" => "proveedores",
            "action" => "index"
        ));

    }

    /**
     * Deletes a proveedore
     *
     * @param string $proveedor_id
     */
    public function deleteAction($proveedor_id)
    {

        $proveedore = Proveedores::findFirstByproveedor_id($proveedor_id);
        if (!$proveedore) {
            $this->flash->error("proveedore was not found");
            return $this->dispatcher->forward(array(
                "controller" => "proveedores",
                "action" => "index"
            ));
        }

        if (!$proveedore->delete()) {

            foreach ($proveedore->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "proveedores",
                "action" => "search"
            ));
        }

        $this->flash->success("proveedore was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "proveedores",
            "action" => "index"
        ));
    }

}

<?php

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

class DireccionesController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for direcciones
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Direcciones", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "direccion_id";

        $direcciones = Direcciones::find($parameters);
        if (count($direcciones) == 0) {
            $this->flash->notice("The search did not find any direcciones");
            return $this->dispatcher->forward(array(
                "controller" => "direcciones",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $direcciones,
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
     * Edits a direccione
     *
     * @param string $direccion_id
     */
    public function editAction($direccion_id)
    {

        if (!$this->request->isPost()) {

            $direccione = Direcciones::findFirstBydireccion_id($direccion_id);
            if (!$direccione) {
                $this->flash->error("direccione was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "direcciones",
                    "action" => "index"
                ));
            }

            $this->view->direccion_id = $direccione->direccion_id;

            $this->tag->setDefault("direccion_id", $direccione->direccion_id);
            $this->tag->setDefault("direccion_pais", $direccione->direccion_pais);
            $this->tag->setDefault("direccion_provincia", $direccione->direccion_provincia);
            $this->tag->setDefault("direccion_localidad", $direccione->direccion_localidad);
            $this->tag->setDefault("direccion_calle", $direccione->direccion_calle);
            $this->tag->setDefault("direccion_coordx", $direccione->direccion_coordx);
            $this->tag->setDefault("direccion_coordy", $direccione->direccion_coordy);
            $this->tag->setDefault("direccion_coord", $direccione->direccion_coord);
            
        }
    }

    /**
     * Creates a new direccione
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "direcciones",
                "action" => "index"
            ));
        }

        $direccione = new Direcciones();

        $direccione->direccion_id = $this->request->getPost("direccion_id");
        $direccione->direccion_pais = $this->request->getPost("direccion_pais");
        $direccione->direccion_provincia = $this->request->getPost("direccion_provincia");
        $direccione->direccion_localidad = $this->request->getPost("direccion_localidad");
        $direccione->direccion_calle = $this->request->getPost("direccion_calle");
        $direccione->direccion_coordx = $this->request->getPost("direccion_coordx");
        $direccione->direccion_coordy = $this->request->getPost("direccion_coordy");
        $direccione->direccion_coord = $this->request->getPost("direccion_coord");
        

        if (!$direccione->save()) {
            foreach ($direccione->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "direcciones",
                "action" => "new"
            ));
        }

        $this->flash->success("direccione was created successfully");
        return $this->dispatcher->forward(array(
            "controller" => "direcciones",
            "action" => "index"
        ));

    }

    /**
     * Saves a direccione edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "direcciones",
                "action" => "index"
            ));
        }

        $direccion_id = $this->request->getPost("direccion_id");

        $direccione = Direcciones::findFirstBydireccion_id($direccion_id);
        if (!$direccione) {
            $this->flash->error("direccione does not exist " . $direccion_id);
            return $this->dispatcher->forward(array(
                "controller" => "direcciones",
                "action" => "index"
            ));
        }

        $direccione->direccion_id = $this->request->getPost("direccion_id");
        $direccione->direccion_pais = $this->request->getPost("direccion_pais");
        $direccione->direccion_provincia = $this->request->getPost("direccion_provincia");
        $direccione->direccion_localidad = $this->request->getPost("direccion_localidad");
        $direccione->direccion_calle = $this->request->getPost("direccion_calle");
        $direccione->direccion_coordx = $this->request->getPost("direccion_coordx");
        $direccione->direccion_coordy = $this->request->getPost("direccion_coordy");
        $direccione->direccion_coord = $this->request->getPost("direccion_coord");
        

        if (!$direccione->save()) {

            foreach ($direccione->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "direcciones",
                "action" => "edit",
                "params" => array($direccione->direccion_id)
            ));
        }

        $this->flash->success("direccione was updated successfully");
        return $this->dispatcher->forward(array(
            "controller" => "direcciones",
            "action" => "index"
        ));

    }

    /**
     * Deletes a direccione
     *
     * @param string $direccion_id
     */
    public function deleteAction($direccion_id)
    {

        $direccione = Direcciones::findFirstBydireccion_id($direccion_id);
        if (!$direccione) {
            $this->flash->error("direccione was not found");
            return $this->dispatcher->forward(array(
                "controller" => "direcciones",
                "action" => "index"
            ));
        }

        if (!$direccione->delete()) {

            foreach ($direccione->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "direcciones",
                "action" => "search"
            ));
        }

        $this->flash->success("direccione was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "direcciones",
            "action" => "index"
        ));
    }

}

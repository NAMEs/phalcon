<?php

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

class UsuariosController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for usuarios
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Usuarios", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");            
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "usuario_id";

        $usuarios = Usuarios::find($parameters);
        if (count($usuarios) == 0) {
            $this->flash->notice("The search did not find any usuarios");
            return $this->dispatcher->forward(array(
                "controller" => "usuarios",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $usuarios,
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
     * Edits a usuario
     *
     * @param string $usuario_id
     */
    public function editAction($usuario_id)
    {

        if (!$this->request->isPost()) {

            $usuario = Usuarios::findFirstById($usuario_id);
            if (!$usuario) {
                $this->flash->error("usuario was not found");
                return $this->dispatcher->forward(array(
                    "controller" => "usuarios",
                    "action" => "index"
                ));
            }

            $this->view->usuario_id = $usuario->usuario_id;

            $this->tag->setDefault("usuario_id", $usuario->usuario_id);
            $this->tag->setDefault("usuario_rol", $usuario->usuario_rol);
            $this->tag->setDefault("usuario_nombre", $usuario->usuario_nombre);
            $this->tag->setDefault("usuario_login", $usuario->usuario_login);
            $this->tag->setDefault("usuario_password", $usuario->usuario_password);
            $this->tag->setDefault("usuario_password_new", $usuario->usuario_password);
            $this->tag->setDefault("usuario_password_new_confirm", $usuario->usuario_password);
            
        }
    }

    /**
     * Creates a new usuario
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "usuarios",
                "action" => "index"
            ));
        }

        $usuario = new Usuarios();

        $usuario->usuario_id = $this->request->getPost("usuario_id");
        $usuario->usuario_rol = $this->request->getPost("usuario_rol");
        $usuario->usuario_nombre = $this->request->getPost("usuario_nombre");
        $usuario->usuario_login = $this->request->getPost("usuario_login");
        $usuario->usuario_password = sha1($this->request->getPost("usuario_password"));
        

        if (!$usuario->save()) {
            foreach ($usuario->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "usuarios",
                "action" => "new"
            ));
        }

        $this->flash->success("usuario was created successfully");
        return $this->dispatcher->forward(array(
            "controller" => "usuarios",
            "action" => "index"
        ));

    }

    /**
     * Saves a usuario edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "usuarios",
                "action" => "index"
            ));
        }

        $usuario_id = $this->request->getPost("usuario_id");

        $usuario = Usuarios::findFirstByusuario_id($usuario_id);
        if (!$usuario) {
            $this->flash->error("usuario does not exist " . $usuario_id);
            return $this->dispatcher->forward(array(
                "controller" => "usuarios",
                "action" => "index"
            ));
        }

        $usuario->usuario_id = $this->request->getPost("usuario_id");
        $usuario->usuario_rol = $this->request->getPost("usuario_rol");
        $usuario->usuario_nombre = $this->request->getPost("usuario_nombre");
        $usuario->usuario_login = $this->request->getPost("usuario_login");
        $usuario->usuario_password = sha1($this->request->getPost("usuario_password"));
        

        if (!$usuario->save()) {

            foreach ($usuario->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "usuarios",
                "action" => "edit",
                "params" => array($usuario->usuario_id)
            ));
        }

        $this->flash->success("usuario was updated successfully");
        return $this->dispatcher->forward(array(
            "controller" => "usuarios",
            "action" => "index"
        ));

    }

    /**
     * Deletes a usuario
     *
     * @param string $usuario_id
     */
    public function deleteAction($usuario_id)
    {

        $usuario = Usuarios::findFirstByusuario_id($usuario_id);
        if (!$usuario) {
            $this->flash->error("usuario was not found");
            return $this->dispatcher->forward(array(
                "controller" => "usuarios",
                "action" => "index"
            ));
        }

        if (!$usuario->delete()) {

            foreach ($usuario->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "usuarios",
                "action" => "search"
            ));
        }

        $this->flash->success("usuario was deleted successfully");
        return $this->dispatcher->forward(array(
            "controller" => "usuarios",
            "action" => "index"
        ));
    }

}

<?php


class Permisos extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $permiso_id;
     
    /**
     *
     * @var string
     */
    public $permiso_nombre;
     
    /**
     *
     * @var string
     */
    public $permiso_descripcion;
     
    /**
     *
     * @var string
     */
    public $permiso_controller;
     
    /**
     *
     * @var string
     */
    public $permiso_accion;
    
    public function initialize() {
        $this->hasMany("permiso_id", "RolesPermisos", "permiso_id");
    }
     
}

<?php


class Roles extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $rol_id;
     
    /**
     *
     * @var string
     */
    public $rol_nombre;
    
    public function initialize() {
        $this->hasMany("rol_id", "RolesPermisos", "rol_id");
    }    
     
}

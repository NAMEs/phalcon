<?php


class RolesPermisos extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $rol_permiso_id;
     
    /**
     *
     * @var integer
     */
    public $rol_id;
     
    /**
     *
     * @var integer
     */
    public $permiso_id;
    
    public function initialize() {
        $this->belongsTo("rol_id", "Roles", "rol_id");
        $this->belongsTo("permiso_id", "Permisos", "permiso_id");
    }    
     
}

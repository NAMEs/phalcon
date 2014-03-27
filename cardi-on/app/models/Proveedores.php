<?php

class Proveedores extends \Phalcon\Mvc\Model {

    /**
     *
     * @var integer
     */
    public $proveedor_id;

    /**
     *
     * @var string
     */
    public $proveedor_nombre;

    /**
     *
     * @var string
     */
    public $proveedor_email;

    /**
     *
     * @var string
     */
    public $proveedor_telefono;

    /**
     *
     * @var string
     */
    public $proveedor_celular;

    public function initialize() {
        $this->hasMany("proveedor_id", "ProveedoresDirecciones", "proveedor_id");
    }
    
    public function getProveedorDirecciones($parameters=null)
    {
        return $this->getRelated('ProveedoresDirecciones', $parameters);
    }    

}

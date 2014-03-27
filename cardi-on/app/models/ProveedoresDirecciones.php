<?php

class ProveedoresDirecciones extends \Phalcon\Mvc\Model {

    /**
     *
     * @var integer
     */
    public $proveedor_direccion_id;

    /**
     *
     * @var integer
     */
    public $proveedor_id;

    /**
     *
     * @var integer
     */
    public $direccion_id;

    public function initialize() {
        $this->belongsTo("proveedor_id", "Proveedores", "proveedor_id");
        $this->belongsTo("direccion_id", "Direcciones", "direccion_id");
    }

}

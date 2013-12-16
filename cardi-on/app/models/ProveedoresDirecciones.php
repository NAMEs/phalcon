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
        $this->belongsTo("proveedor_id", "Proveedores", "proveedor_id", array(
            "foreignKey" => true
        ));

        $this->belongsTo("direccion_id", "Direcciones", "direccion_id", array(
            "foreignKey" => array(
                "message" => "The direccion_id does not exist on the Direcciones model"
            )
        ));
    }

}

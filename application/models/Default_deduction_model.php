<?php

class Default_deduction_model extends CORE_Model {
    protected  $table="default_deduction";
    protected  $pk_id="default_deduction_id";
    protected  $fk_id="default_id";

    function __construct() {
        parent::__construct();
    }

    function get_check_seq($default_id){
        $sql="SELECT * FROM default_deduction WHERE default_id = $default_id";
        return $this->db->query($sql)->result();
    } 
}
?>
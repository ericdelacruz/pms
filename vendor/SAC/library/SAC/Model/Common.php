<?php
namespace SAC\Model;

class Common {
    protected $_objDAO;
    protected $_arrDAO;
    
    public function setMultipleDAO($arrDAO) {
        $this->_arrDAO = $arrDAO;
    }

    public function setDAO($objDAO) {
        $this->_objDAO = $objDAO;
    }
}
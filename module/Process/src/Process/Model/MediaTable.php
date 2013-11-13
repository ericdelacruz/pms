<?php
namespace Process\Model;

use Zend\Db\TableGateway\TableGateway;

class MediaTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getMedia($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('mediaId' => $id));
        $row = $rowset->current();
        if (!$row) {
        	//add error handling
            //throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveMedia(Media $media)
    {
        $data = array(
            'processId'  => $media->processId,
        	'originalFilename'  => $media->originalFilename,
        	'filename'  => $media->filename,
        	'path'  => $media->path,
        );

        $id = (int)$media->mediaId;
        if ($id == 0) { //new media
            $this->tableGateway->insert($data);
            return $this->tableGateway->lastInsertValue; //return id
        } else {
            if ($this->getMedia($id)) {
                $this->tableGateway->update($data, array('mediaId' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteMedia($id)
    {
        $this->tableGateway->delete(array('mediaId' => $id));
    }
    
    public function fetchAllByField($strField, $strValue)
    {
    	$arrResults = $this->tableGateway->select(array($strField => $strValue));
    	if (!$arrResults) {
    		//add error handling
    		//throw new \Exception("Could not find row $strValue");
    	}
    	return $arrResults;
    }
    
    public function deleteAllByField($strField, $strValue)
    {
    	$arrResults = $this->tableGateway->delete(array($strField => $strValue));
    }
}
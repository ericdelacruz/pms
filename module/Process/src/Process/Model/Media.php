<?php
namespace Process\Model;

class Media
{
    public $mediaId;
    public $processId;
    public $originalFilename;
    public $filename;
    public $path;

    public function exchangeArray($data)
    {
        $this->mediaId = (isset($data['mediaId'])) ? $data['mediaId'] : null;
        $this->processId = (isset($data['processId'])) ? $data['processId'] : null;
        $this->originalFilename = (isset($data['originalFilename'])) ? $data['originalFilename'] : null;
        $this->filename = (isset($data['filename'])) ? $data['filename'] : null;
        $this->path = (isset($data['path'])) ? $data['path'] : null;
    }
    
    public function getArrayCopy()
    {
    	return get_object_vars($this);
    }
    
    private function _inputFilter($field) {
    	
    }
}
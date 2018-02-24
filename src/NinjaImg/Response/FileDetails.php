<?php

namespace NinjaImg\Response;

class FileDetails
{

    protected $fileDetails;

    public function __construct(array $fileDetails)
    {
        $this->fileDetails = $fileDetails;
    }

    public function getName()
    {
        return $this->fileDetails['name'];
    }

    public function getSize()
    {
        return $this->fileDetails['size'];
    }

    public function getMime()
    {
        return $this->fileDetails['mime'];
    }

    public function getExtension()
    {
        return $this->fileDetails['extension'];
    }

    public function getOriginalMime()
    {
        return isset($this->fileDetails['original_mime']) ? $this->fileDetails['original_mime'] : null;
    }

    public function getOriginalSize()
    {
        return isset($this->fileDetails['original_size']) ? $this->fileDetails['original_size'] : null;
    }

    public function toArray()
    {
        return $this->fileDetails;
    }

}
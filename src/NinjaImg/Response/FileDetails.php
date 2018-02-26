<?php

namespace NinjaImg\Response;

class FileDetails
{

    protected $fileDetails;

    public function __construct(array $fileDetails)
    {
        $this->fileDetails = $fileDetails;
    }

    /**
     * Get file name
     *
     * @return string
     */
    public function getName()
    {
        return $this->fileDetails['name'];
    }

    /**
     * Get file size
     *
     * @return int
     */
    public function getSize()
    {
        return (int)$this->fileDetails['size'];
    }

    /**
     * Get mime type
     *
     * @return string
     */
    public function getMime()
    {
        return $this->fileDetails['mime'];
    }

    /**
     * Get file extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->fileDetails['extension'];
    }

    /**
     * Get original mime type.
     * Note: only available when converting files.
     *
     * @return string|null
     */
    public function getOriginalMime()
    {
        return isset($this->fileDetails['original_mime']) ? $this->fileDetails['original_mime'] : null;
    }

    /**
     * Get original file size.
     * Note: only available when converting files.
     *
     * @return int|null
     */
    public function getOriginalSize()
    {
        return isset($this->fileDetails['original_size']) ? $this->fileDetails['original_size'] : null;
    }

    /**
     * Get image width
     *
     * @return int|null
     */
    public function getWidth()
    {
        return isset($this->fileDetails['width']) ? $this->fileDetails['width'] : null;
    }

    /**
     * Get image height
     *
     * @return int|null
     */
    public function getHeight()
    {
        return isset($this->fileDetails['height']) ? $this->fileDetails['height'] : null;
    }

    /**
     * Get array
     * @return array
     */
    public function toArray()
    {
        return $this->fileDetails;
    }

}
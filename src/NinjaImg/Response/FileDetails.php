<?php

namespace NinjaImg\Response;

class FileDetails
{

    protected array $fileDetails;

    public function __construct(array $fileDetails)
    {
        $this->fileDetails = $fileDetails;
    }

    /**
     * Get file name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->fileDetails['name'];
    }

    /**
     * Get file size
     *
     * @return int
     */
    public function getSize(): int
    {
        return (int)$this->fileDetails['size'];
    }

    /**
     * Get mime type
     *
     * @return string
     */
    public function getMime(): string
    {
        return $this->fileDetails['mime'];
    }

    /**
     * Get file extension
     *
     * @return string
     */
    public function getExtension(): string
    {
        return $this->fileDetails['extension'];
    }

    /**
     * Get original mime type.
     * Note: only available when converting files.
     *
     * @return string|null
     */
    public function getOriginalMime(): ?string
    {
        return $this->fileDetails['original_mime'] ?? null;
    }

    /**
     * Get original file size.
     * Note: only available when converting files.
     *
     * @return int|null
     */
    public function getOriginalSize(): ?int
    {
        return $this->fileDetails['original_size'] ?? null;
    }

    /**
     * Get image width
     *
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->fileDetails['width'] ?? null;
    }

    /**
     * Get image height
     *
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->fileDetails['height'] ?? null;
    }

    /**
     * Get array
     * @return array
     */
    public function toArray(): array
    {
        return $this->fileDetails;
    }

}
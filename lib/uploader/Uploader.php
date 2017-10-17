<?php

namespace Uploader;

/**
 * Parent class, witch describes acceptable extension,
 * file size and methods that check these parameters.
 */
class Uploader
{
    const MAX_FILE_SIZE = 15 * 1024*1024*8;  // 15MB

    // Acceptable MIME-types
    const MIME_TYPES = array(
        'image/jpg',
        'image/png',
        'image/jpeg',
        'image/gif'
    );

    const UPLOAD_DIR = 'upload/';

    protected $fileSize;
    protected $fileMimeType;
    protected $filePath;
    protected $fileName;

    /**
     * Check extension
     */
    protected function checkExtension()
    {
        if ( !in_array($this->fileMimeType, self::MIME_TYPES) ) {
            throw new \Exception("Wrong file type.");
        }
    }

    /**
     * Check file size
     */
    protected function checkSize()
    {
        if ($this->fileSize > self::MAX_FILE_SIZE) {
            throw new \Exception('The file is too big.');
        }
    }
}

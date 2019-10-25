<?php
/**
 * Created by PhpStorm.
 * User: echudniy
 * Date: 24.10.19
 * Time: 17:00
 */

namespace App\Message;

class DeletePhotoFile
{
    private $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}
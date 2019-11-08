<?php
/**
 * Created by PhpStorm.
 * User: echudniy
 * Date: 24.10.19
 * Time: 12:26
 */

namespace App\Message\Command;

use App\Entity\ImagePost;

class DeleteImagePost
{
    private $imagePost;

    public function __construct(ImagePost $imagePost)
    {
        $this->imagePost = $imagePost;
    }

    public function getImagePost(): ImagePost
    {
        return $this->imagePost;
    }
}
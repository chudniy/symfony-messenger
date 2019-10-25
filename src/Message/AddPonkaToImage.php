<?php
/**
 * Created by PhpStorm.
 * User: echudniy
 * Date: 24.10.19
 * Time: 12:26
 */

namespace App\Message;

class AddPonkaToImage
{
    private $imagePostId;

    public function __construct(int $imagePostId)
    {
        $this->imagePostId = $imagePostId;
    }

    public function getImagePostId(): int
    {
        return $this->imagePostId;
    }
}
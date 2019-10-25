<?php
/**
 * Created by PhpStorm.
 * User: echudniy
 * Date: 24.10.19
 * Time: 17:13
 */

namespace App\MessageHandler;

use App\Message\DeletePhotoFile;
use App\Photo\PhotoFileManager;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeletePhotoFileHandler implements MessageHandlerInterface
{
    private $photoManager;

    public function __construct(PhotoFileManager $photoManager)
    {
        $this->photoManager = $photoManager;
    }

    public function __invoke(DeletePhotoFile $deletePhotoFile)
    {
        $this->photoManager->deleteImage($deletePhotoFile->getFilename());
    }
}
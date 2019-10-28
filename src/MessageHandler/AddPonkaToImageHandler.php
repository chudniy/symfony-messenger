<?php
/**
 * Created by PhpStorm.
 * User: echudniy
 * Date: 24.10.19
 * Time: 12:28
 */

namespace App\MessageHandler;

use App\Message\AddPonkaToImage;
use App\Photo\PhotoFileManager;
use App\Photo\PhotoPonkaficator;
use App\Repository\ImagePostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddPonkaToImageHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private $photoManager;
    private $entityManager;
    private $ponkaficator;
    private $imagePostRepository;

    public function __construct(PhotoFileManager $photoManager, EntityManagerInterface $entityManager, PhotoPonkaficator $ponkaficator, ImagePostRepository $imagePostRepository)
    {
        $this->photoManager = $photoManager;
        $this->entityManager = $entityManager;
        $this->ponkaficator = $ponkaficator;
        $this->imagePostRepository = $imagePostRepository;
    }
    
    public function __invoke(AddPonkaToImage $addPonkaToImage)
    {
        $imagePostId = $addPonkaToImage->getImagePostId();
        $imagePost = $this->imagePostRepository->find($imagePostId);

        if (!$imagePost) {
            if ($this->logger) {
                $this->logger->alert(sprintf('Image post %d was missing!', $imagePostId));
            }

            return;
        }

        $updatedContents = $this->ponkaficator->ponkafy(
            $this->photoManager->read($imagePost->getFilename())
        );
        $this->photoManager->update($imagePost->getFilename(), $updatedContents);
        $imagePost->markAsPonkaAdded();

        $this->entityManager->flush();
    }
}
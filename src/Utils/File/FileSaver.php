<?php

namespace App\Utils\File;

use App\Utils\Filesystem\FilesystemWorker;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileSaver
{

    /**
     * @var SluggerInterface
     */
    private $slugger;
    /**
     * @var string
     */
    private $uploadsTempDir;
    /**
     * @var FilesystemWorker
     */
    private $filesystemWorker;

    public function __construct(SluggerInterface $slugger, FilesystemWorker $filesystemWorker, string $uploadsTempDir)
    {

        $this->slugger = $slugger;
        $this->uploadsTempDir = $uploadsTempDir;
        $this->filesystemWorker = $filesystemWorker;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return string|null
     */
    public function saveUploadFileIntoTemp(UploadedFile $uploadedFile): ?string
    {
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $saveFilename = $this->slugger->slug($originalFilename);
        $filename = sprintf('%s-%s.%s', $saveFilename, uniqid(), $uploadedFile->guessExtension());

        $this->filesystemWorker->createFolderIfItNotExist($this->uploadsTempDir);

        try {
            $uploadedFile->move($this->uploadsTempDir, $filename);
        } catch (\Exception $exception) {
            return null;
        }

        return $filename;
    }



}
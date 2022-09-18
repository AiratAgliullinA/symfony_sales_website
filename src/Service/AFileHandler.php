<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Abstract class AFileHandler
 */
abstract class AFileHandler
{
    private $targetDirectory;
    private $slugger;

    /**
     * Constructor
     *
     * @param string $targetDirectory
     * @param SluggerInterface $slugger
     *
     * @return void
     */
    public function __construct(string $targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    /**
     * Upload file
     *
     * @param UploadedFile $file
     *
     * @return string
     */
    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            echo $e->getMessage();
        }

        return $fileName;
    }

    /**
     * Remove file
     *
     * @param string $fileName
     *
     * @return void
     */
    public function remove(string $fileName)
    {
        $filesystem = new Filesystem();
        $filesystem->remove($this->getTargetDirectory() . '/' . $fileName);
    }

    /**
     * Get target directory
     *
     * @return string
     */
    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}
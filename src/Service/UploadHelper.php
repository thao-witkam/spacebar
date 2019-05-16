<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadHelper
{
    const UPLOAD_IMAGE_PATH = '/upload/article_images/';

    private $publicPath;

    public function __construct(string $publicPath)
    {
        $this->publicPath = $publicPath;
    }


    public function uploadArticleImage(UploadedFile $imageFile):string
    {
        $dir = $this->publicPath.self::UPLOAD_IMAGE_PATH;
        $newFileName = uniqid().'_'.$imageFile->getClientOriginalName();
        $imageFile->move($dir, $newFileName);

        return $newFileName;
    }
}
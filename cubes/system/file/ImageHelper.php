<?php

namespace cubes\system\file;

use WebComplete\core\utils\cache\Cache;

class ImageHelper
{
    /**
     * @var ImageService
     */
    protected static $imageService;

    /**
     * @param int|string $imageId
     *
     * @return Image|null
     */
    public static function getImage($imageId)
    {
        return self::getImageService()->findById($imageId);
    }

    /**
     * @param $imageId
     * @param int|null $width
     * @param int|null $height
     * @param string $defaultUrl
     *
     * @return string
     * @throws \Symfony\Component\Cache\Exception\InvalidArgumentException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function getUrl($imageId, $width = null, $height = null, $defaultUrl = ''): string
    {
        return Cache::getOrSet(
            ['imageUrl', $imageId, $width, $height, $defaultUrl],
            function () use ($imageId, $width, $height, $defaultUrl) {
                if ($image = self::getImage($imageId)) {
                    return $image->size((int)$width, (int)$height)->getResizedUrl();
                }
                return $defaultUrl;
            }
        );
    }

    /**
     * @param $imageId
     * @param int|null $width
     * @param int|null $height
     * @param array $tagAttributes example: ['class' => 'product__img']
     *
     * @return string
     * @throws \Symfony\Component\Cache\Exception\InvalidArgumentException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function getTag($imageId, $width = null, $height = null, array $tagAttributes = []): string
    {
        return Cache::getOrSet(
            ['imageTag', $imageId, $width, $height, $tagAttributes],
            function () use ($imageId, $width, $height, $tagAttributes) {
                if ($image = self::getImage($imageId)) {
                    $url = $image->size($width, $height)->getResizedUrl();
                    $data = $image->getFileData();
                    $tagAttributes = \array_merge([
                        'alt' => $data['alt'] ?? '',
                        'title' => $data['title'] ?? ''
                    ], $tagAttributes);
                    $html = '<img src="' . $url . '" ';
                    foreach ($tagAttributes as $key => $value) {
                        $html .= $key . '="' . $value . '" ';
                    }
                    $html .= '/>';
                    return $html;
                }
                return '';
            }
        );
    }

    /**
     * @return ImageService
     */
    public static function getImageService(): ImageService
    {
        if (!self::$imageService) {
            global $application;
            self::setImageService($application->getContainer()->get(ImageService::class));
        }
        return self::$imageService;
    }

    /**
     * @param ImageService $imageService
     */
    public static function setImageService(ImageService $imageService)
    {
        self::$imageService = $imageService;
    }
}

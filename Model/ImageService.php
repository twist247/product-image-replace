<?php

namespace AT\ImageReplace\Model;

use GuzzleHttp\Client as HttpClient;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class ImageService
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ImageService constructor.
     * @param HttpClient $httpClient
     * @param DirectoryList $directoryList
     * @param LoggerInterface $logger
     */
    public function __construct(
        HttpClient $httpClient,
        DirectoryList $directoryList,
        LoggerInterface $logger
    ) {
        $this->httpClient = $httpClient;
        $this->directoryList = $directoryList;
        $this->logger = $logger;
    }

    /**
     * @return string
     */
    private function getApiUrl()
    {
        /**
         * TODO: this url should be generated dynamically for each product
         */
        return 'http://randomcatapi.orbalab.com/?api_key=5up3rc0nf1d3n714llp455w0rdf0rc47s';
    }

    /**
     * Retrieve image URL from images API
     *
     * @return mixed
     * @throws LocalizedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getImageUrl()
    {
        $response = $this->httpClient->request('GET', $this->getApiUrl());
        if ($response->getStatusCode() != 200
            || $response->getHeader('content-type')[0] !== 'application/json'
        ) {
            throw new LocalizedException(__('Invalid response code from image API.'));
        }

        $data = json_decode($response->getBody()->getContents(), true);
        if (!isset($data['url'])) {
            throw new LocalizedException(__('No image URL found.'));
        }

        return $data['url'];
    }

    /**
     * Download remote image to local destination
     *
     * @param $source
     * @param $destination
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function downloadImage($source, $destination)
    {
        try {
            $this->httpClient->request('GET', $source, ['sink' => $destination]);
        } catch (\Exception $e) {
            unlink($destination);
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Retrieve new product image URL
     *
     * @param bool $replaceExisting
     * @return bool|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getNewProductImage($replaceExisting = false)
    {
        try {
            $imageUrl = $this->getImageUrl();
            $filename = basename(parse_url($imageUrl, PHP_URL_PATH));

            $imageDir = $this->directoryList->getPath(DirectoryList::MEDIA) . '/image_replace';
            if (!file_exists($imageDir)) {
                mkdir($imageDir);
            }

            $imagePath = $imageDir . '/' . $filename;
            if (!file_exists($imagePath) || $replaceExisting) {
                $this->downloadImage($imageUrl, $imagePath);
            }

            return 'image_replace/' . $filename;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return false;
        }
    }
}

<?php

namespace AT\ImageReplace\Model;

use AT\ImageReplace\Api\ImageManagementInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class ImageManagement implements ImageManagementInterface
{
    /**
     * @var ImageService
     */
    private $imageService;

    /**
     * @var Data\NewImageFactory
     */
    private $resultFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * ImageManagement constructor.
     * @param ImageService $imageService
     * @param Data\NewImageFactory $resultFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ImageService $imageService,
        Data\NewImageFactory $resultFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->imageService = $imageService;
        $this->resultFactory = $resultFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * Get new product image data
     *
     * @return \AT\ImageReplace\Api\Data\NewImageInterface|Data\NewImage
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getNewImage()
    {
        $result = $this->resultFactory->create();

        $newImage = $this->imageService->getNewProductImage();
        if ($newImage) {
            $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $result->setUrl($mediaUrl . $newImage);
        }

        return $result;
    }
}

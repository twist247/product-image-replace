<?php

namespace AT\ImageReplace\Api;

interface ImageManagementInterface
{
    /**
     * Get new image
     *
     * @return Data\NewImageInterface
     */
    public function getNewImage();
}

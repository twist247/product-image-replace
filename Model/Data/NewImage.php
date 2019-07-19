<?php

namespace AT\ImageReplace\Model\Data;

use AT\ImageReplace\Api\Data\NewImageInterface;
use Magento\Framework\DataObject;

class NewImage extends DataObject implements NewImageInterface
{
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->getData(self::DATA_URL);
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->setData(self::DATA_URL, $url);

        return $this;
    }
}

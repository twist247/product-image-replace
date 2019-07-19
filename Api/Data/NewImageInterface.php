<?php

namespace AT\ImageReplace\Api\Data;

interface NewImageInterface
{
    const DATA_URL = 'url';

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param string $url
     * @return mixed
     */
    public function setUrl($url);
}

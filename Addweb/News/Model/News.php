<?php

namespace Addweb\News\Model;

class News extends \Magento\Framework\Model\AbstractModel implements \Addweb\News\Api\Data\NewsInterface {

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;

    protected $_objectManager;
    protected $_coreResource;

    public function _construct() {
        $this->_init('Addweb\News\Model\ResourceModel\News');
    }

    public function getAvailableStatuses() {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    public function getIdentities() {
        return [self::CACHE_TAG . '_' . $this->getNewsId()];
    }

    public function getNewsId() {
        return $this->getData(self::NEWS_ID);
    }

    public function getTitle() {
        return $this->getData(self::TITLE);
    }

    public function getImages() {
        return $this->getData(self::IMAGES);
    }

    public function getDescription() {
        return $this->getData(self::DESCRIPTION);
    }

    public function getStatus() {
        return $this->getData(self::STATUS);
    }

    public function setNewsId($news_id) {
        return $this->setData(self::NEWS_ID, $news_id);
    }

    public function setTitle($title) {
        return $this->setData(self::TITLE, $title);
    }

    public function setImages($images) {
        return $this->setData(self::IMAGES, $images);
    }

    public function setDescription($description) {
        return $this->setData(self::DESCRIPTION, $description);
    }

    public function setStatus($status) {
        return $this->setData(self::STATUS, $status);
    }

}

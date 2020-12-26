<?php 
namespace Addweb\News\Block;

use Magento\Framework\App\RequestInterface;
use Addweb\News\Model\News;

class Newslist extends \Magento\Framework\View\Element\Template 
{
    protected $_model;
    protected $request;
    protected $storeManager;
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Addweb\News\Model\News $model,
        RequestInterface $request,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_model = $model;
        $this->_request = $request;
        $this->storeManager = $storeManager;
    }

    /**
     * Preparing global layout
     *
     * @return $this
     */
    protected function _prepareLayout() {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('News Collection'));
        return $this;
    }

    public function getNews() {
        $collection = $this->_model->getCollection();
        return $collection;
    }

    public function getMediaUrl() {
        return $mediaUrl = $this->storeManager
                ->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

}
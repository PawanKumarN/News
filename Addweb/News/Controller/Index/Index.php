<?php
namespace Addweb\News\Controller\Index;

use Magento\Framework\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Framework\App\Action\Action 
{
    /**
     * @param Action\Context $context
     */

    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute() {

        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}


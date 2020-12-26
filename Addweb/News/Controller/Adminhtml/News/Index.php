<?php
/**
 
 *
 * @category  Addweb
 * @author     n.pavan37@gmail.com
 * @package   Addweb_News

 */
namespace Addweb\News\Controller\Adminhtml\News;

class Index extends \Magento\Backend\App\Action {

    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute() {
        //die("herererere comming new index");
        //Call page factory to render layout and page content
        $resultPage = $this->resultPageFactory->create();
        //Set the menu which will be active for this page
        $resultPage->setActiveMenu('Addweb_News::news');

        //Set the header title of grid
        $resultPage->getConfig()->getTitle()->prepend(__('News'));
        //Add bread crumb
        $resultPage->addBreadcrumb(__('Addweb'), __('Addweb'));
        $resultPage->addBreadcrumb(__('News'), __('News'));
        return $resultPage;
    }

    /*
     * Check permission via ACL resource
     */

    protected function _isAllowed() {
        return $this->_authorization->isAllowed('Addweb_News::news');
    }

}

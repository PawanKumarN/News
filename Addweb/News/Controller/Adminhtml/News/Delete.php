<?php

namespace Addweb\News\Controller\Adminhtml\News;

use Magento\Backend\App\Action;

class Delete extends Action {

    /**
     * @var \Addweb\News\Model\News
     */
    protected $_model;
    /**
     * @param Action\Context $context
     * @param \Addweb\News\Model\News $model
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Addweb\News\Model\News $model
    ) {
        parent::__construct($context);
        $this->_model = $model;
    }
    public function execute() {
        $newsId = (int) $this->getRequest()->getParam('news_id');
//        print_r($newsId);die("hreerhe");
        if ($newsId) {
            /** @var $model \Addweb\News\Model\News */
            $model = $this->_model;
            $model->load($newsId);
 
            // Check this news exists or not
            if (!$model->getNewsId()) {
                $this->messageManager->addError(__('This News no longer exists.'));
            } else {
                try {
                    // Delete news
                    $model->delete();
                    $this->messageManager->addSuccess(__('The News has been deleted.'));
 
                    // Redirect to grid page
                    $this->_redirect('*/*/');
                    return;
                } catch (\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                    $this->_redirect('*/*/edit', ['news_id' => $model->getNewsId()]);
                }
            }
        }
    }
}
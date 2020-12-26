<?php

namespace Addweb\News\Controller\Adminhtml\News;

class Edit extends \Magento\Backend\App\Action {

    /**
           * Core registry
           *
           * @var \Magento\Framework\Registry
            */
    protected $_coreRegistry = null;

    /**
           * @var \Magento\Framework\View\Result\PageFactory
            */
    protected $_resultPageFactory;

    /**
           * @var         \Addweb\News\Model\News
            */
    protected $_model;

    /**
       * @param Action\Context $context
       * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
       * @param \Magento\Framework\Registry $registry
       * @param         \Addweb\News\Model\News $model
        */
    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Addweb\News\Model\News $model
            ) 
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->_model = $model;
        parent::__construct($context);
    }
    /**
        * {@inheritdoc}
    */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Addweb_News::news_save');
    }
    /**
           * Init actions
           *
           * @return \Magento\Backend\Model\View\Result\Page
            */
    
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Addweb_News::manage_news')
            ->addBreadcrumb(__('News'), __('News'))
            ->addBreadcrumb(__('Manage News'), __('Manage News'));
        return $resultPage;
    }
    /**
        * Edit Department
        *
        * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
        * @SuppressWarnings(PHPMD.NPathComplexity)
        */
    public function execute(){
        $id = $this->getRequest()->getParam('news_id');

        $model = $this->_model;
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This news not exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('news_data', $model);
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
                $id ? __('Edit News') : __('Add New'),
                $id ? __('Edit News') : __('Add New')
            );
        $resultPage->getConfig()->getTitle()->prepend(__('News'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getNewsId() ? __('Edit News:"').$model->getData('title').('"') : __('Add New'));
        
        return $resultPage;
    }
}

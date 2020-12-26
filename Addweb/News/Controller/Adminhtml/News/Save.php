<?php

namespace Addweb\News\Controller\Adminhtml\News;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;

class Save extends \Magento\Backend\App\Action {
     /**
     * @var \Addweb\News\Model\News
     */
    protected $_model;

    /**
     * File Uploader factory.
     *
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $_fileUploaderFactory;
 
    protected $_mediaDirectory;
    
    /**
     * @param Action\Context $context
     * @param \Addweb\News\Model\Album $model
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Addweb\News\Model\News $model,
        Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
    ) {
        parent::__construct($context);
        $this->_model = $model;
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->_fileUploaderFactory = $fileUploaderFactory;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed() {
        return $this->_authorization->isAllowed('Addweb_News::news_save');
    }
    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute() {
        $data = $this->getRequest()->getPostValue();

//        print_r($data);
//        print_r($profileImage);
//        die("here saving");
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->_model;

            $id = $this->getRequest()->getParam('news_id');

            ///image upload
            $profileImage = $this->getRequest()->getFiles('images');
//                print_r($profileImage);

            $fileName = ($profileImage && array_key_exists('name', $profileImage)) ? $profileImage['name'] : null;
//                print_r($fileName);

            if (isset($_FILES['images']) && isset($_FILES['images']['name']) && strlen($_FILES['images']['name'])) {
//                print_r($_FILES['images']);
                if ($profileImage && $fileName) {
                    try {

                        $uploader = $this->_fileUploaderFactory->create(['fileId' => 'images']);
                        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                        $imageAdapterFactory = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();
                        $uploader->setAllowRenameFiles(true);
                        $uploader->setFilesDispersion(true);
                        $uploader->setAllowCreateFolders(true);
//                $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
//                        ->getDirectoryRead(DirectoryList::MEDIA);
                        $target = $this->_mediaDirectory->getAbsolutePath('news');
                        $result = $uploader->save($target);
                        $data['images'] = 'news' . $result['file'];
                    } catch (Exception $ex) {
                        if ($e->getCode() == 0) {
                            $this->messageManager->addError($e->getMessage());
                        }
                    }
                }
            } else {
//                echo "dfgkljfklghdf";
                if (isset($data['images']) && isset($data['images']['value'])) {
                    if (isset($data['images']['delete'])) {
                        $data['images'] = null;
                        $data['delete_image'] = true;
                    } elseif (isset($data['images']['value'])) {
                        $data['images'] = $data['images']['value'];
                    } else {
                        $data['images'] = null;
                    }
                }
            }
            //end image upload//
//            echo "final data";
//            print_r($data);
//            die("herere");
            if ($id) {
                $model->load($id);
                $model->addData($data);
            } else {

                $model->setData($data);
            }
            try {

                $model->save();
                $this->messageManager->addSuccess(__('News saved'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['news_id' => $model->getNewsId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('An error occurred while saving News.' . $e->getMessage()));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['news_id' => $this->getRequest()->getParam('news_id')]);
        }
//        die("here");
        return $resultRedirect->setPath('*/*/');
    }

}
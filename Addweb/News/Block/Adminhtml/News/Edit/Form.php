<?php

namespace Addweb\News\Block\Adminhtml\News\Edit;

use \Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic {

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
    \Magento\Backend\Block\Template\Context $context,
            \Magento\Framework\Registry $registry,
            \Magento\Framework\Data\FormFactory $formFactory,
            \Magento\Store\Model\System\Store $systemStore,
            \Addweb\News\Model\Status $status,
            array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Init form
     *
     * @return void
     */
    protected function _construct() {
        parent::_construct();
        $this->setId('news_form');
        $this->setTitle(__('News Information'));
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm() {

        /** @var \Addweb\News\Model\News $model */
        $model = $this->_coreRegistry->registry('news_data');
//        print_r($model->getData());
//        echo "dskjfsd".$model->getNewsId();
//        die("herehre");
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form = $this->_formFactory->create(
                ['data' => [
                        'id' => 'edit_form',
                        'enctype' => 'multipart/form-data',
                        'action' => $this->getData('action'),
                        'method' => 'post'
                    ]
                ]
        );
        $fieldset = $form->addFieldset(
                'base_fieldset', ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );
        if ($model->getNewsId()) {
            $fieldset->addField('news_id', 'hidden', ['name' => 'news_id']);
        }

        $fieldset->addField(
                'title', 'text', ['name' => 'title', 'label' => __('Title'), 'title' => __('Title'), 'required' => true]
        );

        $fieldset->addField(
                'images', 'image', ['name' => 'images', 'label' => __('Image'), 'title' => __('Image')]
        );

        $fieldset->addField(
                'description', 'textarea', ['name' => 'description', 'label' => __('Description'), 'title' => __('Description'), 'required' => true]
        );
        $fieldset->addField(
                "status", "select", [
            "label" => __("Status"),
            "name" => "status",
            "values" => [
                ["value" => 2, "label" => __("Disabled")],
                ["value" => 1, "label" => __("Enabled")],
            ],
            'value' => $model->getStatus() == 1 ? 'Enabled' : 'Disabled',
                //'options' => $this->_status->getOptionArray(),
                ]
        );


        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $form->setAction($this->getUrl('news/*/save'));
        $form->setMethod('post');
        $this->setForm($form);

        return parent::_prepareForm();
    }

}

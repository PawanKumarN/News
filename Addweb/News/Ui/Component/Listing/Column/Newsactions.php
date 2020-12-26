<?php

namespace Addweb\News\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;


class Newsactions extends Column
{
    const NEWS_URL_PATH_EDIT = 'news/news/edit';
    const NEWS_URL_PATH_DELETE = 'news/news/delete';
    protected $actionUrlBuilder;
    protected $urlBuilder;
    private $editUrl;
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::NEWS_URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                
                
                
                if (isset($item['news_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['news_id' => $item['news_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(
                            self::NEWS_URL_PATH_DELETE,
                            ['news_id' => $item['news_id']]
                        ),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete ${ $.$data.title }'),
                            'message' => __('Are you sure you wan\'t to delete a ${ $.$data.title } record?')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}

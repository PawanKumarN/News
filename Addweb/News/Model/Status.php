<?php

namespace Addweb\News\Model;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    protected $photogallery;
    public function __construct(\Addweb\News\Model\News  $news)
    {
        $this->news = $news;
    }
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->news->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}

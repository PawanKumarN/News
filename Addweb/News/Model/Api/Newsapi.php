<?php

namespace Addweb\News\Model\Api;

use Addweb\News\Model\News;
use Psr\Log\LoggerInterface;

class Newsapi {

    protected $logger;
    protected $_model;

    public function __construct(
    LoggerInterface $logger, \Addweb\News\Model\News $model
    ) {

        $this->logger = $logger;
        $this->_model = $model;
    }

    /**
     * Return the sum of the two numbers.
     *
     * @api

     * 

     * @return 
     */
    //added newly home search

    public function getNewslist() {


        $collectionobj = $this->_model->getCollection();

        if (count($collectionobj) > 0) {
            $collection = $collectionobj->getData();
            $response = ['success' => true, 'news' => $collection];
        } else {
            $response = ['success' => false, 'Errormsg' => "There is no news"];
        }
        $response = json_encode($response);
        echo $response;
    }

    /**
     * Return the sum of the two numbers.
     *
     * @api
     * @param int $id
     * @return 
     */
    public function getNews($id) {
        $newsdata = array();
        if ($id) {
            /** @var $model \Addweb\News\Model\News */
            $model = $this->_model;
            $model->load($id);
            if ($model->getNewsId()) {
                $newsdata['id'] = $model->getNewsId();
                $newsdata['title'] = $model->getTitle();
                $newsdata['image'] = $model->getImages();
                $newsdata['description'] = $model->getDescription();
                $response = ['success' => true, 'news' => $newsdata];
            } else {
                $response = ['success' => false, 'Errormsg' => "There is no news"];
            }
        } else {
            $response = ['success' => false, 'Errormsg' => "expect parameters"];
        }
        $json = json_encode($response);
        echo $json;
    }

}

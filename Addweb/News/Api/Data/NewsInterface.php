<?php

namespace Addweb\News\Api\Data;

interface NewsInterface {

    const NEWS_ID = 'news_id';
    const TITLE = 'title';
    const IMAGES = 'images';
    const DESCRIPTION = 'description';
    const STATUS = 'status';
   

    public function getNewsId();

    public function getTitle();

    public function getImages();

     public function getDescription();
    
    public function getStatus();

    public function setNewsId($news_id);

    public function setTitle($title);

    public function setImages($images);

    public function setDescription($description);
    
    public function setStatus($status);

    
}

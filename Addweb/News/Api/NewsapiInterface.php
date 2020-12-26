<?php



namespace Addweb\News\Api;

/**
 * @api
 */
interface NewsapiInterface {

    /**
     * Return the sum of the two numbers.
     *
     * @api
     *
     * @return
     */
    public function getNewslist();

    /**
     * Return the sum of the two numbers.
     *
     * @api
     * @param int $id
     * @return 
     */
    public function getNews($id);
}

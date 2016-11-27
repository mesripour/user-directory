<?php

namespace app\controllers;

class SearchController extends BaseController
{
    // second
    const CACHE_TIME = 5;

    /**
     * return search view
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function search()
    {
        return $this->view->render($this->response, 'search.html.twig');
    }

    /**
     * return search result
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function searchResult()
    {
        // get input data
        $name = $this->request->getParam('name');
        $email = $this->request->getParam('email');

        // get from cache (memcached)
        $key = $name.$email;
        $result = $this->memcached()->get($key);

        // run search query if cache is empty
        if (!$result) {
            $result = $this->searchModel()->search($email, $name);
            $this->memcached()->set($key, $result, self::CACHE_TIME);
        }

        // clean result
        $document = $result['hits']['hits'];
        $userId = $this->userId;

        // return result view
        return $this->view->render(
            $this->response,
            'result.html.twig',
            ['documents' => $document, 'userId' => $userId]
        );
    }
}
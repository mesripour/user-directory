<?php

namespace app\controllers;

class UserController extends BaseController
{
    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function register()
    {
        return $this->view->render($this->response, 'register.html.twig');
    }

    /**
     * save to mysql and elastic, set sessions
     *
     * @return static
     */
    public function registerSubmit()
    {
        // save to mysql
        $userId = $this->insertToMysql();

        // save to elastic
        $this->insertToElastic($userId);

        // session set
        $this->session()->set([
            'login' => true,
            'userId' => $userId
        ]);

        return $this->response->withRedirect('/personal');
    }

    /**
     * load login view just for guest
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login()
    {
        if ($this->userId) { // this user is not guest
            $userRow = (array)$this->userModel()->findById('users', $this->userId);
            $response = $this->view->render(
                $this->response,
                'personal.html.twig',
                ['user' => $userRow]
            );
        } else { // this user is guest
            $response = $this->view->render($this->response, 'login.html.twig');
        }

        return $response;
    }

    /**
     * check user login and set sessions
     *
     * @return static
     */
    public function loginSubmit()
    {
        // load user data from mysql
        $userRow = $this->userModel()->find('users', [
            'email' => $this->request->getParam('email'),
            'password' => hash('sha256', $this->request->getParam('password'))
        ]);

        // login check and set sessions
        if ($userRow) {
            $this->session()->set([
                'login' => true,
                'userId' => $userRow[0]->id
            ]);
            $response = $this->response->withRedirect('/personal');
        } else {
            $response = $this->response->withRedirect('/');
        }

        return $response;
    }

    /**
     * show user or others profile on this page
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function personal()
    {
        $friendId = $this->request->getQueryParam('id');

        if ($friendId) { // show other user info on this page
            $userRow = (array)$this->userModel()->findById('users', $friendId);
            // is not friend yet
            $isFriend = $this->userModel()->find('friends', ['user_id' => $this->userId, 'friend_id' => $friendId]);
            $userRow['addFriend'] = ($isFriend) ? false : true;
        } else { // show user info
            // don't add yourself
            $userRow['addFriend'] =  false;
            $userRow = (array)$this->userModel()->findById('users', $this->userId);
        }

        return $this->view->render($this->response, 'personal.html.twig', ['user' => $userRow]);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function setting()
    {
        // load user profile from mysql
        $userRow = (array)$this->userModel()->findById('users', $this->userId);

        return $this->view->render($this->response, 'setting.html.twig', ['user' => $userRow]);
    }

    /**
     * update user profile in mysql and elastic
     *
     * @return static
     */
    public function settingSubmit()
    {
        // update mysql
        $this->userModel()->update('users', ['id' => $this->userId], [
            'name' => $this->request->getParam('name'),
            'email' => $this->request->getParam('email'),
            'age' => $this->request->getParam('age'),
            'password' => hash('sha256', $this->request->getParam('password')),
        ]);

        // update elastic
        $this->searchModel()->update($this->userId, [
            'name' => $this->request->getParam('name'),
            'email' => $this->request->getParam('email'),
        ]);

        return $this->response->withRedirect('/personal');
    }

    /**
     * logout user and delete user's session
     *
     * @return static
     */
    public function logout()
    {
        $this->session()->destroy();
        return $this->response->withRedirect('/');
    }

    /**
     * @return int
     */
    private function insertToMysql(): int
    {
        $userId = $this->userModel()->insert('users', [
            'name' => $this->request->getParam('name'),
            'email' => $this->request->getParam('email'),
            'age' => $this->request->getParam('age'),
            'password' => hash('sha256', $this->request->getParam('password')),
            'create_at' => time(),
        ]);

        return $userId;
    }

    /**
     * @param int $userId
     */
    private function insertToElastic(int $userId)
    {
        $body = [
            'name' => $this->request->getParam('name'),
            'email' => $this->request->getParam('email'),
        ];

        $this->searchModel()->insert($userId, $body);
    }
}
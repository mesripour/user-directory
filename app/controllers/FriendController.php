<?php

namespace app\controllers;

class FriendController extends BaseController
{
    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function friendsList()
    {
        // find user's friends
        $friends = $this->friendModel()->findFriends($this->userId);

        return $this->view->render($this->response, 'friends.html.twig', ['friends' => $friends]);
    }

    /**
     * @return static
     */
    public function addFriend()
    {
        $friendId = $this->request->getQueryParam('id');

        // insert user's new friend to mysql
        $this->insert($friendId);

        return $this->response->withRedirect('/friends');
    }

    /**
     * insert user's new friend to mysql and vice versa
     *
     * @param int $friendId
     */
    private function insert(int $friendId)
    {
        $values = [
            'user_id' => $this->userId,
            'friend_id' => $friendId,
        ];
        $this->insertFriend($values);

        $values = [
            'user_id' => $friendId,
            'friend_id' => $this->userId,
        ];
        $this->insertFriend($values);
    }

    /**
     * save to mysql
     *
     * @param array $value
     */
    private function insertFriend(array $value)
    {
        $this->userModel()->insert('friends', $value);
    }
}
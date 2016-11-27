<?php

namespace app\models;

class FriendModel extends BaseModel
{
    /**
     * find user's friends
     *
     * @param int $userId
     * @return array
     */
    public function findFriends(int $userId)
    {
        return $this->mysql()
            ->table('friends')
            ->leftJoin(
                'users',
                'friends.friend_id',
                '=',
                'users.id'
            )->where(['user_id' => $userId,])
            ->get()->toArray();
    }
}
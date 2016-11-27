<?php

namespace app\models;

class SearchModel extends BaseModel
{
    const INDEX_NAME = 'directory';
    const TYPE_NAME = 'users';

    /**
     * @param int $userId
     * @param array $values
     */
    public function insert(int $userId, array $values)
    {
        $params = [
            'index' => self::INDEX_NAME,
            'type' => self::TYPE_NAME,
            'id' => $userId,
            'body' => $values
        ];

        $this->elastic()->index($params);
    }

    /**
     * @param int $userId
     * @param array $values
     */
    public function update(int $userId, array $values)
    {
        $params = [
            'index' => self::INDEX_NAME,
            'type' => self::TYPE_NAME,
            'id' => $userId,
            'body' => [
                'doc' => $values
            ]
        ];

        $this->elastic()->update($params);
    }

    /**
     * search query
     *
     * @param string $email
     * @param string $name
     * @return array
     */
    public function search(string $email, string $name)
    {
        $params = [
            'index' => self::INDEX_NAME,
            'type' => self::TYPE_NAME,
            'body' => [
                'query' => [
                    'bool' => [
                        'should' => [
                            [ 'match' => [ 'name' => $name ] ],
                            [ 'match' => [ 'email' => $email] ],
                            [
                                "multi_match" => [
                                    "query" => $name,
                                    'fields' => ['name'],
                                    "fuzziness" => 'AUTO',
                                    'boost' => 0,
                                ],
                            ],
                            [
                                "multi_match" => [
                                    "query" => $email,
                                    'fields' => ['email'],
                                    "fuzziness" => 'AUTO',
                                    'boost' => 0,
                                ],
                            ],
                        ]
                    ]
                ]
            ]
        ];

        return $this->elastic()->search($params);
    }
}
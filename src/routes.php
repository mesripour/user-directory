<?php

$app->get('/register', 'app\controllers\UserController:register');

$app->post('/register/submit', 'app\controllers\UserController:registerSubmit');

$app->get('/logout', 'app\controllers\UserController:logout')->add($login);

$app->get('/setting', 'app\controllers\UserController:setting')->add($login);

$app->post('/setting/submit', 'app\controllers\UserController:settingSubmit')->add($login);

$app->get('/personal', 'app\controllers\UserController:personal')->add($login);

$app->get('/friends', 'app\controllers\FriendController:friendsList')->add($login);

$app->get('/friend/add', 'app\controllers\FriendController:addFriend')->add($login);

$app->get('/', 'app\controllers\UserController:login');

$app->post('/login/submit', 'app\controllers\UserController:loginSubmit');

$app->get('/search', 'app\controllers\SearchController:search')->add($login);

$app->post('/result', 'app\controllers\SearchController:searchResult')->add($login);
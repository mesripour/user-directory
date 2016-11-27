<?php

// user must be login
$login = function ($request, $response, $next) {
    $isLogin = $this->get('session')->get()['login'];
    if ($isLogin) {
        $response = $next($request, $response, $next);
    } else {
        $response = $this->get('response')->withRedirect('/');
    }

    return $response;
};
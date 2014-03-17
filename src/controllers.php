<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', 'HotspotMap\Controller\HotspotController::indexAction');

$app->get('/signup', function () use ($app) {
    return $app['twig']->render('signup.twig', array());
});

$app->get('/login', function () use ($app) {
    return $app['twig']->render('login.twig', array());
});

$app->post('/createUser', 'HotspotMap\Controller\UserController::createUserAction');
$app->post('/doLogin', 'HotspotMap\Controller\UserController::doLogin');
$app->get('/logout', 'HotspotMap\Controller\UserController::doLogout');

$app->get('/newHotspot', function () use ($app) {
    if ($app['session']->get('user'))
    {
        return $app['twig']->render('newHotspot.twig', array());
    }

    return $app['twig']->render('login.twig', array());
});

$app->post('/createHotspot', 'HotspotMap\Controller\HotspotController::createHotspotAction');

$app->get('/getHotspots', 'HotspotMap\Controller\HotspotController::getAll');

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.twig, or 40x.twig, or 4xx.twig, or error.twig
    $templates = array(
        'errors/'.$code.'.twig',
        'errors/'.substr($code, 0, 2).'x.twig',
        'errors/'.substr($code, 0, 1).'xx.twig',
        'errors/default.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array(
        'code' => $code,
    )), $code);
});

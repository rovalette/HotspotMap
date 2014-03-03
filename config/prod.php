<?php

// configure your app for the production environment

$app['twig.path'] = array(__DIR__.'/../templates');
$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');

$db['user'] = 'root';
$db['passwd'] = 'root';
$db['system'] = 'mysql';
$db['host'] = 'localhost';
$dn['name'] = 'hotspotmap';

<?php
/**
 * Created by PhpStorm.
 * User: rovalette
 * Date: 10/03/2014
 * Time: 22:14
 */

namespace HotspotMap\Controller;


use HotspotMap\Entity\Hotspot;
use HotspotMap\Repository\HotspotRepository;
use HotspotMap\Repository\Connection;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class HotspotController {

    /**
     * @var HotspotRepository
     */
    protected $hotspotRepository;

    protected function initConnection(Application $app)
    {
        $dsn = $app['db.options']['system'].':host='.$app['db.options']['host'].';dbname='.$app['db.options']['dbname'];

        $con = new Connection($dsn, $app['db.options']['user'], $app['db.options']['password']);
        $this->hotspotRepository = new HotspotRepository($con);
    }

    public function indexAction(Application $app, Request $request)
    {
        $this->initConnection($app);
        $hotspots = $this->hotspotRepository->findAll();

        return $app['twig']->render('index.twig', array(
            'hotspots' => $hotspots,
        ));
    }

    public function createHotspotAction(Application $app, Request $request)
    {
        $name = $request->get('name');
        $address = $request->get('address');
        $hasplugs = $request->get('hasplugs')?1:0;
        $hascoffee = $request->get('hascoffee')?1:0;
        $haswifi = $request->get('haswifi')?1:0;

        $hotspot = new Hotspot(
            $app['session']->get('user')['id'],
            $name,
            $address,
            date('m-d-Y')
        );
        $hotspot->hasPlugs = $hasplugs;
        $hotspot->hasCoffee = $hascoffee;
        $hotspot->hasWifi = $haswifi;

        $this->initConnection($app);

        if (!$this->hotspotRepository->save($hotspot))
        {
            return $app['twig']->render('error.twig', array(
                'message' => 'An error occured...',
            ));
        }

        $username = $app['session']->get('user')['username'];
        $hotspots = $this->hotspotRepository->findAll();
        return $app['twig']->render('success.twig', array(
            'message' => 'Well done '.$username.' ! Your hotspot has been added.',
            'hotspots' => $hotspots,
        ));
    }

    public function getAll()
    {
        return new JsonResponse($this->hotspotRepository->findAll());
    }
}

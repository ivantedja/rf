<?php

namespace Rf\CalculatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CalculatorController extends Controller
{
    public function indexAction()
    {
        return $this->render('RfCalculatorBundle:Calculator:calculator.html.twig');
    }

    public function calculateAction(Request $request)
    {
        $query = $request->query;

        $weapon = $query->get('weapon');
        if(!isset($weapon) || empty($weapon)) {
            /** initialize weapon value */
            $weapon = '1-1';
        }
        list($weaponMin, $weaponMax) = explode('-', $weapon);

        $upgrade = (int)$query->get('upgrade') / 100;

        $buff = $query->get('buff');
        $buff = is_array($buff) ? $buff : (array)$buff;

        $totalBuff = 0;
        foreach ($buff as $v) {
            $totalBuff += $v;
        }

        $totalMin = $weaponMin + floor($weaponMin * $upgrade) + floor($weaponMin * $totalBuff / 100);
        $totalMax = $weaponMax + floor($weaponMax * $upgrade) + floor($weaponMax * $totalBuff / 100);

        $return = array('totalMin' => $totalMin, 'totalMax' => $totalMax, 'buff' => $totalBuff);
        return new Response(json_encode($return), 200 , array('Content-Type'=>'application/json'));
    }
}
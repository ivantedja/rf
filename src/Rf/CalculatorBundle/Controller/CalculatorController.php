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

        $upgrade = (int)$query->get('upgrade') / 100;

        $buff = $query->get('buff');
        $buff = is_array($buff) ? $buff : (array)$buff;

        $totalBuff = 0;
        foreach ($buff as $v) {
            $totalBuff += $v;
        }

        $totalMin = $weapon['min'] + floor($weapon['min'] * $upgrade) + floor($weapon['min'] * $totalBuff / 100);
        $totalMax = $weapon['max'] + floor($weapon['max'] * $upgrade) + floor($weapon['max'] * $totalBuff / 100);

        $return = array('totalMin' => $totalMin, 'totalMax' => $totalMax, 'buff' => $totalBuff);
        return new Response(json_encode($return), 200 , array('Content-Type'=>'application/json'));
    }
}
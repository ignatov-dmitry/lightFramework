<?php


namespace Controllers;


class Home extends \Core\Controller
{
    public function index ()
    {
        return $this->render('Home');
    }
}
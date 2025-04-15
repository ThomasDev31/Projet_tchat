<?php

namespace Controllers;

use Models\Admin;

class ControllerAdmin
{
    public function index()
    {
        $category = new Admin;
        $nameFile = 'admin';
        $template = 'admin';
        if (!empty($_POST['channel'])) {
            $name = $_POST['channel'];
            $msg = $category->createChannel($name);
        }
        require './views/src/layout.phtml';
    }
    public function displayChannel()
    {
        $channel = new Admin;
        $category = $channel->getAllChannels();
        $nameFile = 'admin';
        $template = 'adminchannel';
        require './views/src/layout.phtml';
    }
    public function addSalon()
    {
        $salon = new Admin;
        if (!empty($_POST['salon']) && !empty($_POST['categoryId'])) {
            $name = $_POST['salon'];
            $categoryId = $_POST['categoryId'];
            $msg = $salon->createSalon($categoryId, $name);
        }
        $category = $salon->getAllChannels();
        $nameFile = 'admin';
        $template = 'adminSalon';
        require './views/src/layout.phtml';
    }
}

<?php

namespace Controllers;
use Models\Channel;
class ControllerChannel{

    public function index (){
        $channel = new Channel;
        $category = $channel->getAllChannelsWithSalon();
         
        $categories = [];

        foreach ($category as $row) {
            $cat = $row['category_name'];
            $salon = $row['salon_name'];

            if (!isset($categories[$cat])) {
                $categories[$cat] = [];
            }

            if ($salon !== null) {
                $categories[$cat][] = $salon;
            }
        }
        $template = 'channel';
        require './views/src/layout.phtml';
    }

    public function show(){
        $channel = new Channel;
        $categorys = $channel->getAllChannelsWithSalon();
        $categories = [];

        foreach ($categorys as $row) {
            $cat = $row['category_name'];
            $salon = $row['salon_name'];

            if (!isset($categories[$cat])) {
                $categories[$cat] = [];
            }

            if ($salon !== null) {
                $categories[$cat][] = $salon;
            }
        }

        if(!isset($_GET['name'])){
            die("Salon introuvable !");
        }
        
        $salon = $channel->getSalonByName($_GET['name']);
        $idSalon = $salon[0]['id'];
        $userId = $_SESSION['user_id'];
        if(isset($_POST['content']) && $_POST['content']){
            $content = $_POST['content'];
            $channel->createMessage($content, $idSalon, $userId);
            header('Location: ?page=channel&action=show&name=' . urlencode($_GET['name']));
            exit();
        }
        $messages =  $channel->getAllMessageBySalons($idSalon);
        $nameSalon = $_GET['name'];
        $template = 'discussion';
        require './views/src/layout.phtml';
    }
}
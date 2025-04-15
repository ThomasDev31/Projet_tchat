<?php

namespace Controllers;
use Models\Channel;
class ControllerChannel{

    public function index (){
        $channel = new Channel;
        $category = $channel->getAllChannels();
         
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
}
<?php

header('Content-Type: application/json');
if ($this->view->check == true) {
    foreach ($this->view->users as $client) {
            foreach ($client->category as $cat){
                    $product = $cat->product;
                    $productid = $cat->id;
                    $rate = $cat->rate;
                }
            $data = [
                'id' => $client->id,
                'name' => $client->name,
                'email' => $client->email,
                'password' => $client->password,
                'owner_id' => $client->owner_id,
                'expires' => $client->expires,
                'category' => $product,
                'category_id' => $productid,
                'rate' => $rate
            ];
            $response = json_encode($data);
            echo $response . '|';
    }
} else {
    echo $this->view->post;
}
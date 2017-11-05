<?php

$name_to_price = [
    "Apple" => .5,
    "Bagel" => .9,
    "Banana" => .25,
    "Slice of Bread" => .1,
    "Slie of Cheese" => .15,
    "Caesar Salad" => 5,
    "Cookie" => .1,
    "Corn" => .3,
    "Granola Bar" => .25,
    "Scoop of Ice Scream" => 1,
    "Doughnut" => 1.3,
    "Orange" => .4,
    "Bag of Chips" => .35,
    "Bag of Pretzels" => 1.35,
    "Beans" => .5,
    "Yougurt" => .1,
    "Pear" => .2,
    "Pasta" => 7,
    "Baby Carrots" => .75,
    "French Fries" => 2.5,
    "Fruit Punch" => .15,
    "Orange Juice" => .2
];

move_uploaded_file($_FILES['webcam']['tmp_name'], 'image.jpg');

$image_url = "http://vedarsh.com/food_wastage_budgeting/image.jpg";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.clarifai.com/v2/models/aaa03c23b3724a16a56b629203edc62c/outputs");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "\n  {\n    \"inputs\": [\n      {\n        \"data\": {\n          \"image\": {\n            \"url\": \"{$image_url}\"\n          }\n        }\n      }\n    ]\n  }\n");
curl_setopt($ch, CURLOPT_POST, 1);

$headers = array();
$headers[] = "Authorization: Key e080591c8ad246cc861fe25ac6104c23";
$headers[] = "Content-Type: application/json";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
else {
    $result_items = ["Apple", "Caesar Salad", "French Fries"];

    $return_val = [];
    $return_val["names"] = $result_items;
    $return_val["prices"] = [];

    foreach($result_items as $item)
    {
        array_push($return_val["prices"], $name_to_price[$item]);
    }

    echo json_encode($return_val);
}

curl_close ($ch);

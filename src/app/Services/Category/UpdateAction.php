<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Services\Integration\Api1;
use App\Services\Integration\Api2;

readonly class UpdateAction
{
    public function __construct(private Api1 $api1, private Api2 $api2)
    {
    }

    public function update(Category $category, array $data): Category
    {
        $category->name = $data["name"] . ' from action';

//        if ($data['is_active'] === false) { // @todo сделано для примера, удалить
//            $category->counter = 0;
//        } else {
//            $category->counter = count($category->products);
//        }

        $category->save();

//        $api1 = new Api1('baseurl', 'token'); // @todo сделано для примера, удалить
        $this->api1->send();

//        $api2 = new Api2('baseurl', 'token'); // @todo сделано для примера, удалить
        $this->api2->send();

        return $category;
    }
}

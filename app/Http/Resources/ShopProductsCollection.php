<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;

class ShopProductsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $shopProducts = $this->collection->transform(function ($row) {

            if($row->pod_picture)
            { 
                $producturl = url("public/assets/img/products/".$row->pod_picture);
            }else{
                $producturl = url("public/assets/img/logo.png");
            }
            return [
                "product_id" => ''.$row->pod_id.'',
                "product_name" => $row->pod_pro_name,
                "brand_name" => ''.$row->pod_brand_name !== null ? $row->pod_brand_name :''.'' ,
                "picture_url" => $producturl
            ];
        });

        return $shopProducts;
    }
}

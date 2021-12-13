<?php

namespace App\Http\Controllers\RestApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Http\Request;
use App\Helper\ResponseMessage;
use App\Helper\Exceptions;
use App\Model\Products;
use App\Model\ProductImages;
use App\Model\SellersProducts;
use App\Model\ShippingAddress;
use App\Model\Brands;
use App\Model\WishProduct;
use App\Model\Cart;
use App\Model\FeedBack;
use App\User;
use Mail;
use DB;

class ProductsController extends Controller
{
    public function productDetail(Request $request)
    {
        try
        {
            $productId = $request->product_id;

            if($productId)
            {
                if(Products::where('pod_id',$productId)->where('pod_status',0)->exists())
                {
                    $userId = User::select('id')->where('use_token',$request->token)->where('use_status',0)->first();

                    if($userId)
                    {
                        if(WishProduct::where('wis_user_id',$userId->id)->where('wis_product_id',$request->product_id)->exists())
                        {
                            $wishProduct = WishProduct::where('wis_user_id',$userId->id)->where('wis_product_id',$request->product_id)->first();
                            $wishlistId = $wishProduct->wis_id;
                            $wishlist = 1;

                        }else{
                            $wishlist = 0;
                            $wishlistId = '';
                        }

                    }else{
                        $wishlist = 0;
                        $wishlistId = '';
                    }

                    $productsRecord = Products::join('tbl_main_categorys','tbl_products.pod_main_cat_id','=','tbl_main_categorys.mac_id')->join('tbl_categorys','tbl_products.pod_cat_id','=','tbl_categorys.cat_id')->leftjoin('tbl_sub_categorys','tbl_products.pod_sub_cat_id','=','tbl_sub_categorys.sub_id')->where('pod_id',$productId)->where('pod_status',0)->limit(1)->get();

                    if(!$productsRecord->isEmpty())
                    { 
                        $productDetails = array();
                        $productUrl = array();
                        foreach ($productsRecord as $key => $value)
                        { 

                        $productDetails[] = array(
                            "product_id" => ''.$value->pod_id.'',
                            "product_name" => $value->pod_pro_name,
                            "brand_name" => ''.$value->pod_brand_name.'',
                            "main_category_id" => ''.$value->pod_main_cat_id.'',
                            "category_id" => ''.$value->pod_cat_id.'',
                            "sub_category_id" => ''.$value->pod_sub_cat_id.'',
                            "main_category" => ''.$value->mac_title.'',
                            "category" => ''.$value->cat_name.'',
                            "sub_category" => ''.$value->sub_cat_name.'',
                            "price" => ''.$value->pod_price.'',
                            "offer_price" => ''.$value->pod_offer_price.'',
                            "quantity" => ''.$value->pod_quantity.'',
                            "weight" => ''.$value->pod_weight.'',
                            "description" => ''.$value->pod_pro_description.'',
                            "deal_of_day" => ''.$value->pod_deal_of_day.'',
                            "is_wishlist" => ''.$wishlist.'',
                            "wish_id" => ''.$wishlistId.'',
                            "choose_type" => ''.$value->pod_choose_type.'',
                            "made_in" => ''.$value->pod_made_in.'',
                            "size" => ''.$value->pod_size.'',
                            "colour" => ''.$value->pod_colour.'',
                            "order_with_in" => ''.$value->pod_ord_within.'',
                            "return_policy" => ''.$value->pod_return_policy.'');
                        }

                        array_walk_recursive($productDetails, function (&$item, $key) {
                        $item = null === $item ? '' : $item;
                        });
                        $this->data[$key] = $productDetails;

                        $productsImages = ProductImages::where('pri_product_id',$productId)->where('pri_status',0)->orderBy('pri_id','ASC')->limit(10)->get();

                        if(!$productsImages->isEmpty())
                        {

                            $productPicture = array();
                            foreach ($productsImages as $svalue)
                            { 
                                $productPicture[] = array(
                                    "id" => ''.$svalue->pri_id.'',
                                    "picture" => url("public/assets/img/products/".$svalue->pri_image_name)
                                );
                            }
                            $picture = $productPicture;
                        }else{
                            $picture = array();
                        }

                        $message = "Product detail id wise";
                        return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> $this->data[$key],'pro_picture'=> $picture],JSON_UNESCAPED_SLASHES);

                    }else{
                      $msg = "Product detail isn't available.";
                      return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array(),'pro_picture'=> array()],JSON_UNESCAPED_SLASHES);
                    }
                }else{
                    $msg = "Product id isn't valid!";
                    return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                }
                
            }else{
                $msg = "Product id is required";
                return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }
            
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function sellerProductDetail(Request $request)
    {
        try
        {
            $productId = $request->product_id;
            if($productId)
            {
                if(Products::where('pod_id',$productId)->where('pod_status',0)->exists())
                {
                    $productsRecord = Products::join('tbl_main_categorys','tbl_products.pod_main_cat_id','=','tbl_main_categorys.mac_id')->join('tbl_categorys','tbl_products.pod_cat_id','=','tbl_categorys.cat_id')->leftjoin('tbl_sub_categorys','tbl_products.pod_sub_cat_id','=','tbl_sub_categorys.sub_id')->where('pod_id',$productId)->where('pod_status',0)->limit(1)->get();
                    if(!$productsRecord->isEmpty())
                    { 
                        $productDetails = array();
                        $productUrl = array();
                        foreach ($productsRecord as $key => $value)
                        { 

                        $productDetails[] = array(
                            "product_id" => ''.$value->pod_id.'',
                            "product_name" => $value->pod_pro_name,
                            "brand_name" => ''.$value->pod_brand_name.'',
                            "main_category_id" => ''.$value->pod_main_cat_id.'',
                            "category_id" => ''.$value->pod_cat_id.'',
                            "sub_category_id" => ''.$value->pod_sub_cat_id.'',
                            "main_category" => ''.$value->mac_title.'',
                            "category" => ''.$value->cat_name.'',
                            "sub_category" => ''.$value->sub_cat_name.'',
                            "price" => ''.$value->pod_price.'',
                            "offer_price" => ''.$value->pod_offer_price.'',
                            "quantity" => ''.$value->pod_quantity.'',
                            "weight" => ''.$value->pod_weight.'',
                            "description" => ''.$value->pod_pro_description.'',
                            "deal_of_day" => ''.$value->pod_deal_of_day.'',
                            "choose_type" => ''.$value->pod_choose_type.'');
                        }

                        array_walk_recursive($productDetails, function (&$item, $key) {
                        $item = null === $item ? '' : $item;
                        });
                        $this->data[$key] = $productDetails;

                        $productsImages = ProductImages::where('pri_product_id',$productId)->where('pri_status',0)->orderBy('pri_id','ASC')->limit(10)->get();

                        if(!$productsImages->isEmpty())
                        {

                            $productPicture = array();
                            foreach ($productsImages as $svalue)
                            { 
                                $productPicture[] = array(
                                    "id" => ''.$svalue->pri_id.'',
                                    "picture" => url("public/assets/img/products/".$svalue->pri_image_name)
                                );
                            }
                            $picture = $productPicture;
                        }else{
                            $picture = array();
                        }

                        $message = "Product detail id wise";
                        return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> $this->data[$key],'pro_picture'=> $picture],JSON_UNESCAPED_SLASHES);

                    }else{
                      $msg = "Product detail isn't available.";
                      return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
                    }
                }else{
                    $msg = "Product id isn't valid!";
                    return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                }
                
            }else{
                $msg = "Product id is required";
                return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }
            
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function sellerProductList(Request $request)
    {
        try
        {
            $userToken = $request->token;
            if($userToken)
            {
                if(User::where('use_token',$userToken)->where('use_status',0)->exists())
                {
                    $userDetails = User::select('id')->where('use_token',$userToken)->where('use_status',0)->first();
                    $productsRecord = Products::join('tbl_main_categorys','tbl_products.pod_main_cat_id','=','tbl_main_categorys.mac_id')->join('tbl_categorys','tbl_products.pod_cat_id','=','tbl_categorys.cat_id')->leftjoin('tbl_sub_categorys','tbl_products.pod_sub_cat_id','=','tbl_sub_categorys.sub_id')->where('pod_seller_id',$userDetails->id)->where('pod_status',0)->get();

                    if(!$productsRecord->isEmpty())
                    { 
                        $productDetails = array();
                        foreach ($productsRecord as $key => $value)
                        { 
                            $productUrl = url("public/assets/img/products/".$value->pod_picture);
                            $productDetails[] = array(
                                "product_id" => ''.$value->pod_id.'',
                                "product_name" => $value->pod_pro_name,
                                "brand_name" => ''.$value->pod_brand_name.'',
                                "main_category_id" => ''.$value->pod_main_cat_id.'',
                                "category_id" => ''.$value->pod_cat_id.'',
                                "sub_category_id" => ''.$value->pod_sub_cat_id.'',
                                "main_category" => ''.$value->mac_title.'',
                                "category" => ''.$value->cat_name.'',
                                "sub_category" => ''.$value->sub_cat_name.'',
                                "price" => ''.$value->pod_price.'',
                                "offer_price" => ''.$value->pod_offer_price.'',
                                "quantity" => ''.$value->pod_quantity.'',
                                "description" => ''.$value->pod_pro_description.'',
                                "deal_of_day" => ''.$value->pod_deal_of_day.'',
                                "choose_type" => ''.$value->pod_choose_type.'',
                                'picture_url' => $productUrl);
                        }

                        array_walk_recursive($productDetails, function (&$item, $key) {
                        $item = null === $item ? '' : $item;
                        });
                        $this->data[$key] = $productDetails;

                        $message = "Product detail seller wise";
                        return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

                    }else{
                      $msg = "Product detail seller wise";
                      return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
                    }
                }else{
                    ResponseMessage::error("Seller isn't exists!");
                }
               
            }else{
                ResponseMessage::error("Token is required!");
            }
            
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }


    public function searchProductList(Request $request) 
    {
        try
        {
            $title = $request->title;
            if($title)
            {
                 $productsRecord = Products::join('tbl_categorys','tbl_products.cat_id','=','tbl_categorys.cat_id')->leftjoin('tbl_sub_categorys','tbl_products.pod_sub_cat_id','=','tbl_sub_categorys.sub_id')->where('pod_pro_name','like','%'.$title.'%')->where('pod_status',0)->get();

                if(!$productsRecord->isEmpty())
                { 
                    $productDetails = array();
                    foreach ($productsRecord as $key => $value)
                    { 
                        $productUrl = url("public/assets/img/products/".$value->pod_picture);
                        $productDetails[] = array(
                            "product_id" => ''.$value->pod_id.'',
                            "name" => $value->pod_pro_name,
                            "brand" => ''.$value->pod_brand_name.'',
                            "category" => ''.$value->cat_name.'',
                            "sub_category" => ''.$value->sub_cat_name.'',
                            "price" => ''.$value->pod_price.'',
                            "offer_price" => ''.$value->pod_offer_price.'',
                            "quantity" => ''.$value->pod_quantity.'',
                            "description" => ''.$value->pod_pro_description.'',
                            'picture_url' => $productUrl);
                    }

                    array_walk_recursive($productDetails, function (&$item, $key) {
                    $item = null === $item ? '' : $item;
                    });
                    $this->data[$key] = $productDetails;

                    $message = "Product detail id wise";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

                }else{
                  $msg = "Product detail isn't available.";
                  return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
                }
            }else{
                  $msg = "Product detail isn't available.";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
                }
           
            
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function categoryProductList(Request $request) 
    {
        try
        {
            $categoryId = $request->cat_id;
            if($categoryId)
            {
                $productsRecord = Products::where('pod_sub_cat_id',$categoryId)->where('pod_status',0)->get();
                if(!$productsRecord->isEmpty())
                { 
                    $productDetails = array();
                    foreach ($productsRecord as $key => $value)
                    { 
                        $productDetails[] = array(
                            "product_id" => ''.$value->pod_id.'',
                            "product_name" => $value->pod_pro_name,
                            "brand_name" => ''.$value->pod_brand_name.'',
                            "main_category_id" => ''.$value->pod_main_cat_id.'',
                            "category_id" => ''.$value->pod_cat_id.'',
                            "sub_category_id" => ''.$value->pod_sub_cat_id.'',
                            "price" => ''.$value->pod_price.'',
                            "offer_price" => ''.$value->pod_offer_price.'',
                            "quantity" => ''.$value->pod_quantity.'',
                            "description" => ''.$value->pod_pro_description.'',
                            "deal_of_day" => ''.$value->pod_deal_of_day.'',
                            "choose_type" => ''.$value->pod_choose_type.'');
                    }

                    array_walk_recursive($productDetails, function (&$item, $key) {
                    $item = null === $item ? '' : $item;
                    });
                    $this->data[$key] = $productDetails;
                    ResponseMessage::success("Product detail category id wise",$this->data[$key]);

                }else{
                  $isEmptyData = array();
                  ResponseMessage::success("Product detail isn't available.",$isEmptyData);
                }
            }else{
                ResponseMessage::error("category id is required!");
            }
            
            
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    // Seller Id wise product list
    public function productSellerIdwiseList(Request $request) 
    {
        try
        {  
            $sellerId = $request->seller_id;
            if($sellerId)
            {
                
                $productsRecord = Products::join('tbl_main_categorys','tbl_products.pod_main_cat_id','=','tbl_main_categorys.mac_id')->join('tbl_categorys','tbl_products.pod_cat_id','=','tbl_categorys.cat_id')->leftjoin('tbl_sub_categorys','tbl_products.pod_sub_cat_id','=','tbl_sub_categorys.sub_id')->where('pod_seller_id',$sellerId)->where('pod_status',0)->get();
                
                if(!$productsRecord->isEmpty())
                { 
                    $productDetails = array();
                    foreach ($productsRecord as $key => $value)
                    { 
                        $productUrl = url("public/assets/img/products/".$value->pod_picture);
                        $productDetails[] = array(
                            "product_id" => ''.$value->pod_id.'',
                            "product_name" => $value->pod_pro_name,
                            "brand_name" => ''.$value->pod_brand_name.'',
                            "main_category_id" => ''.$value->pod_main_cat_id.'',
                            "category_id" => ''.$value->pod_cat_id.'',
                            "sub_category_id" => ''.$value->pod_sub_cat_id.'',
                            "main_category" => ''.$value->mac_title.'',
                            "category" => ''.$value->cat_name.'',
                            "sub_category" => ''.$value->sub_cat_name.'',
                            "price" => ''.$value->pod_price.'',
                            "offer_price" => ''.$value->pod_offer_price.'',
                            "quantity" => ''.$value->pod_quantity.'',
                            "description" => ''.$value->pod_pro_description.'',
                            "deal_of_day" => ''.$value->pod_deal_of_day.'',
                            "choose_type" => ''.$value->pod_choose_type.'',
                            'picture_url' => $productUrl);
                    }
                    array_walk_recursive($productDetails, function (&$item, $key) {
                    $item = null === $item ? '' : $item;
                    });
                    $this->data[$key] = $productDetails;
                    ResponseMessage::success("Product detail seller id wise",$this->data[$key]);

                }else{
                  $isEmptyData = array();
                  ResponseMessage::success("Product detail isn't available.",$isEmptyData);
                }
            }else{
                ResponseMessage::error("Seller id is required!");
            }
            
            
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function addProduct(Request $request)
    {
        $rules = [
            'seller_id' => 'required',
            'product_name' => 'required',
            'brand_name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'choose_type'=> 'required',
            ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {                
                return json_encode(['status' => false, 'error' => '401', 'message' => $message],JSON_UNESCAPED_SLASHES);
            }
        }else
        {
            if(User::where('id',$request->seller_id)->where('use_status',0)->exists())
            {
                $lastId = Products::select('pod_id')->orderBy('pod_id','DESC')->limit(1)->first();
                
                if($lastId)
                {
                    $id = $lastId->pod_id;
                }else{
                    $id = "00000";
                }

                if ($id<=129999)
                {
                    $num     = $id;
                    $letters = range('A', 'Z');
                    $letter  = (int) $num / 50000;
                    $num     = $num % 50000 + 1;
                    $num     = str_pad($num, 5, 0, STR_PAD_LEFT);
                    $uniId =  $letters[$letter] . $num;

                }

                $uId = substr($uniId,1);
                $products_Id = 'PRODUCT'.$uId;

                $permitted_chars = 'abcdefghijklmnopqrstuvwxyz';
                $uniqueId = substr(str_shuffle($permitted_chars), 0, 25);

                $userDetails = User::where('id',$request->seller_id)->first();

                $insertData = new Products;
                $insertData['pod_unique_id'] = $id.'-'.$uniqueId;
                $insertData['pod_pro_id'] = $products_Id;
                $insertData['pod_pro_name'] = $request->product_name;
                $insertData['pod_brand_name'] = $request->brand_name;
                $insertData['pod_main_cat_id'] = $request->main_cat_id;
                $insertData['pod_cat_id'] = $request->cat_id;
                $insertData['pod_sub_cat_id'] = $request->sub_cat_id ? $request->sub_cat_id:0;
                $insertData['pod_pro_description'] = '';
                $insertData['pod_price'] = $request->price;
                $insertData['pod_offer_price'] = $request->offer_price ? $request->offer_price:0.0;
                $insertData['pod_quantity'] = $request->quantity ? $request->quantity:1;
                $insertData['pod_weight'] = $request->weight ? $request->weight:'';
                $insertData['pod_picture'] = 'default-picture.jpg';
                $insertData['pod_deal_of_day'] = $request->is_deal_day ? $request->is_deal_day:0; //    0 = No , 1 = Yes
                $insertData['pod_choose_type'] = $request->choose_type ? $request->choose_type:1; //    1 = New , 2 = Ads 3 = Old
                $insertData['pod_status'] = 1;
                $insertData['pod_seller_id'] = $request->seller_id;
                $insertData['pod_village_id'] = $userDetails->use_village_id;
                $insertData['pod_createat'] = date('Y-m-d H:i:s');
                $insertData['pod_updateat'] = date('Y-m-d H:i:s');
                $insertData->save();
                   
                if($insertData)
                {
                    $msg = "Product added successfully";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                }else{
                    $msg = "Product isn't added";
                    return json_encode(['status' => true, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                }
            }{
                $msg = "Seller id isn't valid!";
                    return json_encode(['status' => true, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }
        }
    }

    public function updateProduct(Request $request)
    {
         $rules = [
            'product_id' => 'required',
            'seller_id' => 'required',
            'product_name' => 'required',
            'brand_name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'choose_type'=> 'required',
            ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {                
                return json_encode(['status' => false, 'error' => '401', 'message' => $message],JSON_UNESCAPED_SLASHES);
            }
        }else
        {
            if(User::where('id',$request->seller_id)->where('use_status',0)->exists())
            {

            $userDetails = User::where('id',$request->seller_id)->first();

            $updateData['pod_pro_name'] = $request->product_name;
            $updateData['pod_brand_name'] = $request->brand_name;
            $updateData['pod_main_cat_id'] = $request->main_cat_id;
            $updateData['pod_cat_id'] = $request->cat_id;
            $updateData['pod_sub_cat_id'] = $request->sub_cat_id ? $request->sub_cat_id:0;
            $updateData['pod_price'] = $request->price;
            $updateData['pod_offer_price'] = $request->offer_price ? $request->offer_price:0.0;
            $updateData['pod_quantity'] = $request->quantity ? $request->quantity:1;
            $updateData['pod_weight'] = $request->weight;
            $updateData['pod_deal_of_day'] = $request->is_deal_day ? $request->is_deal_day:0; //    0 = No , 1 = Yes
            $updateData['pod_choose_type'] = $request->choose_type ? $request->choose_type:1; //    1 = New , 2 = Ads 3 = Old
            $updateData['pod_status'] = 1;
            $updateData['pod_seller_id'] = $request->seller_id;
            $updateData['pod_village_id'] = $userDetails->use_village_id;
            $updateData['pod_createat'] = date('Y-m-d H:i:s');
            $updateData['pod_updateat'] = date('Y-m-d H:i:s');
            $updateDetails = Products::where('pod_id',$request->product_id)->update($updateData);
               
            if($updateDetails)
            {
                 ResponseMessage::successMessage("Product updated successfully");
               
            }else{
                ResponseMessage::error("Product isn't updated");
            }
            }else{
                $msg = "Seller id isn't valid!";
                return json_encode(['status' => true, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }
        }
    }

    public function deleteProduct(Request $request)
    { 
        $id = $request->product_id;
        if($id)
        {
            if(Products::where('pod_id',$id)->exists())
            {
                Products::where('pod_id',$id)->delete();
                $msg = "Product is deleted";
                return json_encode(['status' => true, 'error' => '200', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }else{
                $msg = "Product id isn't valid!";
                return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }
        }else{
            $msg = "Product id is required";
            return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES); 
        }
    }

    // ------------------------------- BEGIN CART PRODUCT MODULE -----------------------

    public function addCartProduct(Request $request)
    {
        $rules = [
            'token' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {                
                return json_encode(['status' => false, 'error' => '401', 'message' => $message],JSON_UNESCAPED_SLASHES);
            }
        }else
        {
            if(User::where('use_token',$request->token)->where('use_status',0)->exists())
            {
                $userId = User::where('use_token',$request->token)->where('use_status',0)->first();

                if(Products::where('pod_id',$request->product_id)->where('pod_status',0)->exists())
                {
                    if(Cart::where('crt_user_id',$userId->id)->where('crt_product_id',$request->product_id)->exists())
                    {
                        $cartProduct = Cart::where('crt_user_id',$userId->id)->where('crt_product_id',$request->product_id)->first();

                        $quantity = $cartProduct->crt_quantity + $request->quantity;
                        $unit_price = $cartProduct->crt_unit_price;
                        $total_price = $unit_price * $quantity;

                        $update['crt_quantity'] = $quantity;
                        $update['crt_total'] = $total_price;
                        $updateProduct = Cart::where('crt_id',$cartProduct->crt_id)->update($update);

                        // --------------------- BEGIN NOTIFICATION -------------------------

                        $productsRecord = Products::select('pod_id','pod_pro_name','pod_deal_of_day','pod_price','pod_offer_price')->where('pod_id',$request->product_id)->where('pod_status',0)->first();

                        $products = Products::where('pod_id',$request->product_id)->first();

                        $getToken = User::select('use_fcm_token')->where('use_token',$request->token)->first();
          
                            if($getToken)
                            {
                              
                              $notificationMessage = [
                                    'message' => $productsRecord->pod_pro_name. "added into cart",
                                    'title' => 'Your product added into cart - Ready Shopping',
                                    'product_id' => $request->product_id,
                                    'sound' => "default",
                                    'color' => "#203E78",
                                    'type' => 'add_product_cart'
                                ];
                
                              $fields = array(
                                'registration_ids' => array($getToken->use_fcm_token),
                                'priority' => 'high',
                                'aps'=>array('alert'=>array('title'=>'test','body'=>'body'), 'content-available'=>1,'mutable_content' =>1),
                                "type" => "add_product_cart",
                
                                'headers' => array( 'apns-priority' => '10'),
                                "content_available"=> true,
                                'notification'=> $notificationMessage,
                                'data' => array(
                                    'title' => 'Your product added into cart - Ready Shopping',
                                    "date" => date('d-m-Y H:i:s'),
                                    "message" => $productsRecord->pod_pro_name. "added into cart",
                                    'product_id' => $request->product_id,
                                    "type" => "add_product_cart", // post,
                                    'vibrate'   => 1,
                                    'sound'     => 1
                                )
                            );
                
                              $url = 'https://fcm.googleapis.com/fcm/send';
                              $fields = json_encode ( $fields );
                              $headers = array (
                                  'Authorization: key=' . "AAAAHe-duRk:APA91bGEv0jCgb6MPodLue5UpJjhZNTt6ujobq-Limx3Il-PDXH84hyFvqy2VYkPSfa-TU3FOGX34t7uh5S7c5_xsisLCSUP1cYQvO3yEEgH2AgKZnAjo5e2bP6ahjVfR0QKhnYmU37M",
                                  'Content-Type: application/json'
                              );
                
                              $ch = curl_init ();
                              curl_setopt ( $ch, CURLOPT_URL, $url );
                              curl_setopt ( $ch, CURLOPT_POST, true );
                              curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
                              curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
                              curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
                
                              $result = curl_exec ( $ch );
                              curl_close ( $ch );
                            }

                        // ---------------------- END NOTIFICATION -------------------------------

                        if($updateProduct)
                        {
                            ResponseMessage::successMessage("Success! Item successfully added from cartlist.");
                        }else{
                            ResponseMessage::error("Error! Item is'nt added from cartlist.");
                        }

                    }else{

                        $productsRecord = Products::select('pod_id','pod_pro_name','pod_deal_of_day','pod_price','pod_offer_price')->where('pod_id',$request->product_id)->where('pod_status',0)->first();
                        
                        $dealOfday = $productsRecord->pod_deal_of_day;

                        if($dealOfday == 0)
                        {
                            $price = $productsRecord->pod_price;
                        }else{
                            $price = $productsRecord->pod_offer_price;
                        }

                        $insertData = new Cart;
                        $insertData['crt_user_id'] = $userId->id;
                        $insertData['crt_product_id'] = $request->product_id;
                        $insertData['crt_quantity'] = $request->quantity ? $request->quantity:1;
                        $insertData['crt_product_name'] = $productsRecord->pod_pro_name;
                        $insertData['crt_colour'] = $request->colour ? $request->colour:'';
                        $insertData['crt_size'] = $request->size ? $request->size:'';
                        $insertData['crt_unit_price'] = $price;
                        $insertData['crt_total'] = $request->quantity * $price;
                        $insertData['crt_status'] = 0;
                        $insertData['crt_createat'] = date('Y-m-d H:i:s');
                        $insertData['crt_updateat'] = date('Y-m-d H:i:s');
                        $insertData->save();

                        // --------------------- BEGIN NOTIFICATION -------------------------

                        $products = Products::where('pod_id',$request->product_id)->first();

                        $getToken = User::select('use_fcm_token')->where('use_token',$request->token)->first();
          
                            if($getToken)
                            {
                              
                              $notificationMessage = [
                                    'message' => $productsRecord->pod_pro_name. "added into cart",
                                    'title' => 'Your product added into cart - Ready Shopping',
                                    'product_id' => $request->product_id,
                                    'sound' => "default",
                                    'color' => "#203E78",
                                    'type' => 'add_product_cart'
                                ];
                
                              $fields = array(
                                'registration_ids' => array($getToken->use_fcm_token),
                                'priority' => 'high',
                                'aps'=>array('alert'=>array('title'=>'test','body'=>'body'), 'content-available'=>1,'mutable_content' =>1),
                                "type" => "add_product_cart",
                
                                'headers' => array( 'apns-priority' => '10'),
                                "content_available"=> true,
                                'notification'=> $notificationMessage,
                                'data' => array(
                                    'title' => 'Your product added into cart - Ready Shopping',
                                    "date" => date('d-m-Y H:i:s'),
                                    "message" => $productsRecord->pod_pro_name. "added into cart",
                                    'product_id' => $request->product_id,
                                    "type" => "add_product_cart", // post,
                                    'vibrate'   => 1,
                                    'sound'     => 1
                                )
                            );
                
                              $url = 'https://fcm.googleapis.com/fcm/send';
                              $fields = json_encode ( $fields );
                              $headers = array (
                                  'Authorization: key=' . "AAAAHe-duRk:APA91bGEv0jCgb6MPodLue5UpJjhZNTt6ujobq-Limx3Il-PDXH84hyFvqy2VYkPSfa-TU3FOGX34t7uh5S7c5_xsisLCSUP1cYQvO3yEEgH2AgKZnAjo5e2bP6ahjVfR0QKhnYmU37M",
                                  'Content-Type: application/json'
                              );
                
                              $ch = curl_init ();
                              curl_setopt ( $ch, CURLOPT_URL, $url );
                              curl_setopt ( $ch, CURLOPT_POST, true );
                              curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
                              curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
                              curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
                
                              $result = curl_exec ( $ch );
                              curl_close ( $ch );
                            }

                        // ---------------------- END NOTIFICATION -------------------------------

                        if($insertData)
                        {
                            ResponseMessage::successMessage("Success! Item successfully added from cartlist.");
                        }else{
                            ResponseMessage::error("Error! Item is'nt added from cartlist.");
                        }
                    }
                }else{
                    ResponseMessage::error("Product isn't valid!");
                }
            }else
            {
                ResponseMessage::error("User isn't exists!");
            }
        }
    }

    // User wise cart list 
    public function productCartList(Request $request) 
    {
        try
        {  
            $userToken = $request->token;
            if($userToken)
            {
                if(User::where('use_token',$userToken)->where('use_status',0)->exists())
                {
                    $userId = User::where('use_token',$request->token)->where('use_status',0)->first();

                    $productsRecord = Cart::join('tbl_products','tbl_cart.crt_product_id','=','tbl_products.pod_id')->where('crt_user_id',$userId->id)->where('crt_status',0)->get();

                    $totalSum = Cart::where('crt_user_id',$userId->id)->sum('crt_total');

                     $productsCount = Cart::where('crt_user_id',$userId->id)->where('crt_status',0)->count();
                    if(!$productsRecord->isEmpty())
                    { 
                        $productDetails = array();
                        foreach ($productsRecord as $key => $value)
                        { 
                            if($userId)
                            {
                                if(WishProduct::where('wis_user_id',$userId->id)->where('wis_product_id',$value->pod_id)->exists())
                                {
                                    $wishProduct = WishProduct::where('wis_user_id',$userId->id)->where('wis_product_id',$value->pod_id)->first();
                                    if($wishProduct){
                                        $wishlistId = $wishProduct->wis_id;
                                    }else{
                                        $wishlistId = '';
                                    }
                                    
                                    $wishlist = 1;

                                }else{
                                    $wishlist = 0;
                                    $wishlistId = '';
                                }

                            }else{
                                $wishlist = 0;
                                $wishlistId = '';
                            }
                    
                            $productUrl = url("public/assets/img/products/".$value->pod_picture);
                            $productDetails[] = array(
                                "cart_id" => ''.$value->crt_id.'',
                                "product_id" => ''.$value->pod_id.'',
                                "title" => $value->pod_pro_name,
                                "brand" => ''.$value->pod_brand_name.'',
                                "colour" => ''.$value->crt_colour.'',
                                "size" => ''.$value->crt_size.'',
                                "price" => ''.$value->crt_unit_price.'',
                                "quantity" => ''.$value->crt_quantity.'',
                                "description" => ''.$value->pod_pro_description.'',
                                "total" => ''.$value->crt_total.'',
                                "wishlist" => ''.$wishlist.'',
                                "wish_id" => ''.$wishlistId.'',
                                'picture_url' => $productUrl);
                        }
                        array_walk_recursive($productDetails, function (&$item, $key) {
                        $item = null === $item ? '' : $item;
                        });
                        $this->data[$key] = $productDetails;

                        $msg = "Cart products detail";
                        return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'cart_count' => $productsCount,'final_total' => $totalSum,'data' => $this->data[$key]],JSON_UNESCAPED_SLASHES);

                    }else{
                      $isEmptyData = array();
                      ResponseMessage::success("Cart detail isn't available.",$isEmptyData);
                    }
                }else{
                    ResponseMessage::error("User isn't exists!");
                }
               
            }else{
                ResponseMessage::error("Token is required!");
            }
            
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function deleteCartProduct(Request $request)
    { 
        $id = $request->cart_id;
        if($id)
        {
            if(Cart::where('crt_id',$id)->exists())
            {
                Cart::where('crt_id',$id)->delete();
                ResponseMessage::successMessage("Success! Item successfully deleted from cartlist.");
            }else{
                ResponseMessage::error("Cart id isn't valid!");
            }
        }else{
            ResponseMessage::error("Cart id is required!");
        }
    }


    // ------------------------------- END CART PRODUCT MODULE -----------------------

    // ------------------------------- BEGIN WISH PRODUCT MODULE -----------------------

    public function addWishProduct(Request $request)
    {
        $rules = [
            'token' => 'required',
            'product_id' => 'required',
            ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {                
                return json_encode(['status' => false, 'error' => '401', 'message' => $message],JSON_UNESCAPED_SLASHES);
            }
        }else
        {
            if(User::where('use_token',$request->token)->where('use_status',0)->exists())
            {
                $userId = User::where('use_token',$request->token)->where('use_status',0)->first();

                if(WishProduct::where('wis_user_id',$userId->id)->where('wis_product_id',$request->product_id)->exists())
                {
                    ResponseMessage::error("Item already exists in wishlist");
                }else{
                    $insertData = new WishProduct;
                    $insertData['wis_user_id'] = $userId->id;
                    $insertData['wis_product_id'] = $request->product_id;
                    $insertData['wis_status'] = 0;
                    $insertData['wis_createat'] = date('Y-m-d H:i:s');
                    $insertData['wis_updateat'] = date('Y-m-d H:i:s');
                    $insertData->save();

                    if($insertData)
                    {
                        ResponseMessage::successMessage("Success! Item successfully added from wishlist.");
                    }else{
                        ResponseMessage::error("Error! Item is'nt added from wishlist.");
                    }
                }
            }else
            {
                ResponseMessage::error("User isn't exists!");
            }
        }
    }

    // User wise cart list 
    public function productWishList(Request $request) 
    {
        try
        {  
            $userToken = $request->token;
            if($userToken)
            {
                if(User::where('use_token',$userToken)->where('use_status',0)->exists())
                {
                    $userId = User::where('use_token',$request->token)->where('use_status',0)->first();

                     $productsRecord = WishProduct::join('tbl_products','tbl_wish_product.wis_product_id','=','tbl_products.pod_id')->where('wis_user_id',$userId->id)->where('wis_status',0)->get();
                     $productsCount = WishProduct::where('wis_user_id',$userId->id)->where('wis_status',0)->count();
                    if(!$productsRecord->isEmpty())
                    { 
                        $productDetails = array();
                        foreach ($productsRecord as $key => $value)
                        { 
                            $productUrl = url("public/assets/img/products/".$value->pod_picture);
                            $productDetails[] = array(
                                "wish_id" => ''.$value->wis_id.'',
                                "product_id" => ''.$value->pod_id.'',
                                "title" => $value->pod_pro_name,
                                "brand" => ''.$value->pod_brand_name.'',
                                "price" => ''.$value->pod_price.'',
                                "offer_price" => ''.$value->pod_offer_price.'',
                                "quantity" => ''.$value->pod_quantity.'',
                                "description" => ''.$value->pod_pro_description.'',
                                'picture_url' => $productUrl);
                        }
                        array_walk_recursive($productDetails, function (&$item, $key) {
                        $item = null === $item ? '' : $item;
                        });
                        $this->data[$key] = $productDetails;

                        $msg = "Wish products detail";
                        return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'wish_count' => $productsCount,'data' => $this->data[$key]],JSON_UNESCAPED_SLASHES);

                    }else{
                        $isEmptyData = array();
                        $msg = "Wish detail isn't available.";
                        return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'wish_count' => '0','data' => $isEmptyData],JSON_UNESCAPED_SLASHES);
                    }
                }else{
                    ResponseMessage::error("User isn't exists!");
                }
            }else{
                ResponseMessage::error("Token is required!");
            }
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function deleteWishProduct(Request $request)
    { 
        $id = $request->wish_id;
        if($id)
        {
            if(WishProduct::where('wis_id',$id)->exists())
            {
                WishProduct::where('wis_id',$id)->delete();
                ResponseMessage::successMessage("Success! Item successfully deleted from wishlist.");
            }else{
                ResponseMessage::error("Wish id isn't valid!");
            }
        }else{
            ResponseMessage::error("Wish id is required!");
        }
    }
    // ------------------------------- END WISH PRODUCT MODULE -----------------------

    // ------------------------------- BEGIN FEEDBACK PRODUCT MODULE -----------------------

    public function addFeedback(Request $request)
    {
        $rules = [
            'token' => 'required',
            'content' => 'required',
            ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {                
                return json_encode(['status' => false, 'error' => '401', 'message' => $message],JSON_UNESCAPED_SLASHES);
            }
        }else
        {
            if(User::where('use_token',$request->token)->where('use_status',0)->exists())
            {
                $userId = User::where('use_token',$request->token)->where('use_status',0)->first();

                if(FeedBack::where('fed_user_id',$userId->id)->where('fed_content',$request->fed_content)->exists())
                {
                    ResponseMessage::error("Your Feedback already exists!");
                }else{
                    $insertData = new FeedBack;
                    $insertData['fed_user_id'] = $userId->id;
                    $insertData['fed_content'] = $request->content;
                    $insertData['fed_status'] = 0;
                    $insertData['fed_createat'] = date('Y-m-d H:i:s');
                    $insertData['fed_updateat'] = date('Y-m-d H:i:s');
                    $insertData->save();

                    if($insertData)
                    {
                        ResponseMessage::successMessage("Success! Feedback successfully added.");
                    }else{
                        ResponseMessage::error("Error! Feedback is'nt added.");
                    }
                }
            }else
            {
                ResponseMessage::error("User isn't exists!");
            }
        }
    }

    // ------------------------------- END FEEDBACK PRODUCT MODULE -----------------------

    // ------------------------------- BEGIN SHIPPING ADDRESS MODULE -----------------------

    public function addShippingAddress(Request $request)
    {
        $rules = [
            'token' => 'required',
            'address' => 'required',
            ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {                
                return json_encode(['status' => false, 'error' => '401', 'message' => $message],JSON_UNESCAPED_SLASHES);
            }
        }else
        {
            if(User::where('use_token',$request->token)->where('use_status',0)->exists())
            {
                $userId = User::where('use_token',$request->token)->where('use_status',0)->first();

                if(ShippingAddress::where('sip_user_id',$userId->id)->where('sip_address',$request->address)->exists())
                {
                    ResponseMessage::error("Your address already exists in this product");
                }else{
                    $insertData = new ShippingAddress;
                    $insertData['sip_user_id'] = $userId->id;
                    $insertData['sip_address'] = $request->address;
                    $insertData['sip_status'] = 0;
                    $insertData['sip_createat'] = date('Y-m-d H:i:s');
                    $insertData['sip_updateat'] = date('Y-m-d H:i:s');
                    $insertData->save();

                    if($insertData)
                    {
                        ResponseMessage::successMessage("Success! Address successfully added.");
                    }else{
                        ResponseMessage::error("Error! Address is'nt added.");
                    }
                }
            }else
            {
                ResponseMessage::error("User isn't exists!");
            }
        }
    }

     // User wise cart list 
    public function shippingAddressList(Request $request) 
    {
        try
        {  
            $userToken = $request->token;
            if($userToken)
            {
                if(User::where('use_token',$userToken)->where('use_status',0)->exists())
                {
                    $userId = User::where('use_token',$request->token)->where('use_status',0)->first();

                     $addressRecord = ShippingAddress::where('sip_user_id',$userId->id)->where('sip_status',0)->get();
                    if(!$addressRecord->isEmpty())
                    { 
                        $addressDetails = array();
                        foreach ($addressRecord as $key => $value)
                        { 
                            $addressDetails[] = array(
                                "address_id" => ''.$value->sip_id.'',
                                "address" => ''.$value->sip_address.'',
                              );
                        }
                        array_walk_recursive($addressDetails, function (&$item, $key) {
                        $item = null === $item ? '' : $item;
                        });
                        $this->data[$key] = $addressDetails;

                        $msg = "Address detail";
                        return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => $this->data[$key]],JSON_UNESCAPED_SLASHES);

                    }else{
                        $isEmptyData = array();
                        $msg = "Address isn't available.";
                        return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => $isEmptyData],JSON_UNESCAPED_SLASHES);
                    }
                }else{
                    ResponseMessage::error("User isn't exists!");
                }
            }else{
                ResponseMessage::error("Token is required!");
            }
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function deleteShippingAddress(Request $request)
    { 
        $id = $request->address_id;
        if($id)
        {
            if(ShippingAddress::where('sip_id',$id)->exists())
            {
                ShippingAddress::where('sip_id',$id)->delete();
                ResponseMessage::successMessage("Success! Address successfully deleted");
            }else{
                ResponseMessage::error("Address id isn't valid!");
            }
        }else{
            ResponseMessage::error("Address id is required!");
        }
    }

    // ------------------------------- END SHIPPING ADDRESS MODULE -----------------------
}
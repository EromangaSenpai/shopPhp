<?php
require 'db.php';

if (!R::testConnection())
    exit ('Нет соединения с базой данных');

class ProductInfo
{
    public $goods;
    public $info;
    public $goodsArr;

    public function __construct()
    {
        $this->info = null;
        $this->goods = R::findAll('goods');
        $this->goodsArr = array('smartphones' => array(), 'laptops' => array(), 'tvs' => array());
        $this->GetGoods();
    }

    private function IsAvailable($product_amount){
        if($product_amount > 0)
            return true;
        else
            return false;
    }

    private function GetGoods()
    {
        if(!empty($this->goods))
        {
            $n_smartphone = 0;
            $n_laptop = 0;
            $n_tv = 0;

            foreach ($this->goods as $item)
            {
                $id = $item->id;
                $image_path = $item->image_path;
                $description = $item->description;
                $product_name = $item->productname;
                $firm_name = $item->firmname;
                $color = $item->color;
                $price = $item->price;
                $type = $item->type;
                $available = $this->IsAvailable($item->amount);
                switch ($item->type)
                {
                    case 'smartphone':
                        $this->goodsArr['smartphones'][$n_smartphone] = " <div class=\"col-lg-3 mb-4 div-column-style\">
                    <a href=$image_path>
                        <img src=$image_path class=\"img-thumbnail zoom\" style=\"background-color: $color; width: 304px; height:236px\" alt=\"Image\" width=\"304px\" height=\"236px\">
                        <div class=\"caption text-primary\">
                            <div class=\"vis-hidden\" style=\"visibility: hidden\">$id</div>
                           
                            <p>$firm_name $product_name</p>
                            <hr>
                            <p>Price: $price</p>
                            <hr>
                             </a>
                            <button type=\"button\" class=\"btn btn-outline-primary btn-block\" onclick=\"AddToCart(this, productId = $id)\">Add to cart</button>
                        </div>
                   
                </div>";
                        $n_smartphone++;
                        break;

                    case 'laptop':
                        $this->goodsArr['laptops'][$n_laptop] = " <div class=\"col-lg-3 mb-4 div-column-style\">
                    <a href=$image_path>
                        <img src=$image_path class=\"img-thumbnail zoom\" style=\"background-color: $color; width: 304px; height:236px\" alt=\"Image\" width=\"304px\" height=\"236px\">
                        <div class=\"caption text-primary\">
                            <div class=\"vis-hidden\" style=\"visibility: hidden\">$id</div>
                         
                            <p>$firm_name $product_name</p>
                            <hr>
                            <p>Price: $price</p>
                            <hr>
                            </a>
                            <button type=\"button\" class=\"btn btn-outline-primary btn-block\" onclick=\"AddToCart(this productId = $id)\">Add to cart</button>
                        </div>
                    
                </div>";
                        $n_laptop++;
                        break;

                    case 'tv':
                        $this->goodsArr['tvs'][$n_tv] = " <div class=\"col-lg-3 mb-4 div-column-style\">
                    <a href=$image_path>
                        <img src=$image_path class=\"img-thumbnail zoom\" style=\"background-color: $color; width: 304px; height:236px\" alt=\"Image\" width=\"304px\" height=\"236px\">
                        <div class=\"caption text-primary\">
                          
                            <div class=\"vis-hidden\" style=\"visibility: hidden\">$id</div>
                            <p>$firm_name $product_name</p>
                            <hr>
                            <p>Price: $price</p>
                            <hr>
                            </a>
                            <button type=\"button\" class=\"btn btn-outline-primary btn-block\" onclick=\"AddToCart(this productId = $id)\">Add to cart</button>
                        </div>
                    
                </div>";
                        $n_tv++;
                        break;
                }
            }
        }
        else
            $this->info = "<marquee behavior=\"scroll\" direction=\"left\" class='bg-info' loop='-1' scrollamount='10' >DB is empty</marquee>";
    }


}
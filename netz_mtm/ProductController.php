<?php
namespace Netz\NetzMtmShop\Controller;
use TYPO3\CMS\Core\Utility\GeneralUtility;


/***
 *
 * This file is part of the "Kemper System" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 saurav dalai <saurav.dalai@netzrezepte.de>
 *
 ***/

/**
 * ProductsController
 */
class ProductController extends \Netz\NetzMtmShop\Controller\AbstractController
{

	  /**
     * action fclothing
     *
     * @return void
     */
     public function fclothingAction(){

     	  $product = $this->productRepository->findAll();
     	  $this->view->assign('product', $product);


     }

       /**
     * action detail
     *
     * @return void
     */
     public function detailAction(){
     	 $arrParams = $this->request->getArguments();
       $display_details = false;
       if(count($arrParams)>0 && $arrParams['uid']>0){
         // print_r($arrParams);
           $product_uid = $arrParams['uid'];
           $productdetail = $this->productRepository->findbyuid($product_uid);

           $found_additional = false;
           if(!is_null($productdetail->getAdditional())){
              foreach ($productdetail->getAdditional() as $additional) {
                $found_additional = true;
                break;
              }
           }
           $this->view->assign('found_additional', $found_additional);

           $price = $productdetail->getPrice();
           $dprice = $productdetail->getDprice();
///           

           $size = array();
           $show_size = false;
           $color = array();
           $show_color = false;
           $bedruckung = array();
           $show_bedruckung = false;
           $attr_id = 0;
           $qty = ($arrParams['qty']>1)? $arrParams['qty'] : 1 ;
           $sel_color="";
           $sel_size="";
           $sel_bedruckung = $arrParams['bedruckung'];
           $custom_number = $arrParams['custom_number'];
           $custom_name = $arrParams['custom_name'];

           foreach ($productdetail->getAttributes() as $attr) {
             if(!is_null($attr->getSize())){
               $size[$attr->getSize()->getUid()] = array('title'=>$attr->getSize()->getTitle(),'sort'=>$attr->getSize()->getSorting(),'uid'=>$attr->getSize()->getUid());
             }
             if(!is_null($attr->getColor())){
               $color[$attr->getColor()->getUid()] = array('title'=>$attr->getColor()->getTitle(),'sort'=>$attr->getColor()->getSorting(),'uid'=>$attr->getColor()->getUid());
             }
          }
           $this->array_sort_by_column($size,'sort');
           $this->array_sort_by_column($color,'sort');
          
           
         	 $attr = null;
            
           if($arrParams['method']!=''){
              if($arrParams['size']>0 && $arrParams['method']=='size'){
                  $attr_data =  $this->attributesRepository->getAttribute($product_uid,$arrParams['size']);
                  foreach ($attr_data as $adata) {
                    $attr = $adata;
                    break;
                  }
              }
              if($arrParams['color']>0 && $arrParams['method']=='color'){
                  $attr_data =  $this->attributesRepository->getAttribute($product_uid,0,$arrParams['color']);
                  foreach ($attr_data as $adata) {
                    $attr = $adata;
                    break;
                  }
              }
           }
           else{
              if(count($size)>0){
                $attr_data =  $this->attributesRepository->getAttribute($product_uid,$size[0]['uid'],0);
                foreach ($attr_data as $adata) {
                  $attr = $adata;
                  break;
                }
             } 
             elseif(count($color)>0){
                  $attr_data =  $this->attributesRepository->getAttribute($product_uid,0,$color[0]['uid']);
                  foreach ($attr_data as $adata) {
                    $attr = $adata;
                    break;
                  }
             }
           }
           
           
           if(!is_null($attr)){
              if(!is_null($attr->getSize())){
                 $show_size = true;
                 if(isset($arrParams['size']) && $arrParams['method']=='size'){
                    $sel_size = $arrParams['size'];
                 }
                 else{
                    $sel_size = $attr->getSize()->getUid();
                 }
                 

              }
              if(!is_null($attr->getColor())){
                 $show_color = true;
                 if(isset($arrParams['color']) && $arrParams['method']=='color'){
                    $sel_color = $arrParams['color'];
                 }
                 else{
                  $sel_color = $attr->getColor()->getUid();
                 }

              }
              if(!is_null($attr->getBedruckung())){
                foreach ($attr->getBedruckung() as $bedru) {
                   $bedruckung[$bedru->getUid()] = array('title'=>$bedru->getTitle(),'sort'=>$bedru->getSorting(),'uid'=>$bedru->getUid());
                   $show_bedruckung = true;
                }
                $this->array_sort_by_column($bedruckung,'sort');
              }
              $attr_id = $attr->getUid();
              $price = $attr->getPrice();
              $dprice = $attr->getDprice();

           }
           //echo $sel_color;
           $this->view->assign('productdetail', $productdetail);
           $this->view->assign('show_size', $show_size);
           $this->view->assign('show_color', $show_color);
           $this->view->assign('show_bedruckung', $show_bedruckung);
           $this->view->assign('attr_id', $attr_id);
           $this->view->assign('attr', $attr);
           $this->view->assign('size', $size);
           $this->view->assign('color', $color);
           $this->view->assign('bedruckung', $bedruckung);

           $this->view->assign('price', $price);
           $this->view->assign('dprice', $dprice);

           $this->view->assign('sel_color', $sel_color);
           $this->view->assign('sel_size', $sel_size);
           $this->view->assign('sel_bedruckung', $sel_bedruckung);
           $this->view->assign('custom_name', $custom_name);
           $this->view->assign('custom_number', $custom_number);

           $display_details = true;
           $this->view->assign('qty', $qty);
           $this->view->assign('product_uid', $product_uid);
          
        }
        $this->view->assign('display_details', $display_details);
     }

       /**
     * action gproduct
     *
     * @return void
     */
     public function gproductAction(){

          $gproductid = $this->settings['gproduct'];
          $gproductdetail = $this->groupproductRepository->findbyuid($gproductid);
          $this->view->assign('gproductdetail', $gproductdetail);
     }

       /**
     * action fpieces
     *
     * @return void
     */
     public function fpiecesAction(){

          $fpiecesid = $this->settings['fpieces'];
          $fpieces_arr=explode(",",$fpiecesid);
          foreach ($fpieces_arr as $key => $value) {
          $fpiecesdetail[] = $this->productRepository->findbyuid($value);
          }
          $this->view->assign('fpiecesdetail', $fpiecesdetail);

     }

     /**
     * action addcart
     *
     * @return void
     */
    public function addcartAction()
    {
        $arrParams = $this->request->getArguments();
        $uid = $arrParams['uid'];
        $attr_id = $arrParams['attr_id'];

        $cart_data = $GLOBALS['TSFE']->fe_user->getKey('ses', 'cart_data');
       
        if(!is_array($cart_data)){
          $cart_data = array();
        }
        $found_in_cart = false;
        foreach ($cart_data as $key => $value) {
          if($value['uid'] == $uid && $value['attr_id'] == $attr_id){
              if(array_key_exists('bedruckung', $value) && array_key_exists('bedruckung', $arrParams)){
                if($value['attr_id'] == $arrParams['attr_id'] && $value['custom_name']==$arrParams['custom_name'] && $value['custom_number']==$arrParams['custom_number']){
                    $cart_data[$key]['qty']= $cart_data[$key]['qty'] + $arrParams['qty']; 
                    $found_in_cart = true;
                }
              }
              else{
                  $cart_data[$key]['qty']= $cart_data[$key]['qty'] + $arrParams['qty']; 
                  $found_in_cart = true;
              }
          }
        }
        if(!$found_in_cart){
          $cart = array();
          $cart['uid'] = $arrParams['uid'];
          $product  = $this->productRepository->findByUid($arrParams['uid']);
          $cart['name'] = $product->getTitle();
          $cart['attr_id'] = $arrParams['attr_id'];
          $cart['qty'] = $arrParams['qty'];
          if($arrParams['bedruckung']!=''){
              $cart['bedruckung'] = $arrParams['bedruckung'];
          }
          if($arrParams['custom_name']!=''){
              $cart['custom_name'] = $arrParams['custom_name'];
          }
          if($arrParams['custom_number']!=''){
              $cart['custom_number'] = $arrParams['custom_number'];
          }
          $cart_data[] = $cart;
        }
       
        $GLOBALS['TSFE']->fe_user->setKey('ses', 'cart_data', $cart_data);
        $GLOBALS['TSFE']->fe_user->storeSessionData();
        echo json_encode(array('status'=>1));
        die();
    }

    /**
     * action fcart
     *
     * @return void
     */
    public function fcartAction()
    {
        $cart_data = $GLOBALS['TSFE']->fe_user->getKey('ses', 'cart_data');
        $cart_qty  = 0;
        if(!is_null($cart_data) && is_array($cart_data)){
            $cart_qty  = count($cart_data);
        }
        $carts = $this->cartData();
        $this->view->assign('carts', $carts['carts']);
        $this->view->assign('cart_total_price', $carts['cart_total_price']);
        $this->view->assign('shipping_cost', $carts['shipping_cost']);
        $this->view->assign('vat_percentage', $carts['vat_percentage']);
        $this->view->assign('rebate', $carts['rebate']);
        $this->view->assign('grand_total', $carts['grand_total']);
        $this->view->assign('vat_price', $carts['vat_price']);
        $this->view->assign('cart_rebate',$carts['cart_rebate']);
        $output = $this->view->render();  
        echo json_encode(array('status'=>1,'html'=>$output,'cart_qty'=>$cart_qty));
        die();
    }

    protected function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
            $sort_col = array();
            foreach ($arr as $key=> $row) {
                $sort_col[$key] = $row[$col];
            }
            array_multisort($sort_col, $dir, $arr);
    }  
     
}

?>
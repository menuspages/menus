<?php
namespace App\Constants;
class Translation
{
  public  $language = array();
  
   public static function  populateTransaltion()
  {
    return $language = array(
      "eng" => array(
          "add_to_cart" => "Add to Cart",
          "item_added_to_cart" => "items Added to Cart",
          "remove_from_cart" => "Remove from Cart",
          "complete_the_order"=>"Complete the order",
          "contact_us" => "Conctact Us",
          "delete" => "Delete",
          "links" => "Links" ,
          "add_feature" => "Add Feature",
          "date" => "Date",
          "note" => "Note",
          "allergens" => "Allergens",
          "cart_options" => "Cart Options"
          
          
      ),
      "arb" => array(
          "add_to_cart" => "اضف الى السلة",
          "item_added_to_cart" => "عنصر مضاف الى العربة",
          "remove_from_cart" => "احذف",
          "complete_the_order"=>"اتمام الطلب",
          "contact_us" => "تواصل معنا",
          "delete" => "حذف",
          "add_feature" => "إضافة ميزة
          ",
          "date" => "تاريخ",
          "note" => "ملحوظة ",
          "allergens" => "مسببات الحساسية",
          "links" => "الروابط",
          "cart_options" => "خيارات عربة التسوق
          "
          )
      );
  }  
  public static function getTranslation()
  {
    return self::populateTransaltion();
  }
  public static function getTranslationByWord($lang , $word)
  {
      return self::populateTransaltion()[$lang][$word];
  }  
}

?>
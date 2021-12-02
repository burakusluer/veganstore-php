<?php
/**
 * Created by PhpStorm.
 * User: Burak
 * Date: 28.11.2021
 * Time: 18:07
 */

include_once "classes/vegan.php";
$veganAPI=new vegan("mail@domain.com","lorem ipsum dolor sit amet");
//yukarıdaki initialize işlemine mağaza mail ve şifrenizi giriniz ağağıdaki fonsiyon boş bir sayfaya mağazanızdaki ürünlerinizi
//basacaktır
$jsonObj=$veganAPI->products();
echo "<pre>";
print_r($jsonObj);
echo "</pre>";


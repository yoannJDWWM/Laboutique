<?php

namespace App\Classes;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class Cart
{
    private $requestStack;
    private $entityManager;

  public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack){
    $this->requestStack = $requestStack;
    $this->entityManager = $entityManager;
    } 

    public function add($id){

       $cart = $this->requestStack->getSession()->get('cart', []);
        if(!empty($cart[$id])){

            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }


        $this->requestStack->getSession()->set('cart',$cart);
    }

    public function get(){
        return $this->requestStack->getSession()->get('cart');
    }

    public function remove(){
        return $this->requestStack->getSession()->remove('cart');
    }

    public function deleteOneItem($id){

        $cart = $this->requestStack->getSession()->get('cart', []);
        
        unset($cart[$id]);
        $this->requestStack->getSession()->set('cart',$cart);

    }

    public function decrease($id){

        $cart = $this->requestStack->getSession()->get('cart', []);
       
        if($cart[$id] > 1){
            $cart[$id]--;
        } else{
            unset($cart[$id]);
        }

        $this->requestStack->getSession()->set('cart',$cart);

}

function getFull(){
    $fullCart = [];
    if( $this->get()){
    foreach ($this->get() as $id => $quantity) {
        $product_object = $this->entityManager->getRepository(Product::class)->findOneById($id);
    if (!$product_object){
        $this->deleteOneItem($id);
        continue;
    }

     $fullCart[] = [
         'product' => $product_object,
         'quantity' => $quantity
     ];
 }
    

}
return $fullCart;
}
}
<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{

    private $entityManager;

    public function __construct( EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
 
  

    #[Route('/mon-panier', name: 'cart')]
    public function index(Cart $cart): Response
    {
      
        return $this->render('cart/index.html.twig',[
            'cart' => $cart->getFull(),
        ]);
    }


    #[Route('/cart/add/{id}', name:'add_to_cart')]
    public function add($id, Cart $cart): Response
    {
        
        $cart->add($id);
        return $this->redirectToRoute('cart');
        
    }

    #[Route('/cart/remove', name:'remove_my_cart')]
    public function remove(Cart $cart): Response
    {
        
        $cart->remove();
        return $this->redirectToRoute('products');
    }

    #[Route('/cart/delete/{id}', name:'remove_my_item')]
    public function delete( $id,Cart $cart): Response
    {
       
         $cart->deleteOneItem($id);
        

        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/decrease/{id}', name:'decrease_my_item')]
    public function decrease( $id,Cart $cart): Response
    {
       
         $cart->decrease($id);
        

        return $this->redirectToRoute('cart');
    }





}

<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Classes\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderValidateController extends AbstractController
{

    private $entityManager;

    public function __construct( EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }


    #[Route('/commande/merci/{stripeSessionId}', name: 'order_validate')]
    public function index($stripeSessionId, Cart $cart): Response
    {

        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        
        
        if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        if($order->getState() == 0){

            $order->setState(1);

            $cart->remove();

            $this->entityManager->flush();

            $mail = new Mail();
            $content ="Bonjour".$order->getUser()->getFirstname()."<br/>Merci pour votre commande";
            $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande est bien validée', $content);
            

        }

        return $this->render('order_validate/index.html.twig',[
        'order' => $order
    ]);
    }
}

<?php

namespace App\Controller;
use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="Login")
     */
    public function login(): Response
    {
        return $this->render('FrontOffice/login.html.twig', [
            'controller_name' => 'NavigationFrontOfficeController',
        ]);
    }

    /**
     * @Route("/loginCheck", name="loginCheck", methods={"GET", "POST"})
     */
    public function loginCheck(Request $request,UserPasswordEncoderInterface $encoder,SerializerInterface $serializer,JWTTokenManagerInterface $JWTManager): Response
    {
        $userMail=$request->get('userMail');
        $userPasswd=$request->get('userPasswd');
        $user=$this->getDoctrine()->getRepository(User::class)->findOneBy(["email"=>$userMail]);
        $response=New Response();
        if($user!=null){
            $hash=$encoder->isPasswordValid($user,$userPasswd);
            if($hash){

                $response=new JsonResponse(['token' => $JWTManager->create($user)]);

                //$JWTManager->create($user)
                //$response->setContent(getTokenUser($user)) ;
            }
            else{
                $response->setContent(json_encode(['Error'=>'Wrong Password']));
            }
        }
        else{
            $response->setContent(json_encode(['Error'=>'User Not Found']));
        }


        return $response;
    }



}

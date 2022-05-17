<?php

namespace App\Controller;
use App\Entity\User;
use App\Services\SessionManagmentService;
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

    private SessionManagmentService $currentSession;
    public function __construct(SessionManagmentService $session)
    {
        $this->currentSession=$session;
    }

    public function getCin():Response{
        $cin=$this->currentSession->getUser()->getCinuser();
        return new Response(strval($cin));
    }

    public function getCurrentUserRole():Response{
        $role=$this->currentSession->getUser()->getRole();
        return new Response(strval($role));
    }

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
    public function loginCheck(Request $request,UserPasswordEncoderInterface $encoder,SessionManagmentService $sessionManagmentService): Response
    {
        $userMail=$request->get('userMail');
        $userPasswd=$request->get('userPasswd');
        $user=$this->getDoctrine()->getRepository(User::class)->findOneBy(["email"=>$userMail]);
        $response=New Response();
        if($user!=null){
            $hash=$encoder->isPasswordValid($user,$userPasswd);
            if($hash){
                //login
                if($user->getState() == 'Deleted'){
                    return $this->redirectToRoute('loginFailed', ['error'=>'Account Deleted']);
                }
                else {
                    $sessionManagmentService->createSession($user);
                    if ($user->getRole() == 'Admin')
                        return $this->redirectToRoute('app_dashboard_back_office', []);
                    return $this->redirectToRoute('profile', ['userCin' => $user->getCinuser()]);
                }
            }
            else{
                //error wrong password
                //$response->setContent(json_encode(['Error'=>'Wrong Password']));
                return $this->redirectToRoute('loginFailed', ['error'=>'Wrong Password']);
            }
        }
        else{
            //error user not found
            //$response->setContent(json_encode(['Error'=>'User Not Found']))
            return $this->redirectToRoute('loginFailed', ['error'=>'User Not Found']);
        }


    }

    /**
     * @Route("/loginFailed?{error}", name="loginFailed", methods={"GET", "POST"})
     */
    public function loginfailed($error)
    {
        return $this->render('FrontOffice/login.html.twig', [
            'controller_name' => 'NavigationFrontOfficeController',
            'error'=>$error
        ]);
    }

    /**
     * @Route("/api/loginCheck", name="loginCheckapi", methods={"GET", "POST"})
     */
    public function loginCheckApi(Request $request,UserPasswordEncoderInterface $encoder,SerializerInterface $serializer,JWTTokenManagerInterface $JWTManager): Response
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

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(SessionManagmentService $sessionManagmentService): Response
    {   $sessionManagmentService->deleteCurrentSession();
        return $this->redirectToRoute('Login', []);
    }

    /**
     * @Route("/error", name="error")
     */
    public function error(): Response
    {
        return $this->render('errorPlaceHolder.html.twig', [
            'controller_name' => 'NavigationFrontOfficeController'
        ]);
    }

}

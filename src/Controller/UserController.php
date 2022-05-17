<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\ParticipateRepository;
use App\Repository\ReactedRepository;
use App\Repository\UserRepository;
use App\Services\SessionManagmentService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Dompdf\Exception;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Date;


class UserController extends AbstractController
{

    //<editor-fold desc="Web">

    /**
     * @Route("/", name="app_user_index", methods={"GET"})
     */
    public function index(SessionManagmentService $sessionManagmentService): Response
    {
        if ($sessionManagmentService->verifySessionOpened()) {

            return $this->redirectToRoute('profile', ['userCin' => $sessionManagmentService->getUser()->getCinuser()]);
        } else
            return $this->redirectToRoute('Login', []);
    }

    /**
     * @Route("/createStudentAccount", name="create_student_Account",methods={"GET", "POST"})
     */
    public function StudentRegister(Request $request, UserPasswordEncoderInterface $encoder, SessionManagmentService $sessionManagmentService): Response
    {
        dump($request);
        if ($request->request->count() > 0) {
            $user = new User();
            $user->setCinuser($request->get('userCin'));
            $passwd = $request->get('password');
            $hash = $encoder->encodePassword($user, $passwd);
            echo $hash . " " . $request->get('password');
            $user->setPasswd($hash);
            $user->setEmail($request->get('email'));
            $user->setRole('Student');
            $user->setFirstname($request->get('firstName'));
            $user->setLastname($request->get('lastName'));
            $class = $request->get('grade') . " " . $request->get('classSpec') . " " . $request->get('classNum');
            $user->setClass($class);
            $user->setDomaine($request->get('specStudent'));
            $user->setCreatedat(new \DateTime('@' . strtotime('now')));
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            $sessionManagmentService->createSession($user);

            return $this->redirectToRoute('profile', ['userCin' => $user->getCinuser()]);
        }


        return $this->render('FrontOffice/register.html.twig', [
        ]);
    }

    /**
     * @Route("/createProfAccount", name="create_prof_Account",methods={"GET", "POST"})
     */
    public function profRegister(Request $request, UserPasswordEncoderInterface $encoder, SessionManagmentService $sessionManagmentService): Response//typeClub
    {
        dump($request);
        if ($request->request->count() > 0) {
            $user = new User();
            echo (int)$request->get('userCin');
            echo $request->get('userCin');
            $user->setCinuser($request->get('userCin'));
            $passwd = $request->get('password');
            $hash = $encoder->encodePassword($user, $passwd);
            $user->setPasswd($hash);
            $user->setEmail($request->get('email'));
            $user->setRole('Professor');
            $user->setFirstname($request->get('firstName'));
            $user->setLastname($request->get('lastName'));
            $user->setDomaine($request->get('specProf'));
            $user->setCreatedat(new \DateTime('@' . strtotime('now')));
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            $sessionManagmentService->createSession($user);

            return $this->redirectToRoute('profile', ['userCin' => $user->getCinuser()]);
        }


        return $this->render('FrontOffice/register.html.twig', [
        ]);
    }

    /**
     * @Route("/createClubAccount", name="create_club_Account",methods={"GET", "POST"})
     */
    public function clubRegister(Request $request, UserPasswordEncoderInterface $encoder, SessionManagmentService $sessionManagmentService): Response
    {
        dump($request);
        if ($request->request->count() > 0) {
            $user = new User();
            echo (int)$request->get('userCin');
            echo $request->get('userCin');
            $user->setCinuser($request->get('userCin'));
            $passwd = $request->get('password');
            $hash = $encoder->encodePassword($user, $passwd);
            $user->setPasswd($hash);
            $user->setEmail($request->get('email'));
            $user->setRole('Club');
            $user->setFirstname($request->get('firstName'));
            $user->setLastname($request->get('lastName'));
            $user->setTypeclub($request->get('typeClub'));
            $user->setCreatedat(new \DateTime('@' . strtotime('now')));
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            $sessionManagmentService->createSession($user);
            return $this->redirectToRoute('profile', ['userCin' => $user->getCinuser()]);
        }


        return $this->render('FrontOffice/register.html.twig', [
        ]);
    }

    /**
     * @Route("/addExtern", name="add_new_Extern_Account", methods={"GET", "POST"})
     */
    public function addExtern(Request $request, UserPasswordEncoderInterface $encoder, MailController $mail): Response
    {
        dump($request);
        if ($request->request->count() > 0) {
            $user = new User();
            echo (int)$request->get('compId');
            echo $request->get('compId');
            $user->setCinuser($request->get('compId'));
            $passwd = $request->get('password');
            $user->setEmail($request->get('compEmail'));
            $mail->sendMailToExtern($user->getEmail(), $user->getEntreprisename(), $passwd);
            $hash = $encoder->encodePassword($user, $passwd);
            $user->setPasswd($hash);
            $user->setRole('Extern');
            $user->setEntreprisename($request->get('CompName'));
            $user->setLocalisation($request->get('local'));
            $user->setCreatedat(new \DateTime('@' . strtotime('now')));

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('UserDashboard', []);
        }
        return $this->render('BackOffice/AddNewAnnounce.html.twig', [
        ]);
    }

    /**
     * @Route("/profile/{userCin}", name="profile", methods={"GET"})
     */
    public function profile($userCin, SessionManagmentService $sessionManagmentService, UserRepository $userRepository): Response
    {
        if ($sessionManagmentService->verifySessionOpened()) {
            //$user = $this->getDoctrine()->getRepository(User::class)->find($userCin);
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(["cinuser" => $userCin]);
            dump($user);
            $imgPath = 'images/users/' . $user->getImgurl();
            if ($user->getRole() == 'Admin')
                $list = $userRepository->getAdminAnnounces($userCin);
            elseif ($user->getRole() == 'Club')
                $list = $userRepository->getUserEvent($userCin);
            elseif ($user->getRole() == 'Extern')
                $list = $userRepository->getUserOffer($userCin);
            elseif ($user->getRole() == 'Professeur')
                $list = $userRepository->getUserAlert($userCin);
            else
                $list = $userRepository->getUserPost($userCin);
            return $this->render('FrontOffice/navbar-v2-profile-main.html.twig', [
                'user' => $user,
                'image' => $imgPath,
                'posts' => $list
            ]);
        } else
            return $this->redirectToRoute('error', []);

    }

    /**
     * @Route("/{cinuser}", name="app_user_show", methods={"GET"})
     */
    /*public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }*/

    /**
     * @Route("/{cinuser}/edit", name="app_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("UserDashboard/{cinuser}", name="app_user_delete")
     */
    public function delete($cinuser)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($cinuser);
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('UserDashboard');
    }

    /**
     * @Route ("/UserDashboard",name="UserDashboard")
     */
    public function getUsers(SessionManagmentService $s, EntityManagerInterface $em): Response
    {
        /*$users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();*/
        $users = $em->createQueryBuilder()
            ->select('u')
            ->from('App\Entity\User', 'u')
            ->where('u.state!=\'Deleted\'')
            ->getQuery()
            ->getArrayResult();

        return $this->render('BackOffice/UserDashboard.html.twig', ['users' => $users]);
    }

    /**
     * @Route ("/getUsers",name="get-Users-api")
     */
    public function getUsersApi(SerializerInterface $serializer): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        //dump($users);

        $json = $serializer->serialize($users, 'json', ['groups' => 'users']);
        $Response = new Response($json);

        return $Response;
    }

    /**
     * @Route("/TrierParDateAsc", name="TrierParDateAsc")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function TrierParDateAsc(UserRepository $userRepository)
    {
        $users = $userRepository->sortByDateAsc();
        dump($users);
        return $this->render('BackOffice/UserDashboard.html.twig', ['users' => $users]);
        //return $this->redirectToRoute('UserDashboard', ['users' => $users]);
    }

    /**
     * @Route("/TrierParDateDesc", name="TrierParDateDesc")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function TrierParDateDesc(UserRepository $userRepository)
    {
        $users = $userRepository->sortByDateDesc();
        dump($users);
        return $this->render('BackOffice/UserDashboard.html.twig', ['users' => $users]);
        //return $this->redirectToRoute('UserDashboard', ['users' => $users]);
    }

    /**
     * @Route("/UserDashboardAdmin", name="showAdmins")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function showAdmins(UserRepository $userRepository)
    {
        $users = $userRepository->showAdmins();
        dump($users);
        return $this->render('BackOffice/UserDashboard.html.twig', ['users' => $users]);
        //return $this->redirectToRoute('UserDashboard', ['users' => $users]);
    }

    /**
     * @Route("/UserDashboardStudents", name="showStudents")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function showStudents(UserRepository $userRepository)
    {
        $users = $userRepository->showStudents();
        dump($users);
        return $this->render('BackOffice/UserDashboard.html.twig', ['users' => $users]);
        //return $this->redirectToRoute('UserDashboard', ['users' => $users]);
    }

    /**
     * @Route("/UserDashboardClubs", name="showClubs")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function showClubs(UserRepository $userRepository)
    {
        $users = $userRepository->showClubs();
        dump($users);
        return $this->render('BackOffice/UserDashboard.html.twig', ['users' => $users]);
        //return $this->redirectToRoute('UserDashboard', ['users' => $users]);
    }

    /**
     * @Route("/UserDashboardProfs", name="showProfs")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function showProfs(UserRepository $userRepository)
    {
        $users = $userRepository->showProfs();
        dump($users);
        return $this->render('BackOffice/UserDashboard.html.twig', ['users' => $users]);
        //return $this->redirectToRoute('UserDashboard', ['users' => $users]);
    }

    /**
     * @Route("/UserDashboardOthers", name="showExterns")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function showExterns(UserRepository $userRepository)
    {
        $users = $userRepository->showExterns();
        dump($users);
        return $this->render('BackOffice/UserDashboard.html.twig', ['users' => $users]);
        //return $this->redirectToRoute('UserDashboard', ['users' => $users]);
    }

    /**
     * @Route("/test", name="test",methods={"GET", "POST"})
     */
    public function testQuery(SessionManagmentService $sessionManagmentService, EntityManagerInterface $entityManager)
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(["email" => 'bairem.khedhri@esprit.tn']);
        $sessionManagmentService->createSession($user);
        $session = $this->get('session');
        dump($session);
        die;
    }

    /**
     * @Route("/test2", name="test2")
     */
    public function test2Query(SessionManagmentService $sessionManagmentService, UserRepository $userRepository)
    {
        dump($userRepository->getStatistics());
        $stats = $userRepository->getStatistics();
        echo $stats[0] >
            //$sessionManagmentService->verifySessionOpened();
            dump($sessionManagmentService->getUser());
        dump($sessionManagmentService->getData());
        die;
    }

    /**
     * @Route("/test3", name="test3")
     */
    public function test3Query(SessionManagmentService $sessionManagmentService, EntityManagerInterface $em)
    {

        $sessionManagmentService->deleteCurrentSession();
        $session = $this->get('session');
        dump($session);
        die;
    }

    /**
     * @Route("/test4", name="test4")
     */
    public function test4Query(ReactedRepository $parRepository, SessionManagmentService $sessionManagmentService, $id, EntityManagerInterface $em): Response
    {
        $list = $em->createQueryBuilder()
            ->select('r')
            ->from('App\Entity\Responded', 'r')
            ->innerJoin('App\Entity\Forum', 'f', 'with', "r.cinuser = f.idower")
            ->getQuery()
            ->getArrayResult();
        dump($list);

        $currentUser = $sessionManagmentService->getUser();

        die;
    }

//</editor-fold>

//<editor-fold desc="API">

    /* *************** API ********************** */


    /**
     * @Route("/api/createNewAccount", name="create_new_AccountAPI",methods={"GET", "POST"})
     */
    public function createNewAccountAPI(Request $request, UserPasswordEncoderInterface $encoder, SerializerInterface $serializer): Response
    {
        try {

            $content = $request->getContent();
            //$user = $serializer->deserialize($content, User::class, 'json');
            $user = new User();
            $user->setCinuser($request->get('cinuser'));
            $user->setEmail($request->get('email'));
            $user->setPasswd($request->get('password'));
            $user->setFirstname($request->get('firstname'));
            $user->setLastname($request->get('lastname'));
            $user->setRole($request->get('role'));
            $user->setClass($request->get('classe'));
            $user->setDepartement($request->get('departement'));
            $user->setTypeclub($request->get('typeclub'));
            $user->setLocalisation($request->get('localisation'));
            $user->setDomaine($request->get('domaine'));
            $user->setCreatedat(new \DateTime('@' . strtotime('now')));
            $user->setPasswd($encoder->encodePassword($user, $user->getPasswd()));
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            return new Response('Added to DataBase', 200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }

    }

    /**
     * @Route("/api/getStudents", name="getStudents",methods={"GET"})
     */
    public function getStudentsAPI(Request $request, UserPasswordEncoderInterface $encoder, SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        try {
            $students = $em->createQueryBuilder()->select('u')
                ->from('App\Entity\User', 'u')
                ->getQuery()
                ->getArrayResult();
            $json = $serializer->serialize($students, 'json');
            return new Response($json, 200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }

    }

    /**
     * @Route("/api/findUser/{email}", name="findUser",methods={"GET"})
     */
    public function findUserAPI($email, Request $request, UserPasswordEncoderInterface $encoder, SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        try {
            $students = $em->createQueryBuilder()->select('u')
                ->from('App\Entity\User', 'u')
                ->where('u.email=:email')
                ->setParameter('email', $email)
                ->getQuery()
                ->getArrayResult()[0];
            if ($students["state"] == "Deleted") {
                return new Response("User Deleted", 403);
            }
            dump($students);
            $json = $serializer->serialize($students, 'json');
            return new Response($json, 200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }

    }

//</editor-fold>

}



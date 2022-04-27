<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Date;


class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_user_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager
            ->getRepository(User::class)
            ->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/createStudentAccount", name="create_student_Account",methods={"GET", "POST"})
     */
    public function StudentRegister(Request $request, UserPasswordEncoderInterface $encoder): Response
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
            $user->setRole('Etudiant');
            $user->setFirstname($request->get('firstName'));
            $user->setLastname($request->get('lastName'));
            $class = $request->get('grade') . " " . $request->get('classSpec') . " " . $request->get('classNum');
            $user->setClass($class);
            $user->setDomaine($request->get('specStudent'));
            $user->setCreatedat(new \DateTime('@' . strtotime('now')));
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('profile', ['userCin' => $user->getCinuser()]);
        }


        return $this->render('FrontOffice/register.html.twig', [
        ]);
    }

    /**
     * @Route("/createProfAccount", name="create_prof_Account",methods={"GET", "POST"})
     */
    public function profRegister(Request $request, UserPasswordEncoderInterface $encoder): Response//typeClub
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

            return $this->redirectToRoute('profile', ['userCin' => $user->getCinuser()]);
        }


        return $this->render('FrontOffice/register.html.twig', [
        ]);
    }

    /**
     * @Route("/createClubAccount", name="create_club_Account",methods={"GET", "POST"})
     */
    public function clubRegister(Request $request, UserPasswordEncoderInterface $encoder): Response
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

            return $this->redirectToRoute('profile', ['userCin' => $user->getCinuser()]);
        }


        return $this->render('FrontOffice/register.html.twig', [
        ]);
    }

    /**
     * @Route("/addExtern", name="add_new_Extern_Account", methods={"GET", "POST"})
     */
    public function addExtern(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        dump($request);
        if ($request->request->count() > 0) {
            $user = new User();
            echo (int)$request->get('compId');
            echo $request->get('compId');
            $user->setCinuser($request->get('compId'));
            $passwd = $request->get('password');
            $hash = $encoder->encodePassword($user, $passwd);
            $user->setPasswd($hash);
            $user->setEmail($request->get('compEmail'));
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
    public function profile($userCin): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($userCin);
        echo $user->getCinuser() . $user->getFirstname();
        $imgPath = 'images/users/' . $user->getImgurl();
        return $this->render('FrontOffice/navbar-v2-profile-main.html.twig', [
            'user' => $user,
            'image' => $imgPath
        ]);
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
     * @Route("/{cinuser}", name="app_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getCinuser(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route ("/UserDashboard",name="UserDashboard")
     */
    public function getUsers(): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
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
     * @Route("/UserDashboard/Admin", name="showAdmins")
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
}



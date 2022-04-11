<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route("/user")
 */
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
     * @Route("/new", name="app_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/createStudentAccount", name="create_student_Account",methods={"GET", "POST"})
     */
    public function StudentRegister(Request $request): Response
    {
        dump($request);
        if ($request->request->count() > 0) {
            $user = new User();
            echo (int)$request->get('userCin');
            echo $request->get('userCin');
            $user->setCinuser($request->get('userCin'));
            $user->setPasswd($request->get('password'));
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

            return $this->redirectToRoute('profile',['userCin'=>$user->getCinuser()]);
        }


        return $this->render('FrontOffice/register.html.twig', [
        ]);
    }

    /**
     * @Route("/profile/{userCin}", name="profile", methods={"GET"})
     */
    public function profile(User $user): Response
    {
        echo "salem";
        return $this->render('FrontOffice/navbar-v2-profile-main.html.twig', [
            'user'=>$user
        ]);
    }

    /**
     * @Route("/{cinuser}", name="app_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

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
}

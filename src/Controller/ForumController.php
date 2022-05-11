<?php

namespace App\Controller;


use App\Entity\Event;
use App\Entity\Forum;
use App\Entity\Responded;
use App\Entity\User;
use App\Form\ForumType;
use App\Repository\ForumRepository;
use App\Services\SessionManagmentService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ForumController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @Route ("/ForumDashboard",name="ForumDashboard")
     */
    public function getForums(): Response
    {
        $forums= $this->getDoctrine()
            ->getRepository(Forum::class)
            ->findAll();
        return $this->render('BackOffice/ForumDashboard.html.twig',['forums'=>$forums]);
    }

    /**
     * @Route("/forumFront", name="forumFront" , methods={"GET", "POST"})
     */
    public function getlistforums(Request $request ,PaginatorInterface $paginator): Response
    {
        dump($request);
        $title = $request->get('search');
        $tag = $request->get('tag');
        $data = [];
        if($title != "" || $tag!="") {
            $data = $this->getDoctrine()
                ->getRepository(Forum::class)
                ->findBytitle($title,$tag);
        } else {
            $data= $this->getDoctrine()
                ->getRepository(Forum::class)
                ->findAll();
        }

        $responded= $this->getDoctrine()
            ->getRepository(Responded::class)
            ->findAll();

        $forums= $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            4
        );

        return $this->render('FrontOffice/forumFront.html.twig',['forums'=>$forums,'responses'=>$responded]);
    }

    /**
     * @Route("/addresponse/{idforum}", name="createresponse",methods={"GET", "POST"})
     */
    public function addresponse(Request $request, $idforum,SessionManagmentService $sessionManagmentService): Response
    {
        dump($request);
        $response = new Responded();
        $currentUser=$sessionManagmentService->getUser();
        $forum = $this->getDoctrine()->getRepository(Forum::class)->find($idforum);
        $user = $this->getDoctrine()->getRepository(User::class)->find($currentUser->getCinuser());
        $response->setContent($request->get('responsecontent'));
        $response->setIdforum($forum);
        $response->setCinuser($user);
        $response->setCreatedat(new \DateTime('@' . strtotime('now')));
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($response);
        $manager->flush();

        return $this->redirectToRoute('forumFront');
    }

    /**
     * @Route("/addforum", name="addforum",methods={"GET", "POST"})
     */
    public function addforum(Request $request,SessionManagmentService $sessionManagmentService): Response
    {
        dump($request);
        $forum = new Forum();
        $currentUser=$sessionManagmentService->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($currentUser->getCinuser());
        $forum->setTitle($request->get('title'));
        $forum->setContent($request->get('content'));
        $forum->setCategorieforum($request->get('tag'));
        $forum->setIdowner($user);
        $forum->setNbrlikesforum(0);
        $forum->setNbrresponseforum(0);
        $forum->setDatecreation(new \DateTime('@' . strtotime('now')));
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($forum);
        $manager->flush();


        return $this->redirectToRoute('forumFront');
    }

    /**
     * @Route ("/deleteforum/{id}",name="deleteforum")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $offer = $this->getDoctrine()
            ->getRepository(Forum::class)
            ->find($id);
        $offer->setState("Desactive");
        $em->flush();
        return $this->redirectToRoute('ForumDashboard');
    }

    /**
     * @Route ("/forumtdelete/{id}",name="deleteforumfront")
     */
    public function deletefront($id)
    {
        $em=$this->getDoctrine()->getManager();
        $offer = $this->getDoctrine()
            ->getRepository(Forum::class)
            ->find($id);
        $offer->setState("Desactive");
        $em->flush();
        return $this->redirectToRoute('forumFront');
    }

    /**
     * @Route("/editForum/{id}", name="edit-forum")
     */
    public function updateClassroom( Request $request,ForumRepository $repository,$id)
    {
        $forum= $repository->find($id);
        //   $classroom=  $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $form= $this->createForm(ForumType::class,$forum);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("forumFront");
        }
        return $this->render("FrontOffice/edit-forum.html.twig",array("forum"=>$forum,"formForum"=>$form->createView()));
    }

    /**
     * @Route("/forum", name="app_forum")
     */
    public function index(): Response
    {
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }

    /**
     * @Route ("api/getforums",name="getforumsApi")
     */
    public function getforumsApi(SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $forums = $em->createQueryBuilder()
            ->select('f.idforum,f.datecreation,f.title,f.content,f.categorieforum,f.nbrlikesforum,f.nbrresponseforum,u.cinuser AS idOwner')
            ->from('App\Entity\Forum', 'f')
            ->innerJoin('App\Entity\User', 'u', 'with', "u.cinuser = f.idowner")
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($forums, 'json', ['groups' => 'forums']);
        $Response = new Response($json);
        return $Response;

    }

    /**
     * @Route ("api/getforum/{id}",name="getforumsbyIdApi")
     */
    public function getForumByIdApi($id,SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $forums = $em->createQueryBuilder()
            ->select('f.idforum,f.datecreation,f.title,f.content,f.categorieforum,f.nbrlikesforum,f.nbrresponseforum,u.cinuser AS idOwner')
            ->from('App\Entity\Forum', 'f')
            ->innerJoin('App\Entity\User', 'u', 'with', "u.cinuser = f.idowner")
            ->where('f.idforum=:id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($forums, 'json', ['groups' => 'forums']);
        $Response = new Response($json);
        return $Response;

    }

    /**
     * @Route("/api/addforum", name="addForumApi")
     */
    public function addForumApi(Request $request, SerializerInterface $serializer)
    {
        try {
            $event = new Event();
            $json=$request->getContent();
            $content=json_decode($json,true);
            $user = $this->getDoctrine()->getRepository(User::class)->find($content['idOwner']);
            $forum=new Forum();
            $date = new \DateTime('@' . strtotime('now'));
            $forum->setDatecreation($date);
            $forum->setTitle($content['title']);
            $forum->setContent($content['content']);
            $forum->setCategorieforum($content['categorieforum']);
            $forum->setIdowner($user);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($forum);
            $manager->flush();
            return new Response('Added to DataBase',200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }


    }
    /**
     * @Route("/likesl", name="likesl")
     */
    public function getLikesList():Response{
        /*$likes=$this->entityManager->createQueryBuilder()
            ->select('u.imgurl')
            ->from('App\Entity\Forum', 'f')
            ->innerJoin('App\Entity\User', 'u', 'with', "u.cinuser = e.idorganizer")
            ->innerJoin('App\Entity\User', 'u', 'with', "u.cinuser = e.idorganizer")
            ->where('f.idforum=:id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getArrayResult();*/
        /*return $this->render('FrontOffice/cells/ForumLikes.html.twig', [

        ]);*/
        $likes=$this->getDoctrine()->getRepository(Forum::class)->findAll();
        dump($likes);
        die;
    }
}

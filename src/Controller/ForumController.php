<?php

namespace App\Controller;


use App\Entity\Commented;
use App\Entity\Event;
use App\Entity\Forum;
use App\Entity\Like;
use App\Entity\Post;
use App\Entity\ReactedForum;
use App\Entity\Responded;
use App\Entity\User;
use App\Form\ForumType;
use App\Repository\ForumRepository;
use App\Repository\PostRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use App\Services\SessionManagmentService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Persistence\ManagerRegistry;;

class ForumController extends AbstractController
{
    public function indexAction()
    {

        $forms = $this->getDoctrine()->getRepository(Forum::class)->findByState('Active');
        //$cmts = $this->getDoctrine()->getRepository(R::class)->findAll();
        //$likes = $this->getDoctrine()->getRepository(Like::class)->findAll();
    }
    /**
     * @Route ("/ForumDashboard",name="ForumDashboard")
     */
    public function getForums(): Response
    {
        $forums= $this->getDoctrine()
            ->getRepository(Forum::class)
            ->findByState('Active');
        return $this->render('BackOffice/ForumDashboard.html.twig',['forums'=>$forums,"piechart"=>$this->indexAction()]);
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
        $users=$this->getDoctrine()->getRepository(User::class)->findAll();
        dump($likes);
        dump($users);
        die;
    }

    /**
     * @Route("/TrierParDateAscForum", name="TrierParDateAscForum")
     * @param ForumRepository $forumRepository
     * @return Response
     */
    public function TrierParDateAsc(ForumRepository $forumRepository)
    {
        $forums = $forumRepository->sortByDateAsc('Active');
        dump($forums);
        return $this->render('BackOffice/ForumDashboard.html.twig', ['forums' => $forums]);
    }

    /**
     * @Route("/TrierParDateDescForum", name="TrierParDateDescForum")
     * @param ForumRepository $forumRepository
     * @return Response
     */
    public function TrierParDateDesc(ForumRepository $forumRepository)
    {
        $forums = $forumRepository->sortByDateDesc('Active');
        dump($forums);
        return $this->render('BackOffice/ForumDashboard.html.twig', ['forums' => $forums]);
        //return $this->redirectToRoute('UserDashboard', ['users' => $users]);
    }

/**
* @Route("/reactforum/{id}", name="reacted-forum")
*/
    public function react($id,SessionManagmentService $sessionManagmentService): Response
    {
        $currentUser=$sessionManagmentService->getUser();
        $like = new ReactedForum();
        $user = $this->getDoctrine()->getRepository(User::class)->find($currentUser->getCinuser());
        $post = $this->getDoctrine()->getRepository(Forum::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $likes = $this->getDoctrine()->getRepository(ReactedForum::class)->findreact($id, $currentUser->getCinuser());

        if ($likes == null) {
            $integer = intval($post->getNbrlikesforum()) + 1;
            $post->setNbrlikesforum($integer);
            $like->setIdcreater($user->getCinuser());
            $like->setIdforum($post->getIdforum());
            $em->persist($like);
            $em->persist($post);

            $em->flush();
        } else {
            $em->remove($likes);
            $integer = intval($post->getNbrlikesforum()) - 1;
            $post->setNbrlikesforum($integer);

            $em->persist($post);

            $em->flush();
        }




        return $this->redirectToRoute("forumFront");

    }

/**
* @Route("/disreact/{id}", name="disreacted-forum")
*/
    public function disreact($id): Response
    {

        $post = $this->getDoctrine()->getRepository(Forum::class)->find($id);
        $integer = intval($post->getNbrlikesforum()) - 1;

        $post->setNbrlikesforum($integer);


        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        return $this->redirectToRoute("forumFront");

    }


    /* *************** API ********************** */


    /**
     * @Route("/api/addforum", name="addForumApi")
     */
    public function addForumApi(Request $request, SerializerInterface $serializer)
    {
        try {
            $user = $this->getDoctrine()->getRepository(User::class)->find($request->get("idowner"));
            $forum=new Forum();
            $date = new \DateTime('@' . strtotime('now'));
            $forum->setDatecreation($date);
            $forum->setTitle($request->get("title"));//$content['title']
            $forum->setContent($request->get("content"));//$content['content']
            $forum->setCategorieforum($request->get("categorieforum"));//$content['categorieforum']
            $forum->setIdowner($user);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($forum);
            $manager->flush();
            return new Response('Added to DataBase',200);

        } catch
        (\Exception $exception) {
            return new Response("not added");
        }


    }


    /**
     * @Route ("api/getforums",name="getforumsApi")
     */
    public function getforumsApi(SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $state = "Active";
        $forums = $em->createQueryBuilder()
            ->select('f.idforum,f.datecreation,f.title,f.content,f.categorieforum,f.nbrlikesforum,f.nbrresponseforum,u.cinuser AS idOwner')
            ->from('App\Entity\Forum', 'f')
            ->innerJoin('App\Entity\User', 'u', 'with', "u.cinuser = f.idowner")
            ->where('f.state=:state')
            ->setParameter('state',$state)
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($forums, 'json', ['groups' => 'forums']);
        $Response = new Response($json);
        return $Response;

    }


    /**
     * @Route("/api/updateforum/{id}", name="updateForumApi")
     */
    public function updateForumApi(Request $request, SerializerInterface $serializer,$id)
    {
        try {
            $user = $this->getDoctrine()->getRepository(User::class)->find($request->get("idowner"));
            $forum=$this->getDoctrine()->getRepository(Forum::class)->find($id);
            $date = new \DateTime('@' . strtotime('now'));
            $forum->setDatecreation($date);
            $forum->setTitle($request->get("title"));//$content['title']
            $forum->setContent($request->get("content"));//$content['content']
            $forum->setCategorieforum($request->get("categorieforum"));//$content['categorieforum']
            $forum->setIdowner($user);
            $manager = $this->getDoctrine()->getManager();
            //$manager->persist($forum);
            $manager->flush();
            return new Response('updated',200);

        } catch
        (\Exception $exception) {
            return new Response("not added");
        }


    }


    /**
     * @Route ("/api/deletforum/{id}",name="deletforumapi")
     */
    public function deleteforumapi(Request $request, SerializerInterface $serializer,$id)
    {
        try {
            $event = $this->getDoctrine()->getRepository(Forum::class)->find($id);
            $event->setState($request->get('state'));//$content['locationEvent']
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return new Response('deleted to DataBase',200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }
    }


}

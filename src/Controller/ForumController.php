<?php

namespace App\Controller;


use App\Entity\Forum;
use App\Entity\Responded;
use App\Entity\User;
use App\Form\ForumType;
use App\Repository\ForumRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class ForumController extends AbstractController
{
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
     * @Route("/navbar-v2-forums", name="navbar-v2-forum" , methods={"GET", "POST"})
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

        return $this->render('FrontOffice/navbar-v2-forums.html.twig',['forums'=>$forums,'responses'=>$responded]);
    }

    /**
     * @Route("/addresponse/{idforum}", name="createresponse",methods={"GET", "POST"})
     */
    public function addresponse(Request $request,$idforum): Response
    {
        dump($request);
        $response = new Responded();
        $forum=$this->getDoctrine()->getRepository(Forum::class)->find($idforum);
        $user=$this->getDoctrine()->getRepository(User::class)->find(10020855);
        $response->setContent($request->get('responsecontent'));
        $response->setIdforum($forum);
        $response->setCinuser($user);
        $response->setCreatedat(new \DateTime('@' . strtotime('now')));
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($response);
        $manager->flush();

        return $this->redirectToRoute('navbar-v2-forum');
    }
    /**
     * @Route("/addforum", name="addforum",methods={"GET", "POST"})
     */
    public function addforum(Request $request): Response
    {
        dump($request);
        $forum = new Forum();
        $user=$this->getDoctrine()->getRepository(User::class)->find(10020855);
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


        return $this->redirectToRoute('navbar-v2-forum');
    }

    /**
     * @Route ("/deleteforum/{id}",name="deleteforum")
     */
    public function delete($id)
    {
        $em=$this->getDoctrine()->getManager();
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
        return $this->redirectToRoute('navbar-v2-forums');
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
            return $this->redirectToRoute("navbar-v2-forum");
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
     * @Route("/api/rechercheForumIdTitleCat/{id}/{title}/{category}", name="rechercheForumIdTitleCat", methods={"GET"})
     */
    public function rechercheForumIdTitleCat($id, $title, $category, SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $forums=$em->createQueryBuilder()
            ->select('f.idforum,f.datecreation,f.title,f.content,f.categorieforum,f.nbrlikesforum,f.nbrresponseforum,u.cinuser AS idowner')
            ->from('App\Entity\Forum','f')
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = f.idowner")
            ->where('f.idforum=:id')
            ->andWhere('f.title=:title')
            ->andWhere('f.categorieforum=:category')
            ->setParameters(array('id'=>$id,'title'=>$title,'category'=>$category))
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($forums, 'json', ['groups' => '$forums']);
        $Response = new Response($json);
        return $Response;
    }
}

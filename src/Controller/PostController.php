<?php

namespace App\Controller;

use App\Entity\Commented;
use App\Entity\Like;
use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use App\Repository\PostRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


class PostController extends AbstractController
{

    public function indexAction()
    {

        $posts = $this->getDoctrine()->getRepository(Post::class)->findByState("'Active'");
        $cmts = $this->getDoctrine()->getRepository(Commented::class)->findAll();
        $likes = $this->getDoctrine()->getRepository(Like::class)->findAll();


        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['Posts',     count($posts)],
                ['Comments',      count($cmts)],
                ['likes',  count($likes)],

            ]
        );
        $pieChart->getOptions()->setTitle('Statistique Posts');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $pieChart;
    }



    /**
     * @Route ("/showP",name="showP")
     */
    public function showP(Request $request): Response
    {

        $posts = $this->getDoctrine()->getRepository(Post::class)->findByState("'Active'");
        $user = $this->getDoctrine()->getRepository(User::class)->find(25451120);
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getDoctrine()->getRepository(User::class)->find(25451120);
            $currentDate = new \datetime();
            $uploadedFile = $form['mediaURL']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '\public\upload\post';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename);
                $post->setMediaurl($newFilename);
            }
            $post->setMediaurl("appicon.png");
            $post->setCreatedat($currentDate);
            $post->setIdower($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('showP', [], Response::HTTP_SEE_OTHER);


        }

        $comments = sizeof($this->getDoctrine()->getRepository(Commented::class)->findBypostcommented($post->getIdpost()));


        return $this->render('FrontOffice/post.html.twig', ["form" => $form->createView(), 'posts' => $posts, "user" => $user, "cmt" => $comments]);
    }


    /**
     * @Route ("/PostDashboard",name="PostDashboard")
     */
    public function getPosts(): Response
    {
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findAll();

        return $this->render('BackOffice/PostDashboard.html.twig', ['posts' => $posts,"piechart"=>$this->indexAction()


            ]);

    }

    /**
     * @Route ("/PostDashboard/{id}",name="deletepost")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);
        $post->setState("Desactive");
        $em->flush();
        return $this->redirectToRoute('PostDashboard');
    }


    /**
     * @Route ("/Post/{id}",name="deleteP")
     */
    public function deleteP($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $post->setState("Desactive");
        $em->flush();
        return $this->redirectToRoute('showP');
    }

    /**
     * @Route("/editP/{id}", name="editP")
     */
    public function editP(Request $request, $id): Response
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findByState("'Active'");
        $postE = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $formE = $this->createForm(PostType::class, $postE);

        $formE->handleRequest($request);
        if ($formE->isSubmitted() && $formE->isValid()) {
            $uploadedFile = $formE['mediaURL']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '\public\upload\post';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '.' . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename);
                $postE->setMediaurl($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('showP');
        }

        return $this->render('FrontOffice/post.html.twig', array('form' => $formE->createView(), "posts" => $posts));
    }

    /**
     * @Route("/love/{id}", name="love")
     */
    public function love($id): Response
    {
        $like = new Like();
        $user = $this->getDoctrine()->getRepository(User::class)->find(25451120);
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $likes = $this->getDoctrine()->getRepository(Like::class)->findlike($id, 25451120);

        if ($likes == null) {
            $integer = intval($post->getLikenum()) + 1;
            $post->setLikenum($integer);
            $like->setLikeuser($user->getCinuser());
            $like->setLikepost($post->getIdpost());
            $em->persist($like);
            $em->persist($post);

            $em->flush();
        } else {
            $em->remove($likes);
            $integer = intval($post->getLikenum()) - 1;
            $post->setLikenum($integer);

            $em->persist($post);

            $em->flush();
        }




        return $this->redirectToRoute("showP");

    }

    /**
     * @Route("/unlove/{id}", name="unlove")
     */
    public function unLove($id): Response
    {

        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $integer = intval($post->getLikenum()) - 1;

        $post->setLikenum($integer);


        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        return $this->redirectToRoute("showP");

    }

    /**
     * @Route("/TrierParDateAsc", name="TrierParDateAsc")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function TrierParDateAsc(PostRepository $postRepository)
    {
        $posts = $postRepository->sortByDateAsc();
        dump($posts);
        return $this->render('BackOffice/PostDashboard.html.twig', ['posts' => $posts,'piechart'=>$this->indexAction()]);
    }

    /**
     * @Route("/TrierParDateDesc", name="TrierParDateDesc")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function TrierParDateDesc(PostRepository $postRepository)
    {
        $posts = $postRepository->sortByDateDesc();
        dump($posts);
        return $this->render('BackOffice/PostDashboard.html.twig', ['posts' => $posts,'piechart'=>$this->indexAction()]);
        //return $this->redirectToRoute('UserDashboard', ['users' => $users]);
    }
    /**
     *  * Creates a new ActionItem entity.
     *
     * @Route("/search", name="ajax_search")
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $requestString = $request->get('q');

        $entities =  $em->getRepository(Post::class)->findEntitiesByString($requestString);
        if(!$entities) {
            $result['entities']['error'] = "error";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }

        return new Response(json_encode($result));
    }

    public function getRealEntities($entities){

        foreach ($entities as $entity){
            $realEntities[$entity->getId()] = $entity->getFoo();
        }

        return $realEntities;
    }



    ///Api

    /**
     * @Route("/api/postList", name="postList", methods={"GET"})
     */
    public function postList(SerializerInterface $serializer, EntityManagerInterface $em): Response
    {

        $alerts=$em->createQueryBuilder()
            ->select('p.idpost, p.content, p.mediaurl, p.createdat, p.categorie, p.likenum,u.cinuser AS idower')
            ->from('App\Entity\Post','p')
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = p.idower")
            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($alerts, 'json', ['groups' => 'alerts']);
        $Response = new Response($json);
        return $Response;
    }


    /**
     * @Route("/api/recherchePostIdContentCategory/{id}/{content}/{category}", name="recherchePostIdContentCategory", methods={"GET"})
     */
    public function recherchePostIdContentCategory($id, $content, $category, SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $posts=$em->createQueryBuilder()
            ->select('p.idpost, p.content, p.mediaurl, p.createdat, p.categorie, p.likenum, u.cinuser AS idower')
            ->from('App\Entity\Post','p')
            ->innerJoin('App\Entity\User','u','with', "u.cinuser = p.idower")
            ->where('p.idpost=:id')
            ->andWhere('p.content=:content')
            ->andWhere('p.categorie=:categorie')
            ->setParameters(array('id'=>$id,'content'=>$content,'categorie'=>$category))

            ->getQuery()
            ->getArrayResult();
        $json = $serializer->serialize($posts, 'json', ['groups' => '$posts']);
        $Response = new Response($json);
        return $Response;
    }



    /**
     * @Route("/api/addPostApi", name="addPostApi")
     */
    public function addPostApi(Request $request, SerializerInterface $serializer)
    {
        try {

            $content=$request->getContent();
            $posts=json_decode($content,true);
            $post = New Post();
            $post->setCategorie($posts['categorie']);
            $post->setContent($posts['content']);
            $post->setMediaurl($posts['mediaurl']);
            $post->setCreatedat(new \DateTime('@' . strtotime('now')));
            $user=$this->getDoctrine()->getRepository(User::class)->findOneBy(['cinuser'=>$posts['idower']]);
            $post->setIdower($user);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();
            return new Response('Added to DataBase',200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }


    }


    /**
     * @Route("/api/updatePostAPI/{id}", name="updatePostAPI")
     */
    public function updatePostAPI(Post $post, Request $request, $id)
    {
        try {

            $content=$request->getContent();
            $posts=json_decode($content,true);
            $post = $this->getDoctrine()->getManager()->getRepository(Post::class)->find($id);
            $post->setCategorie($posts['categorie']);
            $post->setContent($posts['content']);
            $post->setMediaurl($posts['mediaurl']);
            $post->setCreatedat(new \DateTime('@' . strtotime('now')));
            $user=$this->getDoctrine()->getRepository(User::class)->findOneBy(['cinuser'=>$posts['idower']]);
            $post->setIdower($user);
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return new Response('update to DataBase',200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }
    }

    /**
     * @Route("/api/deletePostApi/{id}", name="deletePostApi")
     */
    public function deletePostApi(Post $post, Request $request, $id)
    {
        try {

            $content=$request->getContent();
            $posts=json_decode($content,true);
            $post = $this->getDoctrine()->getManager()->getRepository(Post::class)->find($id);
            $post->setState('Deleted');
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return new Response('Deleted',200);

        } catch
        (\Exception $exception) {
            return new Response($exception->getMessage());
        }
    }


}

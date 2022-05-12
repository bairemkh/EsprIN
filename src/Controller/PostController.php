<?php

namespace App\Controller;

use App\Entity\Commented;
use App\Entity\Like;
use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Services\SessionManagmentService;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route ("/postFront",name="postFront")
     */
    public function showP(Request $request,SessionManagmentService $sessionManagmentService): Response
    {
        $currentUser=$sessionManagmentService->getUser();
        $posts = $this->getDoctrine()->getRepository(Post::class)->findByState("Active");
        $user = $this->getDoctrine()->getRepository(User::class)->find($currentUser->getCinuser());
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getDoctrine()->getRepository(User::class)->find($currentUser->getCinuser());
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

            return $this->redirectToRoute('postFront', [], Response::HTTP_SEE_OTHER);


        }

        $comments = sizeof($this->getDoctrine()->getRepository(Commented::class)->findBypostcommented($post->getIdpost()));


        return $this->render('FrontOffice/postFront.html.twig', ["form" => $form->createView(), 'posts' => $posts, "user" => $user, "cmt" => $comments]);
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
        $posts = $this->getDoctrine()->getRepository(Post::class)->findByState("Active");
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

        return $this->render('FrontOffice/postFront.html.twig', array('form' => $formE->createView(), "posts" => $posts));
    }

    /**
     * @Route("/love/{id}", name="love")
     */
    public function love($id,SessionManagmentService $sessionManagmentService): Response
    {
        $currentUser=$sessionManagmentService->getUser();
        $like = new Like();
        $user = $this->getDoctrine()->getRepository(User::class)->find($currentUser->getCinuser());
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $likes = $this->getDoctrine()->getRepository(Like::class)->findlike($id, $currentUser->getCinuser());

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
     * @Route("/TrierParDateAscPost", name="TrierParDateAscPost")
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
     * @Route("/TrierParDateDescPost", name="TrierParDateDescPost")
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

    /**
     * @Route ("api/getposts",name="get-posts-api")
     */
    public function getpostsApi(SerializerInterface $serializer): Response
    {
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findAll();
        $json = $serializer->serialize($posts, 'json', ['groups' => 'posts']);
        $Response = new Response($json);

        return $Response;
    }


}

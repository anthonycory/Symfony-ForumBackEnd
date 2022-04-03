<?php

namespace App\Controller\Api;

use App\Entity\Comments;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\CommentsRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CommentaryController extends AbstractController
{
    /**
     * @Route("/api/commentary", name="commentary", methods={"POST"})
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        $commentary = new Comments();
        $commentary->setResponse($data["response"]);
        $commentary->setCreatedAt(new \DateTimeImmutable());
        $commentary->setUser($em->getRepository(User::class)->find($data['id_user']));
        $commentary->setPost($em->getRepository(Post::class)->find($data['id_post']));

        $em->persist($commentary);
        $em->flush();

        return  new response('Hello ', response::HTTP_OK);
    }

    /**
     * @Route("/api/commentary/{id}", name="read_commentary", methods={"GET"})
     */
    public function read_single(int $id, SerializerInterface $serializer, CommentsRepository $comments): Response
    {
        $post = $comments->findAll();

        $notFound = new JsonResponse(array('message' => 'Not Found',), 404, [], false);
        $succes = new JsonResponse($serializer->serialize($post, 'json', ["groups" => "GetPost"]), 200, [], true);

        !$post ? $response = $notFound : $response = $succes;

        return $response;
    }
}

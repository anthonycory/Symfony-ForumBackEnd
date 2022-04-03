<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractController
{
    /**
     * @Route("/api/post", name="post", methods={"GET"})
     */
    public function index(PostRepository $postRepository, SerializerInterface $serializer): Response
    {
        $post = $postRepository->findAll();

        $json = $serializer->serialize($post, 'json', ["groups" => "Post"]);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/post/{id}", name="api_sujet_read_single", methods={"GET"})
     */
    public function read_single(int $id, SerializerInterface $serializer, PostRepository $postRepository): Response
    {
        $post = $postRepository->find($id);

        $notFound = new JsonResponse(array('message' => 'Not Found',), 404, [], false);
        $succes = new JsonResponse($serializer->serialize($post, 'json', ["groups" => "Post"]), 200, [], true);

        !$post ? $response = $notFound : $response = $succes;

        return $response;
    }

    /**
     * @Route("/api/post/edit/{id}", name="post_edit", methods={"PUT"})
     */
    public function editPost(int $id, ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $post = $entityManager->getRepository(Post::class)->find($id);

        if (!$post) {
            return $response = new JsonResponse(array('message' => 'Not found',), 404, [], false);
        }

        $response = new JsonResponse(array('message' => 'Data Update',), 200, [], false);

        $data = json_decode($request->getContent(), true);

        $post->setTitle($data["title"]);
        $post->setContent($data["content"]);

        $entityManager->flush();

        return $response;
    }

    /**
     * @Route("/api/post/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(int $id, PostRepository $postRepository, EntityManagerInterface $em): Response
    {
        $post = $postRepository->find($id);

        $em->remove($post);
        $em->flush();

        return new JsonResponse(array('message' => 'Succes delete',), 200);
    }

    /**
     * @Route("/api/post", name="api_post_create", methods={"POST"})
     */
    public function post(Request $request, EntityManagerInterface $em, PostRepository $postRepository, SerializerInterface $serializer): response

    {
        // $data = json_decode($request->getContent(), true);

        // $post = new Post();
        // $post->setTitle($data["title"]);
        // $post->setContent($data["content"]);
        // $post->setUser($em->getRepository(User::class)->find($data['author']));
        // $post->setCategory($em->getRepository(Category::class)->find($data['id_category']));
        // $post->setCreatedAt(new \DatetimeImmutable());

        // $em->persist($post);
        // $em->flush();

        // $json = $serializer->serialize($postRepository->find($post->getid()), 'json', ["groups" => "Post"]);

        // return new response($json, response::HTTP_OK);
        dd("Succes");
    }
}

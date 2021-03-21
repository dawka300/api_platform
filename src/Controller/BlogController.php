<?php


namespace App\Controller;


use App\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

/**
 * Class BlogController
 * @Route("/blog")
 */
class BlogController extends AbstractController
{

    /**
     * @Route("/{page}", name="blog_list", defaults={"page": 1}, requirements={"page"="\d+"})
     * @param $page
     * @param Request $request
     * @return JsonResponse
     */
    public function list($page, Request $request) {
        $limit = $request->get('limit', 10);
        $repository = $this->getDoctrine()->getRepository(BlogPost::class);
        $items = $repository->findAll();

      return  $this->json([
          'page' => $page,
          'limit' => $limit,
          'data' => array_map(function (BlogPost $item){
              return $this->generateUrl('blog_by_slug', ['slug' => $item->getSlug()]);
          }, $items)
      ]);
    }

    /**
     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"}, methods={"GET"})
     * @param BlogPost $post
     * @return JsonResponse
     */
    public function post(BlogPost $post){
       return $this->json(
          $post
       );
    }

    /**
     * @Route("/post/{slug}", name="blog_by_slug", methods={"GET"})
     */
    public function postBySlug(BlogPost $post) {
       return $this->json(
           $post
       );
    }

    /**
     * @Route("/add", name="blog_add", methods={"POST"})
     * @param Request $request
     */
    public function add(Request $request): JsonResponse
    {
        $serialize = $this->get('serializer');

        $blogPost = $serialize->deserialize($request->getContent(), BlogPost::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($blogPost);
        $em->flush();

        return $this->json($blogPost);
    }

    /**
     * @Route("/post/{id}", name="blog_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     * @param BlogPost $post
     */
    public function delete(BlogPost $post): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);

    }

}
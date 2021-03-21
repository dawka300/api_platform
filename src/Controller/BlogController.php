<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlogController
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    private const POSTS = [
        [
            'id' => 1,
            'slug' => 'slug',
            'title' => 'Hello Word'
        ],
        [
            'id' => 2,
            'slug' => 'another-post',
            'title' => 'Another Post'
        ],
        [
            'id' => 3,
            'slug' => 'last-example',
            'title' => 'Last example'
        ]
    ];

    /**
     * @Route("/{page}", name="blog_list", defaults={"page": 1})
     * @param $page
     * @param Request $request
     * @return JsonResponse
     */
    public function list($page, Request $request) {
        $limit = $request->get('limit', 10);
      return  $this->json([
          'page' => $page,
          'limit' => $limit,
          'data' => array_map(function ($item){
              return $this->generateUrl('blog_by_slug', ['slug' => $item['slug']]);
          }, self::POSTS)
      ]);
    }

    /**
     * @Route("/{id}", name="blog_by_id", requirements={"id"="\d+"})
     */
    public function post($id){
       return $this->json(
           self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
       );
    }

    /**
     * @Route("/{slug}", name="blog_by_slug")
     */
    public function postBySlug($slug) {
       return $this->json(
           self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]
       );
    }

}
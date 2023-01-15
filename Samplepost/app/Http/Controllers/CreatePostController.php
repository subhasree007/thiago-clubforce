<?php

namespace App\Http\Controllers;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use App\Models\Post;

class CreatePostController extends Controller
{

    public function createPost(Request $request): JsonResponse
    {

        $beginsWith = 'Qwerty';
        $payload = $request->toArray();

        if(str_starts_with($payload['title'] , $beginsWith))
        {

            return new JsonResponse(
                [
                    'error' => 'Title Should not start with Qwerty',
                ],
                Response::HTTP_BAD_REQUEST,
            );


        }else{

            $data = [
                "id"            => $payload['id'] ?? (string)Uuid::v4(),
                "title"         => $payload['title'],
                "summary"       => $payload['summary'],
                "description"   => $payload['description']
            ];



            $response = $this->addpost($data);

            return new JsonResponse(
                [
                   'post_id' => $response['id']
                ],
                Response::HTTP_OK,
            );

        }


    }

    private function addpost(array $data) {

        try {

            return Post::create([
                'id' => $data['id'],
                'title' => $data['title'],
                'summary' => $data['summary'],                             // 1 - Pending, 2 - Active, 3 - Inactive
                'post_description'=> $data['description']
            ]);

        } catch (Exception $exception) {
            return new JsonResponse(
                [
                    'error' => $exception->getMessage(),
                ],
                Response::HTTP_BAD_REQUEST,
            );
        }

    }

    public function getPost(Request $request,$post_id){

        try {

            $post = Post::find($post_id);
            return new JsonResponse(
                [
                   'post_data' => $post
                ],
                Response::HTTP_OK,
            );

        }catch (Exception $exception) {
            return new JsonResponse(
                [
                    'error' => 'Invalid Postid,Kindly check again',
                ],
                Response::HTTP_BAD_REQUEST,
            );
        }
    }

}

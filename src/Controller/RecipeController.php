<?php

namespace App\Controller;

use App\Service\RecipePuppy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RecipeController extends AbstractController {

    /**
     * @param $text
     * @return null|string
     * @throws \App\Service\HsfException
     */
    public function searchRecipe($text = null) {

        try {
            if (!empty($text)) {

                $RecipePuppy = new RecipePuppy();
                $result = $RecipePuppy->searchRecipe($text);
                $data = [
                    'status' => 'ok',
                    'code' => 200,
                    'data' => $result,
                ];
            } else {
                $data = [
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Debes indicar un cadena de búsqueda',
                ];
            }
        } catch (\Exception $e) {
            $data = [
                'status' => 'error',
                'code' => 400,
                'data' => $e,
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @param int $page
     * @return Response
     * @throws \App\Service\HsfException
     */
    public function getListByPage($page = 1) {
        try {
            $RecipePuppy = new RecipePuppy();
            $result = $RecipePuppy->getListByPage($page);
            $food_types = ['meat', 'fish & seafood', 'dairy-free', 'vegetarian', 'vegan'];
            $response = ['recipes' => $result, 'food_types' => $food_types];
            $data = [
                'status' => 'ok',
                'code' => 200,
                'data' => $response,
            ];
        } catch (\Exception $e) {
            $data = [
                'status' => 'error',
                'code' => 400,
                'data' => $e,
            ];
        }

        return new JsonResponse($data);
    }
}
<?php

namespace AppBundle\Controller;

use AppBundle\DTO;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

class MessageController extends Controller
{
    /**
     * @param HttpFoundation\Request $request
     * @param string $contactRef
     * @return HttpFoundation\JsonResponse
     */
    public function sendMessageAction(HttpFoundation\Request $request, $contactRef)
    {
        /**
         * @var DTO\Response\ApiResponse
         */
        $response = $this->get('pushfor.api.send_message')($contactRef, $request->getContent());

        return new HttpFoundation\JsonResponse($response->serialize());
    }

    /**
     * @param HttpFoundation\Request $request
     * @param string $contactRef
     *
     * @return HttpFoundation\JsonResponse
     */
    public function readMessageAction(HttpFoundation\Request $request, $contactRef)
    {
        $response = $this->get('pushfor.api.read_message')($contactRef);

        return new HttpFoundation\JsonResponse($response->serialize());
    }
}
<?php

namespace AppBundle\Controller;

use AppBundle\DTO;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;

class ContactController extends Controller
{
    /**
     * @param HttpFoundation\Request $request
     * @param int $senderId
     * @param int $receiverId
     * @return HttpFoundation\JsonResponse
     */
    public function requestAction(HttpFoundation\Request $request, $senderId, $receiverId)
    {
        /**
         * @var DTO\Response\ApiResponse
         */
        $response = $this->get('pushfor.api.new_contact_request')($senderId, $receiverId, $request->getContent());

        return new HttpFoundation\JsonResponse($response->serialize());
    }

    /**
     * @param HttpFoundation\Request $request
     * @param int $senderId
     * @return HttpFoundation\JsonResponse
     */
    public function receiveAction(HttpFoundation\Request $request, $senderId)
    {
        $response = $this->get('pushfor.api.receive_contact_request')($senderId, $request->getContent());

        return new HttpFoundation\JsonResponse($response->serialize());
    }
}
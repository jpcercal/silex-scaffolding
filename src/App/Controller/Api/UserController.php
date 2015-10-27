<?php

namespace App\Controller\Api;

use App\Controller\AbstractController;
use App\Entity\User;
use App\Response\ConstraintViolationResponse;
use App\Validation\UserValidation;
use Cekurte\ResourceManager\DoctrineResourceManager;
use Cekurte\ResourceManager\Query\Expr\DoctrineQueryExpr;
use Cekurte\ResourceManager\Query\QueryString;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;

class UserController extends AbstractController
{
    protected function getResourceManager()
    {
        return new DoctrineResourceManager(
            $this->getDoctrineEm(),
            'App\Entity\User'
        );
    }

    public function indexAction(Request $request)
    {
        $psrRequest = (new DiactorosFactory())->createRequest($request);

        $expr = (new QueryString())->process($psrRequest);

        $resources = $this
            ->getResourceManager()
            ->findResources($expr)
        ;

        return new Response($this->getApp()["serializer"]->serialize($resources, 'json'), 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    public function showAction(Request $request, $username)
    {
        $expr = new DoctrineQueryExpr();
        $expr->eq('c.username', $username);

        $resource = $this->getResourceManager()->findResource($expr);

        return new Response($this->getApp()["serializer"]->serialize($resource, 'json'), 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    public function createAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $errors = (new UserValidation($this->getApp()['validator']))->validate($data);

        if (count($errors) > 0) {
            return new ConstraintViolationResponse($errors);
        }

        $resource = new User();
        $resource->setUsername($data['username']);
        $resource->setSalt(md5($data['username'] . $data['password']));


        $encoderFactory = $this->getApp()['security.encoder_factory'];
        $encoder  = $encoderFactory->getEncoder($resource);
        $password = $encoder->encodePassword($data['password'], $user->getSalt());

        $resource->setPassword($password);

        $this->getResourceManager()->writeResource($resource);

        return new Response('', 201, [
            'Content-Type' => 'application/json'
        ]);
    }

    public function updateAction(Request $request, $username)
    {
        $data = json_decode($request->getContent(), true);

        $errors = (new UserValidation($this->getApp()['validator']))->validate($data);

        if (count($errors) > 0) {
            return new ConstraintViolationResponse($errors);
        }

        $expr = new DoctrineQueryExpr();
        $expr->eq('c.username', $username);

        $resource = $this->getResourceManager()->findResource($expr);

        $encoderFactory = $this->getApp()['security.encoder_factory'];
        $encoder  = $encoderFactory->getEncoder($resource);
        $password = $encoder->encodePassword($data['password'], $user->getSalt());

        $resource->setPassword($password);

        $this->getResourceManager()->updateResource($resource);

        return new Response('', 204, [
            'Content-Type' => 'application/json'
        ]);
    }

    public function deleteAction(Request $request, $username)
    {
        $expr = new DoctrineQueryExpr();
        $expr->eq('c.username', $username);

        $resource = $this->getResourceManager()->findResource($expr);

        $this->getResourceManager()->deleteResource($resource);

        return new Response('', 204, [
            'Content-Type' => 'application/json'
        ]);
    }
}

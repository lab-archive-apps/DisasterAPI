<?php

namespace App\Controller;

use App\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/* User Management Controller */
class UsersController extends BaseController {

    public function index(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $users = User::query()->get();

        return $this->view->render($response, '/users/index.twig', [
            'params' => $params,
            'users' => $users
        ]);
    }

    public function create(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        return $this->view->render($response, '/users/create.twig', [
            'params' => $params,
        ]);
    }

    public function show(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $user = User::find($args['userId']);
        return $this->view->render($response, '/users/show.twig', [
            'params' => $params,
            'user' => $user
        ]);
    }

    public function edit(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $user = User::find($args['userId']);
        return $this->view->render($response, '/users/edit.twig', [
            'params' => $params,
            'user' => $user
        ]);
    }

    public function store(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
    }

    public function update(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
    }

    public function delete(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
    }
}
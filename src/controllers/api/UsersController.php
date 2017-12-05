<?php

namespace App\Controller\API;

use App\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;
use App\Search\UserSearch;

/* User Management Controller */
class UsersController extends BaseController {
    private $res = [
        'result' => 'failed',
        'state' => false,
        'error' => ''
    ];

    /* Get users */
    public function getUsers(Request $request, Response $response, $args)
    {
        $params = $request->getAttribute('params');

        $query = new UserSearch(User::query(), $params->get);
        $users = $query->search();

        return $response->withJson($users);
    }

    /* Get user with corresponds */
    public function getUser(Request $request, Response $response, $args)
    {
        $params = $request->getAttribute('params');

        $user = User::query()->find($params->get->user_id);
        return $response->withJson($user);
    }

    /* Post user */
    public function postUser(Request $request, Response $response, $args)
    {
        $params = $request->getAttribute('params');

        $user = new User();
        $user->fill([
        ]);

        if ($user->save()) {
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }else{
            $this->res['error'] = '登録に失敗しました．';
        }

        return $response->withJson($this->res);
    }

    /* Update user */
    public function updateUser(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $user = User::find($params->post->user_id);
        $data = [];

        if ($user->update($data)){
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }else {
            $this->res['error'] = '更新に失敗しました．';
        }

        return $response->withJson($this->res);
    }

    /* Delete user */
    public function deleteUser(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $user = User::find($params->post->id);

        if ($user->delete()) {
            $this->res['result'] = 'success';
            $this->res['state'] = true;
        }else {
            $this->res['error'] = '削除に失敗しました．';
        }
        return $response->withJson($this->res);
    }
}
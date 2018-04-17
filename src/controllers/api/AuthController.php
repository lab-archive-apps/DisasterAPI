<?php
namespace App\Controller\API;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Controller\BaseController;
use App\Models\User;

/**
 * Login Process
 */
class AuthController extends BaseController{
    public function postLogin(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        $user = User::query()
            ->where('user_id', $params->post->user_id)
            ->where('password', $params->post->password)
            ->get(['id', 'name', 'user_id', 'division', 'admin'])->first();

        if (isset($user)) {
            // Login success.
            $this->res['result'] = 'success';
            $this->res['state'] = true;
            $this->res['user'] = $user;
            // save a session data.
            $this->session->put([
                'state' => true,
                'id' => $user->id,
                'user_id' => $user->user_id,
                'admin' => $user->admin,
                'time' => time()
            ]);
        } else {
            // Login failed.
            $this->res['error'] = 'ユーザが存在しません．';
        }

        return $response->withJson($this->res);
    }


    public function postLogout(Request $request, Response $response, $args){
        $this->session->destroy();
        $this->res['result'] = 'success';
        $this->res['state'] = true;
        return $response->withJson($this->res);
    }
}
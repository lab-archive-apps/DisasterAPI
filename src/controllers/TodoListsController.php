<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\BaseList;
use App\Models\TodoList;

/* TodoList Management Controller */
class TodoListsController extends BaseController {

    public function index(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $lists = BaseList::query()->get();

        return $this->view->render($response, '/lists/index.twig', [
            'params' => $params,
            'lists' => $lists
        ]);
    }

    public function create(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        return $this->view->render($response, '/lists/create.twig', [
            'params' => $params,
        ]);
    }

    public function show(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        return $this->view->render($response, '/lists/show.twig', [
            'params' => $params,
        ]);
    }

    public function edit(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        return $this->view->render($response, '/lists/edit.twig', [
            'params' => $params,
        ]);
    }

    public function store(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $list = new BaseList();

        if($list->save()){
            $messages = [];
            foreach ($params->post->list as $key => $value){
                $msg = new TodoList();
                $msg->fill(json_decode(json_encode($value), true));
                $messages[] = $msg;
            }
            $list->messages()->saveMany($messages);
            $this->flash->addMessage('notice', '登録が完了しました．');
            return $response->withRedirect($this->router->pathFor('list_index', [], []));
        }else{
            $this->flash->addMessage('error', '登録に失敗しました．');
            return $response->withRedirect($this->router->pathFor('list_create', [], [
                'params' => $params,
            ]));
        }
    }

    public function update(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
    }

    public function delete(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
    }
}
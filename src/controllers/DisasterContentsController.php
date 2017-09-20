<?php

namespace App\Controller;

use App\Models\DisasterContent as Content;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/* Disaster Contents Management Controller */
class DisasterContentsController extends BaseController {

    public function index(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $contents = Content::query()->get();

        return $this->view->render($response, '/disasters/contents/index.twig', [
            'params' => $params,
            'contents' => $contents
        ]);
    }

    public function create(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        return $this->view->render($response, '/disasters/contents/create.twig', [
            'params' => $params,
        ]);
    }

    public function edit(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $content = Content::find($args['contentId']);
        return $this->view->render($response, '/disasters/contents/edit.twig', [
            'params' => $params,
            'content' => $content
        ]);
    }

    public function store(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $content = new Content();
        $content->fill(json_decode(json_encode($params->post->content), true));
        if($content->save()){
            $this->flash->addMessage('notice', '登録が完了しました．');
            return $response->withRedirect($this->router->pathFor('content_index', [], []));
        }else{
            $this->flash->addMessage('error', '登録に失敗しました．');
            return $response->withRedirect($this->router->pathFor('content_create', [], [
                'params' => $params,
            ]));
        }
    }

    public function update(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $content = Content::find($args['contentId']);
        $content->fill(json_decode(json_encode($params->post->content), true));

        if($content->save()){
            $this->flash->addMessage('notice', '更新が完了しました．');
            return $response->withRedirect($this->router->pathFor('content_index', [], []));
        }else{
            $this->flash->addMessage('error', '更新に失敗しました．');
            return $response->withRedirect($this->router->pathFor('content_create', [], [
                'params' => $params,
            ]));
        }
    }

    public function delete(Request $request, Response $response, $args){
        var_dump('delete');
        exit;
        $params = $request->getAttribute('params');
        $content = Content::find($args['contentId']);

        if($content->delete()){
            $this->flash->addMessage('notice', '削除が完了しました．');
        }else{
            $this->flash->addMessage('error', '削除に失敗しました．');
        }

        return $response->withRedirect($this->router->pathFor('content_index', [], [
            'params' => $params,
        ]));
    }
}
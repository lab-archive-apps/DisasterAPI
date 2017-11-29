<?php

namespace App\Controller;

use App\Models\Disaster;
use App\Models\ResponseRecord;
use App\Models\Contents as Content;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


/* Disaster Corresponds Management Controller */
class DisasterCorrespondsController extends BaseController {

    public function index(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $disaster = Disaster::find($args['disasterId']);

        return $this->view->render($response, '/disasters/corresponds/index.twig', [
            'params' => $params,
            'disaster' => $disaster
        ]);
    }

    public function create(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $disaster = Disaster::find($args['disasterId']);
        $sections = Content::query()->where('type', 'section')->get(['name']);
        $contents = Content::query()->where('type', 'content')->get(['name']);
        return $this->view->render($response, '/disasters/corresponds/create.twig', [
            'params' => $params,
            'disaster' => $disaster,
            'sections' => $sections,
            'contents' => $contents
        ]);
    }

    public function show(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $disaster = Disaster::find($args['disasterId']);
        return $this->view->render($response, '/disasters/corresponds/show.twig', [
            'params' => $params,
            'disaster' => $disaster
        ]);
    }

    public function edit(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $disaster = Disaster::find($args['disasterId']);
        $sections = Content::query()->where('type', 'section')->get(['name']);
        $contents = Content::query()->where('type', 'content')->get(['name']);
        return $this->view->render($response, '/disasters/corresponds/edit.twig', [
            'params' => $params,
            'disaster' => $disaster,
            'sections' => $sections,
            'contents' => $contents
        ]);
    }

    public function store(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $disaster = Disaster::find($args['disasterId']);

        $params->post->correspond->contents = implode(',', $params->post->correspond->contents);
        $correspond = new ResponseRecord(json_decode(json_encode($params->post->correspond), true));

        if($disaster->corresponds()->save($correspond)){
            $this->flash->addMessage('notice', '更新が完了しました．');
            return $response->withRedirect($this->router->pathFor('correspond_index', [
                'disasterId' => $args['disasterId']
            ], []));
        }else{
            $this->flash->addMessage('error', '登録に失敗しました．');
            return $response->withRedirect($this->router->pathFor('correspond_create', [
                'disasterId' => $args['disasterId']
            ], [
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
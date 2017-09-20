<?php

namespace App\Controller;

use App\Models\Disaster;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\DisasterCoordinate;
use App\Models\DisasterContent as Content;

/* Disaster Management Controller */
class DisastersController extends BaseController {

    public function index(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        $disasters = Disaster::query()->get();

        return $this->view->render($response, '/disasters/cases/index.twig', [
            'params' => $params,
            'disasters' => $disasters
        ]);
    }

    public function create(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $classes = Content::query()->where('type', 'class')->get(['name']);
        $scales = Content::query()->where('type', 'scale')->get(['name']);

        return $this->view->render($response, '/disasters/cases/create.twig', [
            'params' => $params,
            'classes' => $classes,
            'scales' => $scales
        ]);
    }

    public function show(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $disaster = Disaster::find($args['disasterId']);
        return $this->view->render($response, '/disasters/cases/show.twig', [
            'params' => $params,
            'disaster' => $disaster
        ]);
    }

    public function edit(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $disaster = Disaster::find($args['disasterId']);
        $disaster['coordinates'] = $disaster->coordinates;
        var_dump($disaster);
        exit;
        $classes = Content::query()->where('type', 'class')->get(['name']);
        $scales = Content::query()->where('type', 'scale')->get(['name']);
        return $this->view->render($response, '/disasters/cases/edit.twig', [
            'params' => $params,
            'disaster' => $disaster,
            'classes' => $classes,
            'scales' => $scales
        ]);
    }

    public function store(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        $params->post->disaster->season = implode(',', $params->post->disaster->season);

        $disaster = new Disaster();
        $disaster->fill(json_decode(json_encode($params->post->disaster), true));

        if($disaster->save()){
            $coordinates = [];
            foreach($params->post->disaster->coordinates as $key => $value){
                $coordinate = new DisasterCoordinate();
                $coordinate->fill(json_decode(json_encode($value), true));
                $coordinates[] = $coordinate;
            }
            $disaster->coordinates()->saveMany($coordinates);
            $this->flash->addMessage('notice', '登録が完了しました．');
            return $response->withRedirect($this->router->pathFor('disaster_index', [], []));
        }else{
            $this->flash->addMessage('error', '登録に失敗しました．');
            return $response->withRedirect($this->router->pathFor('disaster_create', [], [
                'params' => $params,
            ]));
        }
    }

    public function update(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');

        $params->post->disaster->season = implode(',', $params->post->disaster->season); // チェックボックスで入力されたデータをCSVにする
        $disaster = Disaster::find($args['disasterId']);
        if($disaster->update(json_decode(json_encode($params->post->disaster), true))){
            $this->flash->addMessage('notice', '更新が完了しました．');
            return $response->withRedirect($this->router->pathFor('disaster_index', [], []));
        }else{
            $this->flash->addMessage('error', '更新に失敗しました．');
            return $response->withRedirect($this->router->pathFor('disaster_edit', [], [
                'params' => $params,
                'disasterId' => $args['disasterId'],
            ]));
        }
    }

    public function delete(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $disaster = Disaster::find($args['disasterId']);

        if($disaster->delete()){
            $this->flash->addMessage('notice', '削除が完了しました．');
        }else{
            $this->flash->addMessage('error', '削除に失敗しました．');
        }

        return $response->withRedirect($this->router->pathFor('disaster_index', [], [
            'params' => $params,
        ]));
    }

    public function select(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $disasters = Disaster::query()->get();

        return $this->view->render($response, '/disasters/cases/select.twig', [
            'disasters' => $disasters,
            'params' => $params
        ]);
    }
}
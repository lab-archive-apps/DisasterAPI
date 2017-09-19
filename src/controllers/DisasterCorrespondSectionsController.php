<?php

namespace App\Controller;

use App\Models\DisasterCorrespondSection as Section;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/* Disaster Correspond Sections Management Controller */
class DisasterCorrespondSectionsController extends BaseController {

    public function index(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $sections = Section::query()->get();

        return $this->view->render($response, '/disasters/sections/index.twig', [
            'params' => $params,
            'sections' => $sections
        ]);
    }

    public function create(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        return $this->view->render($response, '/disasters/sections/create.twig', [
            'params' => $params,
        ]);
    }

    public function show(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $section = Section::find($args['sectionId']);
        return $this->view->render($response, '/disasters/sections/show.twig', [
            'params' => $params,
            'section' => $section
        ]);
    }

    public function edit(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $section = Section::find($args['sectionId']);
        return $this->view->render($response, '/disasters/sections/edit.twig', [
            'params' => $params,
            'section' => $section
        ]);
    }

    public function store(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $section = new Section();
        $section->fill(json_decode(json_encode($params->post->section), true));
        if($section->save()){
            $this->flash->addMessage('notice', '登録が完了しました．');
            return $response->withRedirect($this->router->pathFor('section_index', [], []));
        }else{
            $this->flash->addMessage('error', '登録に失敗しました．');
            return $response->withRedirect($this->router->pathFor('section_create', [], [
                'params' => $params,
            ]));
        }
    }

    public function update(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
    }

    public function delete(Request $request, Response $response, $args){
        $params = $request->getAttribute('params');
        $section = Section::find($args['sectionId']);
        if($section->delete()){
            $this->flash->addMessage('notice', '削除が完了しました．');
        }else{
            $this->flash->addMessage('error', '削除に失敗しました．');
        }

        return $response->withRedirect($this->router->pathFor('disaster_index', [], [
            'params' => $params,
        ]));
    }
}
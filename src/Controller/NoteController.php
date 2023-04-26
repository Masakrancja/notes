<?php

declare(strict_types=1);
namespace App\Controller;

use App\Exception\NotFoundException;
class NoteController extends AbstractController
{
    public function createAction()
    {
        if ($this->request->hasPost()) {
            $noteData = ['title' => $this->request->postParam('title'), 'description' => $this->request->postParam('description')];
            $this->database->createNote($noteData);
            $this->redirect('/', ['before', 'create']);
        }
        $this->view->render('create');
    }

    public function showAction()
    {
        $noteId = (int) $this->request->getParam('id');
        if (!$noteId) {
            $this->redirect('/', ['error', 'noteNotFound']);
        }
        try {
            $note = $this->database->getNote($noteId);
        } catch (NotFoundException $e) {
            $this->redirect('/', ['error', 'noteNotFound']);
        }
        $this->view->render(
            'show', 
            ['note' => $note]
        );
    }

    public function listAction()
    {
        $this->view->render(
            'list', 
            [
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam('error'),
                'notes' => $this->database->getNotes()
            ]
        );
    }

    public function editAction()
    {
        $noteId = (int) $this->request->getParam('id');
        if (!$noteId) {
            $this->redirect('/', ['error', 'noteNotFound']);
        }
        $this->view->render(
            'edit',
            []
        );
    }

}
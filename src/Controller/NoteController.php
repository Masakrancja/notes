<?php

declare(strict_types=1);
namespace App\Controller;

use App\Exception\NotFoundException;
class NoteController extends AbstractController
{
    public function createAction(): void
    {
        if ($this->request->hasPost()) {
            $noteData = 
                [
                    'title' => $this->request->postParam('title'), 
                    'description' => $this->request->postParam('description')
                ];
            $this->database->createNote($noteData);
            $this->redirect('/', ['before' => 'create']);
        }
        $this->view->render('create');
    }

    public function showAction(): void
    {
        $this->view->render(
            'show', 
            ['note' => $this->getNote()]
        );
    }

    public function listAction(): void
    {
        $orderBy = $this->request->getParam('sortby', 'title');
        $sortOrder = $this->request->getParam('sortorder', 'desc');
        $this->view->render(
            'list', 
            [
                'sort' => 
                    [
                        'by' => $orderBy,
                        'order' => $sortOrder 
                    ],
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam('error'),
                'notes' => $this->database->getNotes($orderBy, $sortOrder)
            ]
        );
    }

    public function editAction(): void
    {
        if ($this->request->isPost()) {
            $noteId = (int) $this->request->postParam('id');
            $noteData = [
                'title' => $this->request->postParam('title'), 
                'description' => $this->request->postParam('description')
            ];
            $this->database->editNote($noteId, $noteData);
            $this->redirect('/', ['before' => 'edited']);
        }
        $this->view->render('edit', ['note' => $this->getNote()]);
    }

    public function deleteAction(): void
    {
        if ($this->request->isPost()) {
            $noteId = (int) $this->request->postParam('id');
            $this->database->deleteNote($noteId);
            $this->redirect('/', ['before' => 'deleted']);
        }
        $note = $this->getNote();
        $this->view->render('delete', ['note' => $this->getNote()]);
    }

    private function getNote(): array
    {
        $noteId = (int) $this->request->getParam('id');
        if (!$noteId) {
            $this->redirect('/', ['error', 'noteNotFound']);
        }
        try {
            return $this->database->getNote($noteId);
        } catch (NotFoundException $e) {
            $this->redirect('/', ['error', 'noteNotFound']);
        }
    }

}
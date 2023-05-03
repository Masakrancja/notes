<?php

declare(strict_types=1);
namespace App\Controller;

class NoteController extends AbstractController 
{
    private const DEFAULT_PAGE_SIZE = 10;
    public function createAction(): void
    {
        if ($this->request->hasPost()) {
            $noteData = 
                [
                    'title' => $this->request->postParam('title'), 
                    'description' => $this->request->postParam('description')
                ];
            $this->noteModel->create($noteData);
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
        $pageSize = (int) $this->request->getParam('size', self::DEFAULT_PAGE_SIZE);
        $pageNumber = (int) $this->request->getParam('page', 1);
        $orderBy = $this->request->getParam('sortby', 'title');
        $sortOrder = $this->request->getParam('sortorder', 'desc');
        $phrase = $this->request->getParam('phrase');

        if (!in_array($pageSize, [1, 5, 10, 25])) {
            $pageSize = self::DEFAULT_PAGE_SIZE;
        }

        if ($phrase) {
            $note = $this->noteModel->search($pageNumber, $pageSize, $orderBy, $sortOrder, $phrase);
            $pages = (int) ceil($this->noteModel->searchCount($phrase) / $pageSize);
        } else {
            $note = $this->noteModel->list($pageNumber, $pageSize, $orderBy, $sortOrder);
            $pages = (int) ceil($this->noteModel->count() / $pageSize);
        }

        $this->view->render(
            'list', 
            [
                'paging' =>
                    [
                        'size' => $pageSize,
                        'page' => $pageNumber,
                        'pages' => $pages,
                        'phrase' => $phrase
                    ],
                'sort' => 
                    [
                        'by' => $orderBy,
                        'order' => $sortOrder 
                    ],
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam('error'),
                'notes' => $note
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
            $this->noteModel->edit($noteId, $noteData);
            $this->redirect('/', ['before' => 'edited']);
        }
        $this->view->render('edit', ['note' => $this->getNote()]);
    }

    public function deleteAction(): void
    {
        if ($this->request->isPost()) {
            $noteId = (int) $this->request->postParam('id');
            $this->noteModel->delete($noteId);
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
        return $this->noteModel->get($noteId);
    }

}
<div class="show">
    <?php $note = $params['note'] ?? null; ?>
    <?php if ($note): ?>
        <ul>
            <li>Tytuł: <?php echo $note['title']; ?></li>
            <li>Opis: <?php echo $note['description']; ?></li>
        </ul>
    <?php else: ?>
        <div>Brak notatki do wyświetlenia</div>
    <?php endif; ?>
    <a href="/?action=edit&id=<?php echo $note['id']; ?>">
        <button>Edycja</button>
    </a>
    <a href="/">
        <button>Powrót do listy notatek </button>
    </a>
</div>

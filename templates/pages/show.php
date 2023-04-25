<div class="show">
    <?php $note = $params['note'] ?? null; ?>
    <?php if ($note): ?>
        <ul>
            <li>Tytuł: <?php echo htmlentities($note['title']); ?></li>
            <li>Opis: <?php echo htmlentities($note['description']); ?></li>
        </ul>
    <?php else: ?>
        <div>Brak notatki do wyświetlenia</div>
    <?php endif; ?>
    <a href="/">
        <button>Powrót do listy notatek </button>
    </a>
</div>

<div class="show">
    <?php $note = $params['note'] ?? null; ?>
    <?php if ($note): ?>
        <ul>
            <li>Tytuł: <?php echo $note['title']; ?></li>
            <li>Opis: <?php echo $note['description']; ?></li>
        </ul>
        <form name="my_form" method="POST" action="/?action=delete">
            <input type="hidden" name="id" value="<?php echo $note['id']; ?>">
            <input type="submit" value="Usuń">
        </form>
    <?php else: ?>
        <div>Brak notatki do wyświetlenia</div>
    <?php endif; ?>
    <a href="/">
        <button>Powrót do listy notatek </button>
    </a>
</div>
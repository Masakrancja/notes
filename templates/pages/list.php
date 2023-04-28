<div class="list">
  <section>
    <div class="message">
      <?php
      if (!empty($params['error'])) {
        switch ($params['error']) {
          case 'missingNoteId':
            echo 'Niepoprawny identyfikator notatki';
            break;
          case 'noteNotFound':
            echo 'Notatka nie została znaleziona';
            break;
        }
      }
      ?>
    </div>

    <?php
      $sort = $params['sort'] ?? [];
      $by = $sort['by'] ?? 'title';
      $order = $sort['order'] ?? 'desc';
    ?>

    <div class="settings-form">
      <form action="/" method="GET">
        <div>Sortuj po:</div>
        <div>
          <label>Tytule <input type="radio" name="sortby" value="title" <?php echo $by === 'title' ? 'checked' : ''; ?>/></label>
          <label>Dacie <input type="radio" name="sortby" value="created" <?php echo $by === 'created' ? 'checked' : ''; ?>/></label>
        </div>
        <div>Kolejność sortowania</div>
        <div>
          <label>Rosnąca <input type="radio" name="sortorder" value="asc" <?php echo $order === 'asc' ? 'checked' : ''; ?>/></label>
          <label>Malejąca <input type="radio" name="sortorder" value="desc" <?php echo $order === 'desc' ? 'checked' : ''; ?>/></label>
        </div>
        <input type="submit" value="Wybierz">
      </form>
    </div>

    <div class="message">
      <?php
      if (!empty($params['before'])) {
        switch ($params['before']) {
          case 'created':
            echo 'Notatka zostało utworzona';
            break;
          case 'edited':
            echo 'Notatka została zaktualizowana';
            break;
          case 'deleted':
            echo 'Notatka została usunięta';
            break;
        }
      }
      ?>
    </div>

    <div class="tbl-header">
      <table cellpadding="0" cellspacing="0" border="0">
        <thead>
          <tr>
            <th>Id</th>
            <th>Tytuł</th>
            <th>Data</th>
            <th>Opcje</th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="tbl-content">
      <table cellpadding="0" cellspacing="0" border="0">
        <tbody>
          <?php foreach ($params['notes'] ?? [] as $note) : ?>
            <tr>
              <td><?php echo $note['id'] ?></td>
              <td><?php echo $note['title'] ?></td>
              <td><?php echo $note['created'] ?></td>
              <td>
                <a href="/?action=show&id=<?php echo $note['id'] ?>">
                  <button>Szczegóły</button>
                </a>
                <a href="/?action=delete&id=<?php echo $note['id'] ?>">
                  <button>Usuń</button>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>
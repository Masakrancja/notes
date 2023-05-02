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
      $paging = $params['paging'] ?? [];
      $page = $paging['page'] ?? 1;
      $size = $paging['size'] ?? self::DEFAULT_PAGE_SIZE;
      $pages = $paging['pages'] ?? 1;
      $phrase = $paging['phrase'] ?? null;
    ?>

    <div class="settings-form">
      <form action="/" method="GET">
        <div><label>Szukaj: <input type="text" name="phrase" value="<?php echo $phrase; ?>"/></label></div>
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

        <div>Rozmiar paczki</div>
        <div>
          <label>1<input type="radio" name="size" value="1" <?php echo $size === 1 ? 'checked' : '' ?>/></label>
          <label>5<input type="radio" name="size" value="5" <?php echo $size === 5 ? 'checked' : '' ?>/></label>
          <label>10<input type="radio" name="size" value="10" <?php echo $size === 10 ? 'checked' : '' ?>/></label>
          <label>25<input type="radio" name="size" value="25" <?php echo $size === 25 ? 'checked' : '' ?>/></label>
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
    <div>
      <ul class="pagination">
        <?php 
          $paginationUrl = '/?phrase=' . $phrase . '&sortby=' . $by . '&sortorder=' . $order . '&size=' . $size;
        ?>
        <?php if($page !== 1): ?>
          <li>
            <a href="<?php echo $paginationUrl; ?>&page=<?php echo $page - 1; ?>">
              <button><<</button>
            </a>
          </li>
        <?php endif; ?>
        <?php for($i=1; $i<=$pages; $i++): ?>
          <li>
            <a href="<?php echo $paginationUrl; ?>&page=<?php echo $i; ?>">
              <button><?php echo $i; ?></button>
            </a>
          </li>
        <?php endfor; ?>
        <?php if ($page < $pages): ?>
          <li>
            <a href="<?php echo $paginationUrl; ?>&page=<?php echo $page + 1; ?>">
              <button>>></button>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </section>
</div>
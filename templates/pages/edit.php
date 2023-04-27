<h2>Edytuj</h2>
<div>
    <?php if(!empty($params['note'])): ?>
        <form class="note-form" action="/?action=edit" method="post">
            <ul>
                <li>
                    <label>Tytuł <span class="required">*</span></label>
                    <input type="text" value="<?php echo $params['note']['title']; ?>" name="title" class="field-long" />
                </li>
                <li>
                    <label>Treść</label>
                    <textarea name="description" id="field5" class="field-long field-textarea"><?php echo $params['note']['description']; ?></textarea>
                </li>
                <li>
                    <input type="hidden" name="id" value="<?php echo $params['note']['id']; ?>">
                    <input type="submit" value="Submit" />
                </li>
            </ul>
        </form>
    <?php else: ?>
        Brak notatki do wyświetlenia
        <a href="/">
            <button>Potwrót</button>
        </a>
    <?php endif; ?>
</div>

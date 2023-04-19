<h2>Utwórz</h2>
<div>
    <?php if ($params['created']): ?>
        <div>Tytuł: <?php echo $params['title']; ?></div>
        <div>Opis: <?php echo $params['description']; ?></div>
    <?php else: ?>
        <form class="note-form" action="/?action=create" method="post">
            <ul>
                <li>
                    <label>Tytuł <span class="required">*</span></label>
                    <input type="text" name="title" class="field-long" />
                </li>
                <li>
                    <label>Treść</opis>
                    <textarea name="description" id="field5" class="field-long field-textarea"></textarea>
                </li>
                <li>
                    <input type="submit" value="Submit" />
                </li>
            </ul>
        </form>
    <?php endif ?>
</div>

<h2>Lista</h2>

<div class="message">
    <?php if($params['before']):
        switch ($params['before']) 
        {
            case 'create':
                echo 'Notatka została utworzona';
            break;
        }
    endif ?>
</div>
<b><?php echo $params['actionList'] ?? ''; ?></b>

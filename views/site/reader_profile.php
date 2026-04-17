<div class="container-card">
    <div class="card readers">
        <h2 class="title">Читательский билет: <?= $reader->card_number ?></h2>
        
        <div class="reader-info">
            <p>ФИО: <?= htmlspecialchars($reader->last_name . ' ' . $reader->first_name . ' ' . $reader->middle_name) ?></p>
            <p>Телефон: <?= htmlspecialchars($reader->phone_number) ?></p>
            <p>Адрес: <?= htmlspecialchars($reader->address) ?></p>
        </div>
        
        <div class="readers-list">
            <?php if (count($loans) > 0): ?>
                <?php foreach ($loans as $loan): ?>
                    <div class="reader-item">
                        <a href="<?= app()->route->getUrl('/books/' . $loan->id_book) ?>">
                            <?= htmlspecialchars($loan->book->title) ?>
                        </a>
                        <?php if ($loan->id_status_loan == 1): ?>
                            <div class="reader-right">
                                <a href="#" class="btn-return">Вернуть</a>
                                <span class="status-active">Активен</span>
                            </div>
                        <?php elseif ($loan->id_status_loan == 3): ?>
                            <span class="status-overdue">Просрочена</span>
                        <?php else: ?>
                            <span class="status-inactive">Возвращена</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="user-info">У читателя нет книг</div>
            <?php endif; ?>
        </div>
    </div>
    <a href="<?= app()->route->getUrl('/readers') ?>" class="btn-link">Назад к читателям</a>
</div>
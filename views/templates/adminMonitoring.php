<?php
/**
 * Update SH - Ajout nouveau template
 * Tableau de monitoring des articles :
 * - Titre
 * - Vues
 * - Nombre de commentaires
 * - Date de publication
 * - Tri ASC/DESC via liens
 */
?>

<h2>Monitoring des articles</h2>

<table class="monitoring-table">
    <thead>
        <tr>
            <th>
                <a href="index.php?action=showMonitoring&sort=title&dir=<?= $direction === 'ASC' ? 'DESC' : 'ASC' ?>">
                    Titre
                    <?= $sort === 'title' ? ($direction === 'ASC' ? '▲' : '▼') : '' ?>
                </a>
            </th>
            <th>
                <a href="index.php?action=showMonitoring&sort=views&dir=<?= $direction === 'ASC' ? 'DESC' : 'ASC' ?>">
                    Vues
                    <?= $sort === 'views' ? ($direction === 'ASC' ? '▲' : '▼') : '' ?>
                </a>
            </th>
            <th>
                <a href="index.php?action=showMonitoring&sort=comment_count&dir=<?= $direction === 'ASC' ? 'DESC' : 'ASC' ?>">
                    Commentaires
                    <?= $sort === 'comment_count' ? ($direction === 'ASC' ? '▲' : '▼') : '' ?>
                </a>
            </th>
            <th>
                <a href="index.php?action=showMonitoring&sort=date_creation&dir=<?= $direction === 'ASC' ? 'DESC' : 'ASC' ?>">
                    Date de publication
                    <?= $sort === 'date_creation' ? ($direction === 'ASC' ? '▲' : '▼') : '' ?>
                </a>
            </th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($articles as $index => $article): ?>
            <tr class="<?= $index % 2 === 0 ? 'row-even' : 'row-odd' ?>">
                <td><?= htmlspecialchars($article->getTitle(), ENT_QUOTES) ?></td>
                <td><?= $article->getViews() ?></td>
                <td><?= $article->getCommentCount() ?></td>
                <td><?= $article->getDateCreation()->format('d/m/Y H:i') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- <div class="monitoring-actions"> -->
<div class="admin-buttons">
    <a class="submit" href="index.php?action=admin">⬅ Retour à l’administration</a>
</div>
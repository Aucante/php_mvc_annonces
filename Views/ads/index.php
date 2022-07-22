<p>Page accueil des annonces : </p>
<?php foreach ($ads as $ad): ?>
    <article>
        <p><a href="/ads/read/<?= $ad->id ?>"><?= $ad->title ?></a></p>
        <p><?= $ad->description ?></p>
    </article>
    <a href="/ads/update/<?= $ad->id ?>" class="btn btn-primary">Modifier</a>
<?php endforeach; ?>
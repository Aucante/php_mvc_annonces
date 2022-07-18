<p>Page accueil des annonces : </p>
<?php foreach ($ads as $ad): ?>
    <article>
        <p><a href="/ads/read/<?= $ad->id ?>"><?= $ad->title ?></a></p>
        <p><?= $ad->description ?></p>
    </article>
<?php endforeach; ?>
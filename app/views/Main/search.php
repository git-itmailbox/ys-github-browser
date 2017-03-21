<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $item): ?>

                    <div class="rounded-container">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="/repo/<?= $item->owner->login ?>/<?= $item->name ?>"><?= $item->name ?></a>
                            </div>
                            <div class="col-md-7">
                                <a href="<?= $item->homepage ?>"><?= $item->homepage ?></a>

                            </div>
                            <div class="col-md-2">
                                <a href="/user/<?= $item->owner->login ?>"><?= $item->owner->login ?></a>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    <?= $item->description ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                watchers: <?= $item->watchers ?>
                            </div>
                            <div class="col-md-4">
                                forks: <?= $item->forks ?>
                            </div>

                            <div class="col-md-4">
                                <button class="btn btn-sm">Like</button>
                                <button class="btn btn-sm">UnLike</button>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>

        </div>

    </div>
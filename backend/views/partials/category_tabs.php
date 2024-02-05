<?php
    use yii\helpers\Url;
?>

<!--list-topics start -->
<section id="list-topics" class="list-topics">
    <div class="container">
        <div class="list-topics-content">
            <ul>
                <?php foreach($categories as $category): ?>
                    <li>
                        <div class="single-list-topics-content">
                            <div class="single-list-topics-icon">
                                <i class="flaticon-restaurant"></i>
                            </div>
                            <h2><a href="
                                <?= Url::toRoute(['site/category', 'id' => $category->id]) ?>
                                "><?= $category->title; ?></a></h2>
                            <p><?= $category->getArticlesCount(); ?> listings</p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div><!--/.container-->
</section>
<!--/.list-topics-->
<!--list-topics end-->
<?php
    use yii\helpers\Url;
    use yii\widgets\LinkPager;
?>

<!--blog start -->
<section id="blog" class="blog" >
    <div class="container">
        <div class="section-header">
            <h2>news and articles</h2>
            <p>Always upto date with our latest News and Articles </p>
        </div><!--/.section-header-->
        <div class="blog-content">
            <div class="row">
                <?php foreach ($articles as $article): ?>
                 
                    <div class="col-md-12 col-sm-4">
                        <div class="single-blog-item">
                            <div class="single-blog-item-img">
                                <img src="<?= $article->getImage(); ?>" alt="blog image">
                            </div>
                            <div class="single-blog-item-txt">
                                <h2>
                                    <a href="
                                    <?= Url::toRoute(['site/view', 'id' => $article->id]) ?>
                                    "><?= $article->title; ?>
                                    </a>
                                </h2>
                                <h4>
                                    <a href="
                                    <?= 
                                        ($article->category != NULL) ?
                                        Url::toRoute(['site/category', 'id' => $article->category->id]) : 
                                        '#'
                                    ?>
                                    "><?= ($article->category != NULL) ? $article->category->title : "no category"; ?>
                                    </a> 
                                    Viewed: <?= $article->viewed; ?>
                                </h4>
                                <h4>posted <span>by</span> <a href="#"><!--?= $article->user->name; ?--></a> <?= $article->getDate(); ?></h4>
                                <p>
                                    <?= $article->description; ?>
                                </p>
                            </div>
                        </div>
                    </div>


                <?php endforeach; ?>
            </div>
        </div>
        <div style="margin:0 auto;">
            <?php

                echo LinkPager::widget([
                    'pagination' => $pages,
                ]);

            ?>
        </div>
    </div><!--/.container-->
</section>
<!--/.blog-->
<!--blog end -->

<?= $this->render('/partials/category_tabs', ['categories' => $categories]) ?>
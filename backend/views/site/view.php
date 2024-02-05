<?php
    use yii\helpers\Url;
?>

<!--popular articles start -->
<section id="blog" class="blog" >
    <div class="container">
        <div class="section-header">
            <h2><?= $article->title; ?></h2>
        </div><!--/.section-header-->
        <div class="blog-content">
            <div class="single-blog-item">
                <div class="single-blog-item-img">
                    <img src="<?= $article->getImage(); ?>" alt="blog image">
                </div>
                <div class="single-blog-item-txt">
                    <h2><a href="
                        <?= 
                        ($article->category != NULL) ?
                        Url::toRoute(['site/view', 'id' => $article->category->id]) : '#' ?>
                        "><?= $article->title; ?></a></h2>
                    <h4><a href="
                        <?= 
                            ($article->category != NULL) ?
                            Url::toRoute(['site/category', 'id' => $article->category->id]) : 
                            '#'
                        ?>
                        "><?= ($article->category != NULL) ? $article->category->title : "no category"; ?></a> Viewed: <?= $article->viewed; ?></h4>
                    <h4>posted <span>by</span> <a href="#"><?= $article->user->name; ?></a> <?= $article->getDate(); ?></h4>
                    <p>
                        <?= $article->content; ?>
                    </p>
                </div>
            </div>

            <?= $this->render('/partials/comment_form', [
                                'article' => $article,
                                'comments' => $comments,
                                'commentForm' => $commentForm,
                                ]) ?>

        </div>
    </div><!--/.container-->
</section>
<!--/.blog-->

<?= $this->render('/partials/category_tabs', ['categories' => $categories]) ?>
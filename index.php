<?php
$result_block = false;
if (filter_input(INPUT_POST, 'article_one') && filter_input(INPUT_POST, 'article_two')) {
    require_once 'functions.php';
    $result_block = true;
}
$article_one = filter_input(INPUT_POST, 'article_one') ?: "First string. Second\n string. It's third string! Is it awesome?";
$article_two = filter_input(INPUT_POST, 'article_two') ?: "Woww! It's zero string! First string. Second modified string. It's third string!";
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>The texts difference</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <form method="post">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="article_one">Article 1</label>
                            <textarea 
                                class="form-control" 
                                id="article_one" 
                                rows="15" 
                                name="article_one"><?= $article_one; ?></textarea>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="article_two">Article 2</label>
                            <textarea 
                                class="form-control" 
                                id="article_two" 
                                rows="15" 
                                name="article_two"><?= $article_two; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Compare</button>
                    </div>
                </div>
            </form>
        </div>
        <?php if ($result_block) : ?>
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <h1>The difference between the two texts</h1>
                        <div class="result" id="result">
                            <?= mainDiff($article_one, $article_two); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
        <script>
            $(function () {
                $('.replaced').hide();
                $('.new').click(function () {
                    var idspan = $(this).attr('data-id');
                    $("#r-" + idspan).show();
                    $("#n-" + idspan).hide();
                });
                $('.replaced').mouseout(function () {
                    var idspan = $(this).attr('data-id');
                    $("#r-" + idspan).hide();
                    $("#n-" + idspan).show();
                });
            });
        </script>
    </body>
</html>


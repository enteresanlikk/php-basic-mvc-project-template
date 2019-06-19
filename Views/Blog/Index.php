<?php
    use App\Helpers\Html;
?>

<div class="container">
    <div class="row">
        <?php
        foreach ($this->Model as $item) {
            Html::partial("_Item", $item);
        }
        ?>
    </div>
</div>
<?php
if (isset($success)) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $success ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
if (isset($failure)) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $failure ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
if (isset($img_error)) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $img_error ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}




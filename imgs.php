<?php
if (count($_FILES) > 0) {
    $uploadFile = $_FILES['img']['tmp_name'];

    if (!preg_match("/\.(gif|png|jpg|jpeg)$/", $uploadFile)) {
        die('Загружена не картинка');
    }

    $info = getimagesize($uploadFile);
    $width = $info[0];
    $height = $info[1];
    $type = $info[2];
    $middle = $width / 2;

    switch ($type) {
        case 1:
            $img = imageCreateFromGif($uploadFile);
            imageSaveAlpha($img, true);
            break;
        case 2:
            $img = imageCreateFromJpeg($uploadFile);
            break;
        case 3:
            $img = imageCreateFromPng($uploadFile);
            imageSaveAlpha($img, true);
            break;
    }

    $tmp = imageCreateTrueColor($middle, $height);
    imagecopy($tmp, $img, 0, 0, 0, 0, $middle, $height);
    imageflip($tmp, IMG_FLIP_HORIZONTAL);
    imagecopymerge($img, $tmp, $middle, 0, 0, 0, $width, $height, 100);

    imagePng($img, './result.png');
    imagedestroy($img);
}
?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <img src="./result.png">
<?php else: ?>
    <form enctype="multipart/form-data" method="POST">
        <input name="img" type="file"/>
        <input type="submit" value="Загрузить картинку"/>
    </form>
<?php endif; ?>

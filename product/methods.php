<?php



function upload_image($file_name = 'image', $default_path = null)
{
    //  upload image
    $image = $_FILES[$file_name] ?? null;
    $image_path = $default_path;
    $images_type = ['image/jpeg', 'image/png', 'image/jpg'];

    if ($image && $image['tmp_name'] && in_array($image['type'], $images_type))
    {
        $image_path = 'images/' . time() . '_' . $image['name'];
        mkdir(dirname($image_path));
        move_uploaded_file($image['tmp_name'], $image_path);
    }
    // end upload image

    return $image_path;
}

<?php

namespace Admin;

class Admin
{
    protected function redirect(string $url)
    {
        header("Location: " . (trim(BASE_URL, '/ ') . '/' . trim($url, '/ ')));
        die;
    }

    protected function redirectBack()
    {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        die;
    }

    protected function saveImage(
        array $image,
        string $imagePath,
        ?string $imageName = null
    ): string|bool {
        $extension = explode('/', $image['type'])[1];

        if ($imageName) {
            $imageName = $imageName . '.' . $extension;
        } else {
            $imageName = date('Y-m-d-H-i-s') . '.' . $extension;
        }

        $imageTemp = $image['tmp_name'];
        $imagePath = 'public/' . trim($imagePath, '/ ') . '/' . $imageName;

        if (is_uploaded_file($imageTemp)) {
            if (move_uploaded_file($imageTemp, $imagePath)) {
                return $imagePath;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    protected function removeImage(
        string $path
    ): bool {

        $path = BASE_PATH . '/' . trim($path, '/ ');

        if (file_exists($path)) {
            unlink($path);
            return true;
        }
        return false;
    }
}

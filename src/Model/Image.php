<?php


namespace App\Model;


use App\Config;

class Image
{
    /*** @var HasImage */
    private $hasImage;
    private $class;
    private $errors = [];

    const FIELD_PREFIX = 'img_';

    public function __construct(HasImage $hasImage)
    {
        $this->hasImage = $hasImage;
        $this->class = strtolower($this->getClassName());
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function save(): bool
    {
        $uploadedFile = $this->getLoadedFile(self::FIELD_PREFIX . $this->class);

        if (! ($uploadedFile && $this->isImage($uploadedFile['tmp_name']) && $this->checkSize($uploadedFile['size']))) {
            return false;
        }

        $fileName = $this->generateFileName($uploadedFile);
        if (file_exists($destination = ($this->getFullFolder() . $fileName)) && ! $this->checkFile($destination)) {
            return false;
        }

        if (! move_uploaded_file($uploadedFile['tmp_name'], $destination)) {
            $this->setError('Ошибка при сохранении файла на сервер');
            return false;
        }

        if ($fileName != $this->getHasImage()->getImageName()) {
            $this->delete();
        }

        $this->getHasImage()->addImage($fileName);

        return true;
    }

    public function delete(): bool
    {
        if ($imageName = $this->getHasImage()->getImageName()) {
            if (! $this->deleteFile($this->getFullFolder() . $imageName)) {
                return false;
            }
            $this->getHasImage()->deleteImage();
        }
        return true;
    }

    private function getClassName(): string
    {
        if ($pos = strrpos($className = get_class($this->hasImage), '\\')) {
            $className = substr($className, $pos + 1);
        }

        return $className;
    }

    private function getHasImage(): HasImage
    {
        return $this->hasImage;
    }

    private function getLoadedFile(string $inputName): ?array
    {
        if (empty($_FILES[$inputName])) {
            $this->setError('Файл не выбран');
            return null;
        }

        $file = $_FILES[$inputName];

        if (! empty($file['error'])) {
            $this->setError('Ошибка при загрузке файла на сервер');
            return null;
        }

        return $file;
    }

    private function setError($error): void
    {
        $this->errors[] = $error;
    }

    private function generateFileName(array $fileArray): string
    {
        return $this->getHasImage()->getId() . '_' . rand(10000, 99999) . '.' . $this->getFileExtension($fileArray['name']);
    }

    private function isImage($file): bool
    {
        if (! exif_imagetype($file)) {
            $this->setError('Файл не является изображением');
            return false;
        }
        return true;
    }

    private function checkSize(int $fileSize): bool
    {
        if (($size = Config::getInstance()->get('image.' . $this->class . '_size')) && $fileSize > $size) {
            $this->setError('Файл не должен превышать ' . round($size / (1024 * 1024)) .' Мб');
            return false;
        }
        return true;
    }

    private function deleteFile(string $file): bool
    {
        if (! file_exists($file)) {
            return true;
        }

        if (! $this->checkFile($file)) {
            return false;
        }

        if (! unlink($file)) {
            $this->setError('Ошибка при удалении файла. Обратитетсь к Администратору.');
            return false;
        }

        return true;
    }

    private function checkFile(string $destination): bool
    {
        if ( ! is_writable($destination)) {
            $this->setError('Ошибка работе с файлом. Обратитетсь к Администратору.');
            return false;
        }

        return true;
    }

    private function getFileExtension(string $fileName): string
    {
        $arr = explode('.', $fileName);
        return array_pop($arr);
    }

    private function getFullFolder(): string
    {
        return Config::getInstance()->get('image.folder') . $this->class . '/';
    }
}
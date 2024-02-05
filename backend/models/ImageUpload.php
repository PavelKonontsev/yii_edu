<?php


namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model {

    public $image;

    public function rules() {
        return [
            [['image'], 'required'],
            [['image'], 'file', 'extensions' => 'jpg,jpeg,png,bmp'],
        ];
    }

    public function uploadFile(UploadedFile $file, $currentImage)
    {   
        $this->image = $file;

        if ($this->validate()) {
            $this->deleteCurrentImage($currentImage);
            $filename = $this->generateFilename();
            $file->saveAs($this->getFullPath($filename));
            
            return $filename;
        }
    }

    public function getFullPath($filename) {
        return Yii::getAlias('@web') . 'uploads/' . $filename;
    }

    private function generateFilename() {
        return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
    }

    public function deleteCurrentImage($currentImage) {
        $currentImagePath = $this->getFullPath($currentImage);
        


        if (!empty($currentImagePath) && $currentImagePath != NULL && $this->fileExists($currentImagePath)) {
            unlink($currentImagePath);
        }
    }

    private function fileExists($filepath) {
        return (file_exists($filepath) && is_file($filepath));
    }

}
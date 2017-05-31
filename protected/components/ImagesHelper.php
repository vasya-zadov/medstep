<?php

/**
 * Создает превью изображений заданного размера и накладывает маску
 *
 * @author AlexLcDee <lcdee@yandex.ru>
 */
class ImagesHelper
{
    private static $_instance;
    private $imageName;
    private $imagePath;
    private $imageSize;

    /**
     * Гененирует сжатое изображение
     * @param string $image изображение
     * @param string $mask маска изображения
     * @param array $sizes размеры сжатого изображения
     * 
     * @author AlexLcDee <lcdee@yandex.ru>
     */
    public static function generateImages($image, $mask=false, $sizes)
    {
        $helper = self::_getInstance($image);
        $helper->resize($sizes[0], $sizes[1], $sizes[0].':'.$sizes[1]);
        
        if($mask)
            $helper->imagemask($mask, $sizes[0].'x'.$sizes[1].'_');
    }

    /**
     * Выполнение автоматического ресайза и кропа изображений, создание превью
     * @param integer $maxWidth максимальная ширина
     * @param integer $maxHeight максимальная высота
     * @param string $cropratio соотношения сторон (например 3:2)
     * @param string $prefix префикс имени файла (для ресайза не оригинального изображения)
     * @param boolean $rename сгенерировать имя файла в формате [maxWidth]x[maxHeight]_[fileName]
     * @return null выполнение прерывается, если изображение меньше заданных размеров
     * 
     * @author AlexLcDee <lcdee@yandex.ru>
     */
    private function resize($maxWidth, $maxHeight, $cropratio = '', $prefix = '', $rename = true)
    {
        $fileName = $this->imageName;

        $size = $this->imageSize;

        $width = $size[0];
        $height = $size[1];

        // Read in the original image
        $src = ImageCreateFromJpeg($this->imagePath.'/'.$fileName);

        if($rename)
            $fileName = $maxWidth.'x'.$maxHeight.'_'.$this->imageName;

        if($width < $maxWidth && $height < $maxHeight)
        {
            ImageJpeg($src, $this->imagePath.'/'.$fileName, 100);
            return;
        }

        // Ratio cropping
        list($width, $height, $offsetX, $offsetY) = $this->calculateCrop($cropratio, $width, $height);

        // Setting up the ratios needed for resizing. We will compare these below to determine how to
        // resize the image (based on height or based on width)
        list($tnWidth, $tnHeight) = $this->calculateSizes($width, $height, $maxWidth, $maxHeight);

        // Set up a blank canvas for our resized image (destination)
        $dst = imagecreatetruecolor($tnWidth, $tnHeight);

        // Resample the original image into the resized canvas we set up earlier
        ImageCopyResampled($dst, $src, 0, 0, $offsetX, $offsetY, $tnWidth, $tnHeight, $width, $height);
        ImageJpeg($dst, $this->imagePath.'/'.$fileName, 100);
        chmod($this->imagePath.'/'.$fileName, 0777);
    }

    /**
     * Расчет размеров генерируемого изображения
     * @param type $width ширина изображения
     * @param type $height высота изображения
     * @param type $maxWidth максимальная ширина изображения
     * @param type $maxHeight максимальная высота изображения
     * @return array расчитанные размеры изображения
     * 
     * @author AlexLcDee <lcdee@yandex.ru>
     */
    private function calculateSizes($width, $height, $maxWidth, $maxHeight)
    {
        $xRatio = $maxWidth / $width;
        $yRatio = $maxHeight / $height;

        if($xRatio * $height < $maxHeight)
        { // Resize the image based on width
            $tnHeight = floor($xRatio * $height);
            $tnWidth = $maxWidth;
        }
        else // Resize the image based on height
        {
            $tnWidth = floor($yRatio * $width);
            $tnHeight = $maxHeight;
        }

        return array($tnWidth, $tnHeight);
    }

    /**
     * Расчет смещения для кропа изображения
     * @param type $cropratio соотношения сторон
     * @param type $width ширина изображения
     * @param type $height высота изображения
     * @return array расчитанные смещения для кропа изображения
     * 
     * @author AlexLcDee <lcdee@yandex.ru>
     */
    private function calculateCrop($cropratio, $width, $height)
    {
        $offsetX = 0;
        $offsetY = 0;

        if(!empty($cropratio))
        {
            $cropRatio = explode(':', (string) $cropratio);

            if(count($cropRatio) == 2)
            {
                $ratioComputed = $width / $height;
                $cropRatioComputed = (float) $cropRatio[0] / (float) $cropRatio[1];

                if($ratioComputed < $cropRatioComputed)
                { // Image is too tall so we will crop the top and bottom
                    $origHeight = $height;
                    $height = $width / $cropRatioComputed;
                    $offsetY = ($origHeight - $height) / 2;
                }
                else if($ratioComputed > $cropRatioComputed)
                { // Image is too wide so we will crop off the left and right sides
                    $origWidth = $width;
                    $width = $height * $cropRatioComputed;
                    $offsetX = ($origWidth - $width) / 2;
                }
            }
        }
        return array($width, $height, $offsetX, $offsetY);
    }

    /**
     * Наложение маски на картинку
     * @param string $mask - путь до маски. Поддерживаются форматы: jpg, jpeg, png, gif
     * @param string $prefix - префикс имени файла изображения
     * 
     * @author Vos3k <mail@vostrik.com>
     */
    private function imagemask($mask, $prefix = '')
    {
        $mask = $_SERVER['DOCUMENT_ROOT'].$mask;
        $image = $this->imagePath.'/'.$prefix.$this->imageName;
        // получаем формат картинки
        $arrImg = explode(".", $image);
        $format = (mb_strtolower(end($arrImg)) == 'jpg') ? 'jpeg' : mb_strtolower(end($arrImg));
        $imgFunc = "imagecreatefrom".$format; //определение функции для расширения файла
        // получаем формат маски
        $arrMask = explode(".", $mask);
        $format = (end($arrMask) == 'jpg') ? 'jpeg' : end($arrMask);
        $maskFunc = "imagecreatefrom".$format; //определение функции для расширения файла

        $image = $imgFunc($image); // загружаем картинку
        $mask = $maskFunc($mask); // загружаем маску
        $width = imagesx($image); // определяем ширину картинки
        $height = imagesy($image); // определяем высоту картинки
        $img = imagecreatetruecolor($width, $height); // создаем холст для будущей картинки
        $transColor = imagecolorallocate($img, 0, 0, 0); // определяем прозрачный цвет для картинки. Черный
        imagecolortransparent($img, $transColor); // задаем прозрачность для картинки
        // перебираем картинку по пикселю
        for($posX = 0; $posX < $width; $posX++)
        {
            for($posY = 0; $posY < $height; $posY++)
            {
                $colorIndex = imagecolorat($image, $posX, $posY); // получаем индекс цвета пикселя в координате $posX, $posY для картинки
                $colorImage = imagecolorsforindex($image, $colorIndex); // получаем цвет по его индексу в формате RGB
                $colorIndex = imagecolorat($mask, $posX, $posY); // получаем индекс цвета пикселя в координате $posX, $posY для маски
                $maskColor = imagecolorsforindex($mask, $colorIndex); // получаем цвет по его индексу в формате RGB
                // если в точке $posX, $posY цвет маски не белый, то наносим на холст пиксель с нужным цветом
                if(!($maskColor['red'] == 255 && $maskColor['green'] == 255 && $maskColor['blue'] == 255))
                {
                    $colorIndex = imagecolorallocate($img, $colorImage['red'], $colorImage['green'], $colorImage['blue']); // получаем цвет для пикселя
                    imagesetpixel($img, $posX, $posY, $colorIndex); // рисуем пиксель
                }
            }
        }
        imagepng($img, $this->imagePath.'/'.$prefix.$this->imageName); // вернем изображение
    }

    /**
     * Устанавливает параметры изображения
     * @param string $image
     * 
     * @author AlexLcDee <lcdee@yandex.ru>
     */
    private function setImage($image)
    {
        $fileNameArray = explode('/', $image);
        $this->imageName = $fileNameArray[count($fileNameArray) - 1];
        unset($fileNameArray[count($fileNameArray) - 1]);
        $this->imagePath = $_SERVER['DOCUMENT_ROOT'].implode('/', $fileNameArray);
        $this->imageSize = getimagesize($_SERVER['DOCUMENT_ROOT'].$image);
    }

    # Реализация синглтона
    /**
     * Конструктор
     * @param type $image путь к изображению
     */
    private function __construct($image)
    {
        $this->setImage($image);
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    /**
     * Creates an instance of helper class
     * @param string $image
     * @return ImagesHelper
     */
    private static function _getInstance($image)
    {
        if(self::$_instance === null)
        {
            self::$_instance = new self($image);
        }
        return self::$_instance;
    }
}

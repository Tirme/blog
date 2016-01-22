<?php

namespace App\Support;

use Intervention\Image\Image;

class Exif
{
    public function datetime(Image $image, $format = 'Y-m-d H:i:s')
    {
        $exif = $image->exif();
        $datetime = isset($exif['DateTimeOriginal']) ? $exif['DateTimeOriginal'] : null;
        $datetime = empty($datetime) && isset($exif['DateTimeDigitized']) ? $exif['DateTimeDigitized'] : $datetime;
        $datetime = empty($datetime) && isset($exif['DateTime']) ? $exif['DateTime'] : $datetime;

        return date($format, strtotime($datetime));
    }
    public function make(Image $image)
    {
        $exif = $image->exif();
        $make = isset($exif['Make']) ? $exif['Make'] : '';

        return $make;
    }
    public function model(Image $image)
    {
        $exif = $image->exif();
        $make = isset($exif['Model']) ? $exif['Model'] : '';

        return $make;
    }
    public function shot(Image $image)
    {
        $exif = $image->exif();
        $shot = isset($exif['UndefinedTag:0xA434']) ? $exif['UndefinedTag:0xA434'] : '';

        return $shot;
    }
    public function fNumber(Image $image)
    {
        $exif = $image->exif();
        $f_number = isset($exif['FNumber']) ? $this->formatNumber($exif['FNumber']) : '';

        return $f_number;
    }
    public function exposureTime(Image $image)
    {
        $exif = $image->exif();
        $exposure_time = isset($exif['ExposureTime']) ? $exif['ExposureTime'] : '';

        return $exposure_time;
    }
    public function focalLength(Image $image)
    {
        $exif = $image->exif();
        $focal_ength = isset($exif['FocalLength']) ? $this->formatNumber($exif['FocalLength']) : '';

        return $focal_ength;
    }
    public function iso(Image $image)
    {
        $exif = $image->exif();
        $iso = isset($exif['ISOSpeedRatings']) ? $exif['ISOSpeedRatings'] : '';

        return $iso;
    }
    public function width(Image $image)
    {
        $exif = $image->exif();
        $width = isset($exif['ExifImageWidth']) ? $exif['ExifImageWidth'] : '';

        return $width;
    }
    public function height(Image $image)
    {
        $exif = $image->exif();
        $height = isset($exif['ExifImageLength']) ? $exif['ExifImageLength'] : '';

        return $height;
    }
    public function formatNumber($number)
    {
        $nums = explode('/', $number);
        $result = null;
        if (count($nums) === 2) {
            $result = $nums[0] / $nums[1];
        }

        return $result;
    }
}

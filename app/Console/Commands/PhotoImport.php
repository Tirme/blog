<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\ImageManagerStatic as Image;
use Exif;
use RepositoryFactory;

class PhotoImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photo:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Photo Import';
    const RATIO_16_9 = 1.78;
    const RATIO_4_3 = 1.33;
    const ORIENTATION_LANDSCAPE = 'landscape';
    const ORIENTATION_PORTRAIT = 'portrait';
    protected $resolutions = [
        'large' => 1600,
        'medium' => 1280,
        'small' => 640,
        'tiny' => 320,
    ];
    protected $no_cache = true;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        arsort($this->resolutions);
        $import_path = storage_path('photos/import');
        $glob = glob($import_path.'/*.jpg');
        $total = count($glob);
        $this->log('Start import photos. Amount: '.$total);
        foreach ($glob as $index => $photo_file) {
            $this->log('Process: '.($index + 1).' / '.$total);
            $file_name = basename($photo_file);
            $image = Image::make($photo_file);
            // $store_path = $this->generateThumbnailDirectory($image);
            // $this->generateOriginalImage($image, $store_path, $file_name);
            // $this->generateThumbnailImage($image, $store_path, $file_name);
            $this->store($image, $file_name);
            $this->log('');
        }
    }
    protected function generateThumbnailDirectory($image)
    {
        $date = Exif::datetime($image, 'Y-m-d');
        $store_path = storage_path('photos/'.$date);
        try {
            if (!is_dir($store_path)) {
                mkdir($store_path, 0777, true);
                foreach ($this->resolutions as $resoultion_name => $resoultion) {
                    mkdir($store_path.'/'.$resoultion_name, 0777);
                }
            }
        } catch (\Exception $e) {
            $this->log($e->getMessage());
        }

        return $store_path;
    }
    protected function generateOriginalImage($image, $store_path, $file_name)
    {
        $save_file = $store_path.'/'.$file_name;
        if (!file_exists($save_file) || $this->no_cache) {
            $image->save($save_file);
        }
        $this->log('Save original photo to '.str_replace(storage_path(), '', $save_file));
    }
    protected function generateThumbnailImage($image, $store_path, $file_name)
    {
        $width = $image->width();
        $height = $image->height();
        $this->log('Photo width: '.$width);
        $this->log('Photo height: '.$height);
        $orientation = $width > $height ? static::ORIENTATION_LANDSCAPE : static::ORIENTATION_PORTRAIT;
        if ($orientation === static::ORIENTATION_LANDSCAPE) {
            $ratio = round($width / $height, 2);
        } else {
            $ratio = round($height / $width, 2);
        }
        $this->log('Orientation: '.$orientation);
        foreach ($this->resolutions as $resoultion_name => $resoultion) {
            $save_file = $store_path.'/'.$resoultion_name.'/'.$file_name;
            if (!file_exists($save_file) || $this->no_cache) {
                if ($ratio === static::RATIO_16_9) {
                    $new_width = $orientation === static::ORIENTATION_LANDSCAPE ? $resoultion : ($resoultion / 16) * 9;
                    $new_height = $orientation === static::ORIENTATION_LANDSCAPE ? ($resoultion / 16 * 9) : $resoultion;
                } else {
                    $new_width = $orientation === static::ORIENTATION_LANDSCAPE ? $resoultion : ($resoultion / 4) * 3;
                    $new_height = $orientation === static::ORIENTATION_LANDSCAPE ? ($resoultion / 4 * 3) : $resoultion;
                }
                $this->log('Resize to width: '.$new_width.' height: '.$new_height);
                $image->resize($new_width, $new_height, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $image->save($save_file);
                $this->log('Save to '.(str_replace(storage_path(), '', $save_file)));
            } else {
                $this->log('File exists');
            }
        }
    }
    public function store($image, $file_name)
    {
        $date = Exif::datetime($image, 'Y-m-d');
        $repository = RepositoryFactory::create('Gallery\Photo');
        // dd(json_encode($image->exif()));
        $data = [
            'date' => $date,
            'file_name' => $file_name,
            'make' => Exif::make($image),
            'model' => Exif::model($image),
            'shot' => Exif::shot($image),
            'f_number' => Exif::fNumber($image),
            'exposure_time' => Exif::exposureTime($image),
            'focal_length' => Exif::focalLength($image),
            'iso' => Exif::iso($image),
            'width' => Exif::width($image),
            'height' => Exif::height($image),
            'exif' => $image->exif()
        ];
        // dd($data);
        $res = $repository->upsert($data, $date, $file_name);
        if ($res) {
            $this->log('Store to database success');
        } else {
            $this->log('Store to database failed');
        }
    }
    protected function log($message)
    {
        echo $message."\n";
    }
}

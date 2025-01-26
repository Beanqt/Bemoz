<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Folders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!file_exists(public_path('uploads'))){
            mkdir(public_path('uploads'));
        }
        if(!file_exists(public_path('uploads/documentitem'))){
            mkdir(public_path('uploads/documentitem'));
        }
        if(!file_exists(public_path('uploads/gallery'))){
            mkdir(public_path('uploads/gallery'));
        }
        if(!file_exists(public_path('uploads/video'))){
            mkdir(public_path('uploads/video'));
        }
        if(!file_exists(storage_path('uploads'))){
            mkdir(storage_path('uploads'));
        }
        if(!file_exists(storage_path('zip'))){
            mkdir(storage_path('zip'));
        }
    }
}

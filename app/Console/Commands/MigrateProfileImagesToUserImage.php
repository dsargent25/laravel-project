<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Image;
use App\Service\ImageService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateProfileImagesToUserImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-profile-images-to-user-image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Takes profile images uploaded in the old format to the new way.';

    /**
     * Execute the console command.
     */
    public function handle(ImageService $imageService)
    {
        $this->info('Adding records to image_user pivot table, updating records on images table, and converting filenames to account for new schema...');

        $profileMigrateImages = Image::all();

        foreach ($profileMigrateImages as $profileMigrateImage){

            if($profileMigrateImage->image_role){
                $imageService->convertOldProfileImagesToNew($profileMigrateImage);
            }

        }

        $this->info('All old user profile images, that can, have been migrated.');

    }
}

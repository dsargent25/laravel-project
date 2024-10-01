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
     * @var ImageService
     */
    protected $imageService;

    /**
     * Create a new command instance.
     *
     * @param ImageService $imageService
     */
    public function __construct(ImageService $imageService)
    {
        parent::__construct();
        $this->imageService = $imageService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Adding records to image_user pivot table, updating records on images table, and converting filenames to account for new schema...');

        $profileMigrateImages = Image::all()->map->only('id', 'user_id', 'image_role', 'filename')->toArray();
        foreach ($profileMigrateImages as $profileMigrateImage){
            $user_id = $profileMigrateImage['user_id'];
            $image_id = $profileMigrateImage['id'];
            $profile_role = $profileMigrateImage['image_role'];
            $filename = $profileMigrateImage['filename'];

            if($profile_role){
                $user = User::find($user_id);
                $image = Image::find($image_id);

                if($user->images()){
                    $user->images()->detach($image);
                }

                $user->images()->attach($image);

                $pattern = '/profile/i';
                $newFilename = preg_replace($pattern,'user',$filename);

                if(rename(storage_path("app/public/{$filename}"), storage_path("app/public/{$newFilename}"))){
                    Image::where('user_id', $user_id)->update(['filename' => $newFilename]);
                }

            }

        }

        $this->info('All old user profile images have now been migrated.');

    }
}

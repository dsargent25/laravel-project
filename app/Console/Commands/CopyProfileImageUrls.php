<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\ImageService;

class CopyProfileImageUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:copy-profile-image-urls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Takes all profile image url values in the profile_image_url column of the Users table, iterates through and downloads the images, assigns each image a unique filename connected to the user id, and creates the records in the Images table.';

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
        $this->info('Copying profile image URLs...');

        $this->imageService->copyAllUserProfileImageUrls();

        $this->info('All profile image urls on Users table are now downloaded, with entries added to the Images table.');
    }
}

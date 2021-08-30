<?php

namespace Database\Seeders;

use App\Models\ContentType;
use Illuminate\Database\Seeder;

class ContentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContentType::create(['type' => 'carousel_home', 'status' => true, 'column_1' => true, 'column_2' => true, 'column_3' => true, 'column_4' => true, 'column_8' => true]);
        ContentType::create(['type' => 'carousel_about', 'status' => false, 'column_1'=> true, 'column_3'=> true, 'column_4' => true]);
        ContentType::create(['type' => 'carousel_services', 'status' => false, 'column_1'=> true, 'column_3'=> true, 'column_4' => true]);
        ContentType::create(['type' => 'carousel_work', 'status' => false, 'column_1'=> true, 'column_3'=> true, 'column_4' => true]);
        ContentType::create(['type' => 'home_tab', 'status' => true, 'column_1'=> true, 'column_3'=> true, 'column_6'=> true, 'column_7' => true]);
        ContentType::create(['type' => 'home_about_us', 'status' => false, 'column_1'=> true, 'column_2'=> true, 'column_3'=> true, 'column_6' => true]);
        ContentType::create(['type' => 'home_hire_us', 'status' => true, 'column_1'=> true, 'column_5' => true]);
        ContentType::create(['type' => 'home_testimonial_title', 'status' => false, 'column_1'=> true, 'column_2' => true]);
        ContentType::create(['type' => 'home_testimonial', 'status' => true, 'column_1'=> true, 'column_2'=> true, 'column_3' => true]);
        ContentType::create(['type' => 'home_achievement', 'status' => true, 'column_1'=> true, 'column_2'=> true, 'column_3'=> true, 'column_5' => true]);
        ContentType::create(['type' => 'home_vendor', 'status' => true, 'column_4' => true]);
        ContentType::create(['type' => 'about_vision', 'status' => false, 'column_1'=> true, 'column_3' => true]);
        ContentType::create(['type' => 'about_mission', 'status' => false, 'column_1'=> true, 'column_3' => true]);
        ContentType::create(['type' => 'about_image', 'status' => true, 'column_4' => true]);
        ContentType::create(['type' => 'about_motivation', 'status' => true, 'column_1'=> true, 'column_3' => true]);
        ContentType::create(['type' => 'about_achievement', 'status' => true, 'column_1'=> true, 'column_2'=> true, 'column_3' => true]);
        ContentType::create(['type' => 'about_leadership_title', 'status' => false, 'column_1'=> true, 'column_2' => true]);
        ContentType::create(['type' => 'about_leadership', 'status' => true, 'column_1'=> true, 'column_2'=> true, 'column_4' => true]);
        ContentType::create(['type' => 'about_clients_title', 'status' => false, 'column_1'=> true, 'column_2' => true]);
        ContentType::create(['type' => 'about_clients', 'status' => true, 'column_4' => true]);
        ContentType::create(['type' => 'services_title', 'status' => false, 'column_1' => true]);
        ContentType::create(['type' => 'services_help_title', 'status' => false, 'column_1'=> true, 'column_2' => true]);
        ContentType::create(['type' => 'services_help', 'status' => true, 'column_1'=> true, 'column_3'=> true, 'column_5' => true]);
        ContentType::create(['type' => 'services_action', 'status' => true, 'column_1'=> true, 'column_3'=> true, 'column_5' => true]);
        ContentType::create(['type' => 'service_inovation', 'status' => false, 'column_1'=> true, 'column_2'=> true, 'column_3'=> true, 'column_4'=> true, 'column_6' => true]);
        ContentType::create(['type' => 'work_activity_1', 'status' => true, 'column_4' => true]);
        ContentType::create(['type' => 'work_activity_2', 'status' => true, 'column_4' => true]);
        ContentType::create(['type' => 'work_activity_3', 'status' => true, 'column_4' => true]);
        ContentType::create(['type' => 'work_activity_4', 'status' => true, 'column_4' => true]);
        ContentType::create(['type' => 'contacts_title', 'status' => false, 'column_1'=> true, 'column_2' => true]);
        ContentType::create(['type' => 'contacts_message_title', 'status' => false, 'column_1'=> true, 'column_2' => true]);
    }
}

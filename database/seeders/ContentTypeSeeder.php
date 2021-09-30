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
        ContentType::create(['name' => 'Carousel Home', 'type' => 'carousel_home', 'status' => true, 'column_1' => true, 'column_2' => true, 'column_3' => true, 'column_4' => true, 'column_8' => true]);
        ContentType::create(['name' => 'Carousel About', 'type' => 'carousel_about', 'status' => false, 'column_1'=> true, 'column_3'=> true, 'column_4' => true]);
        ContentType::create(['name' => 'Carousel Services', 'type' => 'carousel_services', 'status' => false, 'column_1'=> true, 'column_3'=> true, 'column_4' => true]);
        ContentType::create(['deleted' => true, 'name' => 'Carousel Work', 'type' => 'carousel_work', 'status' => false, 'column_1'=> true, 'column_3'=> true, 'column_4' => true]);
        ContentType::create(['name' => 'Home Tab', 'type' => 'home_tab', 'status' => true, 'column_1'=> true, 'column_3'=> true, 'column_6'=> true, 'column_7' => true]);
        ContentType::create(['name' => 'Home About Us', 'type' => 'home_about_us', 'status' => false, 'column_1'=> true, 'column_2'=> true, 'column_3'=> true, 'column_6' => true]);
        ContentType::create(['name' => 'Home Hire Us', 'type' => 'home_hire_us', 'status' => true, 'column_1'=> true, 'column_5' => true]);
        ContentType::create(['name' => 'Home Testimonial Title', 'type' => 'home_testimonial_title', 'status' => false, 'column_1'=> true, 'column_2' => true]);
        ContentType::create(['name' => 'Home Testimonial', 'type' => 'home_testimonial', 'status' => true, 'column_1'=> true, 'column_2'=> true, 'column_3' => true]);
        ContentType::create(['name' => 'Home Achievement', 'type' => 'home_achievement', 'status' => true, 'column_1'=> true, 'column_2'=> true, 'column_3'=> true, 'column_5' => true]);
        ContentType::create(['name' => 'Home Vendor', 'type' => 'home_vendor', 'status' => true, 'column_4' => true]);
        ContentType::create(['name' => 'About Vision', 'type' => 'about_vision', 'status' => false, 'column_1'=> true, 'column_3' => true]);
        ContentType::create(['name' => 'About Mission', 'type' => 'about_mission', 'status' => false, 'column_1'=> true, 'column_3' => true]);
        ContentType::create(['name' => 'About Image', 'type' => 'about_image', 'status' => true, 'column_4' => true]);
        ContentType::create(['name' => 'About Motivation', 'type' => 'about_motivation', 'status' => true, 'column_1'=> true, 'column_3' => true]);
        ContentType::create(['name' => 'About Achievement', 'type' => 'about_achievement', 'status' => true, 'column_1'=> true, 'column_2' => true, 'column_5'=> true]);
        ContentType::create(['name' => 'About Leadership Title', 'type' => 'about_leadership_title', 'status' => false, 'column_1'=> true, 'column_2' => true]);
        ContentType::create(['name' => 'About Leadership', 'type' => 'about_leadership', 'status' => true, 'column_1'=> true, 'column_2'=> true, 'column_4' => true]);
        ContentType::create(['name' => 'About Clients Title', 'type' => 'about_clients_title', 'status' => false, 'column_1'=> true, 'column_2' => true]);
        ContentType::create(['name' => 'About Clients', 'type' => 'about_clients', 'status' => true, 'column_4' => true]);
        ContentType::create(['name' => 'Services Title', 'type' => 'services_title', 'status' => false, 'column_1' => true]);
        ContentType::create(['name' => 'Services Help Title', 'type' => 'services_help_title', 'status' => false, 'column_1'=> true, 'column_2' => true]);
        ContentType::create(['name' => 'Services Help', 'type' => 'services_help', 'status' => true, 'column_1'=> true, 'column_3'=> true, 'column_5' => true]);
        ContentType::create(['name' => 'Services Action', 'type' => 'services_action', 'status' => true, 'column_1'=> true, 'column_3'=> true, 'column_5' => true]);
        ContentType::create(['name' => 'Services Inovation', 'type' => 'services_innovation', 'status' => false, 'column_1'=> true, 'column_2'=> true, 'column_3'=> true, 'column_4'=> true, 'column_6' => true]);
        ContentType::create(['deleted' => true, 'name' => 'Work Activity 1', 'type' => 'work_activity_1', 'status' => true, 'column_4' => true]);
        ContentType::create(['deleted' => true, 'name' => 'Work Activity 2', 'type' => 'work_activity_2', 'status' => true, 'column_4' => true]);
        ContentType::create(['deleted' => true, 'name' => 'Work Activity 3', 'type' => 'work_activity_3', 'status' => true, 'column_4' => true]);
        ContentType::create(['deleted' => true, 'name' => 'Work Activity 4', 'type' => 'work_activity_4', 'status' => true, 'column_4' => true]);
        ContentType::create(['name' => 'Contacts Title', 'type' => 'contacts_title', 'status' => false, 'column_1'=> true, 'column_2' => true]);
        ContentType::create(['name' => 'Contacts Message Title', 'type' => 'contacts_message_title', 'status' => false, 'column_1'=> true, 'column_2' => true]);
    }
}

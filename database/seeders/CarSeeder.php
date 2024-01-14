<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = DB::connection('legacy_db')->select("select * from wp_posts where post_type='car'");
        $photos = DB::connection('legacy_db')
            ->table("wp_wj_photos")
            ->whereIn('post_id', array_column($posts, 'ID'))
            ->get();
        $meta = DB::connection('legacy_db')
            ->table("wp_postmeta")
            ->whereIn('post_id', array_column($posts, 'ID'))
            ->get();

        $bodyTypes = DB::connection('legacy_db')->table("wp_wj_body_types")->get();
        $bodyTypes = DB::connection('legacy_db')->table("wp_wj_body_types")->get();
        $colors = DB::connection('legacy_db')->table("wp_wj_colors")->get();
        $doors = DB::connection('legacy_db')->table("wp_wj_doors")->get();
        $drives = DB::connection('legacy_db')->table("wp_wj_drive")->get();
        $equipments = DB::connection('legacy_db')->table("wp_wj_equipments")->get();
        $fuels = DB::connection('legacy_db')->table("wp_wj_fuels")->get();
        $manufacturers = DB::connection('legacy_db')->table("wp_wj_manufacturers")->get();
        $models = DB::connection('legacy_db')->table("wp_wj_models")->get();
        $technical_conditions = DB::connection('legacy_db')->table("wp_wj_technical_conditions")->get();
        $transmissions = DB::connection('legacy_db')->table("wp_wj_transmissions")->get();
       
        foreach ($posts as $post) {
            $manufacturer_id = $meta->where('post_id', $post->ID)->where('meta_key', '_manufacturer_id')->first()->meta_value;
            $manufacturer = $manufacturers->where('id', $manufacturer_id)->first()->name;
            $body_type_id = $meta->where('post_id', $post->ID)->where('meta_key', '_body_type_id')->first()->meta_value;
            $body_type = $bodyTypes->where('id', $body_type_id)->first()->name;
            $ext_color_id = $meta->where('post_id', $post->ID)->where('meta_key', '_color_id')->first()->meta_value ?? null;
            $ext_color = $colors->where('id', $ext_color_id)->first()->name ?? 'N/A';
            $door_id = $meta->where('post_id', $post->ID)->where('meta_key', '_door_id')->first()->meta_value;
            $door = $doors->where('id', $door_id)->first()->name;
            $drive_id = $meta->where('post_id', $post->ID)->where('meta_key', '_drive_id')->first()->meta_value;
            $drive = $drives->where('id', $drive_id)->first()->name;
            $fuel_id = $meta->where('post_id', $post->ID)->where('meta_key', '_fuel_id')->first()->meta_value;
            $fuel = $fuels->where('id', $fuel_id)->first()->name;
            $technical_condition_id = $meta->where('post_id', $post->ID)->where('meta_key', '_technical_condition_id')->first()->meta_value;
            $technical_condition = $technical_conditions->where('id', $technical_condition_id)->first()->name;
            $transmission_id = $meta->where('post_id', $post->ID)->where('meta_key', '_transmission_id')->first()->meta_value;
            $transmission = $transmissions->where('id', $transmission_id)->first()->name;            
            $model_id = $meta->where('post_id', $post->ID)->where('meta_key', '_model_id')->first()->meta_value ?? null;
            $model = $models->where('id', $model_id)->first()->name ?? 'N/A';

            $carPhotos = $photos->where('post_id', $post->ID)->values();

            $carPhotos = $carPhotos->map(function ($photo) {
                $last_two_digit = substr($photo->id, -2);
                return "/storage/car/$last_two_digit/original/$photo->id.jpg";
            });

            $equipmentsAlias = $equipments->pluck('alias')->toArray();
            $features = $meta->whereIn('meta_key', $equipmentsAlias)->where('post_id', $post->ID)->pluck('meta_key')->toArray();
            $features = array_map(function ($feature) {
                return str_replace('_', ' ', $feature);
            }, $features);

            $car = Car::create([
                'technical_condition' => $technical_condition,
                'make' => $manufacturer,
                'transmission' => $transmission,
                'model' => $model,
                'body_type' => $body_type,
                'ext_color' => $ext_color,
                'int_color' => $meta->where('post_id', $post->ID)->where('meta_key', '_engine_power')->first()->meta_value ?? 'N/A',
                'drive' => $drive,
                'trim' => $meta->where('post_id', $post->ID)->where('meta_key', '_vin')->first()->meta_value ?? 'N/A',
                'fuel' => $fuel,
                'door' => $door,
                'name' => $post->post_title,
                'slug' => $post->post_name,
                'availability' => Car::AVAILABILITY['sold'],
                'description' => $post->post_content,
                'mileage' => $meta->where('post_id', $post->ID)->where('meta_key', '_mileage')->first()->meta_value ?? 0,
                'mileage_unit' => 'km',
                'features' => $features,
                'price' => $meta->where('post_id', $post->ID)->where('meta_key', '_price')->first()->meta_value ?? 0,
                'seats' => $meta->where('post_id', $post->ID)->where('meta_key', '_seats')->first()->meta_value ?? 0,
                'engine' => $meta->where('post_id', $post->ID)->where('meta_key', '_cilindrics')->first()->meta_value ?? 'N/A',
                'year' => $meta->where('post_id', $post->ID)->where('meta_key', '_fabrication')->first()->meta_value ?? 0,
                'featured_image_index' => 0,
                'images' => $carPhotos,
                'user_id' => 1,
            ]);

            echo 'Cars seeded: ' . $car->id . PHP_EOL;
        }
        
    }

}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("users")->truncate();
        DB::table("cities")->truncate();
        DB::table("states")->truncate();
        DB::table("countries")->truncate();
        DB::table("continents")->truncate();
        $this->call('usersSeed');
        $this->call('initSeed');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}




class initSeed extends Seeder 
{
    public function run()
    {
        $continents = $this->get();

        echo ".";
        if(isset($continents->geonames)):
            foreach ($continents->geonames as $continent):
                $continent_id = DB::table("continents")->insertGetId([
                    "name"  => $continent->toponymName
                ]);

                $countries = $this->get($continent->geonameId);
                if(isset($continents->geonames)):
                    foreach ($countries->geonames as $country):
                        $country_id = DB::table("countries")->insertGetId([
                            "continent_id"  => $continent_id,
                            "name"  => $country->name,
                            "complete_name"  => $country->toponymName,
                        ]);

                        $states = $this->get($country->geonameId);
                        if(isset($states->geonames)):
                            foreach ($states->geonames as $state):
                                $state_id = DB::table("states")->insertGetId([
                                    "country_id" => $country_id,
                                    "name"  =>  $state->name,
                                    "fs"    => (isset($state->adminCodes1->ISO3166_2) ? $state->adminCodes1->ISO3166_2 : "")
                                ]);

                                $cities = $this->get($state->geonameId);
                                if(isset($cities->geonames)):
                                    foreach ($cities->geonames as $state):
                                        $city_id = DB::table("cities")->insertGetId([
                                            "state_id" => $state_id,
                                            "name"  =>  $state->name,
                                            "state_fs" => (isset($state->adminCodes1->ISO3166_2) ? $state->adminCodes1->ISO3166_2 : "")
                                        ]);
                                        echo ".";
                                    endforeach;
                                endif;
                                echo ".";

                            endforeach; //states
                        endif;
                        echo ".";

                    endforeach;//countries
                endif;
                echo ".";
                exit;
            endforeach; //continents
        endif;
        echo "||| COMPLETED |||";
    }

    private function get($id="6295630")
    {
        $url = "http://www.geonames.org/childrenJSON?geonameId=".$id;
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );  
        $content = file_get_contents($url, false, stream_context_create($arrContextOptions));
        $xml = json_decode($content);
        return $xml;
    }


}


class usersSeed extends Seeder 
{
    public function run()
    {
      	DB::table('users')->insert([
            'name' => "ERP Copy Supply",
            'secret_id' => uniqid(),
            'secret_password' => uniqid()
        ]);
    }
}

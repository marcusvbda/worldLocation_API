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

        if(isset($continents->geonames)):
            foreach ($continents->geonames as $continent):
                echo $continent->toponymName." ";
                $continent_id = DB::table("continents")->insertGetId([
                    "name"  => $continent->toponymName
                ]);
                $countries = $this->get($continent->geonameId);
                if(isset($countries->geonames)):
                    foreach ($countries->geonames as $country):
                        echo "n";
                        $country_id = DB::table("countries")->insertGetId([
                            "continent_id"  => $continent_id,
                            "name"  => $country->name,
                            "complete_name"  => $country->toponymName,
                        ]);

                        $states = $this->get($country->geonameId);
                        if(isset($states->geonames)):
                            foreach ($states->geonames as $state):
                                echo "s";
                                $state_id = DB::table("states")->insertGetId([
                                    "country_id" => $country_id,
                                    "name"  =>  $state->name,
                                    "fs"    => (isset($state->adminCodes1->ISO3166_2) ? $state->adminCodes1->ISO3166_2 : "")
                                ]);

                                $cities = $this->get($state->geonameId);
                                if(isset($cities->geonames)):
                                    foreach ($cities->geonames as $city):
                                        echo "c";
                                        $city_id = DB::table("cities")->insertGetId([
                                            "state_id" => $state_id,
                                            "name"  =>  $city->name,
                                            "state_fs" => (isset($city->adminCodes1->ISO3166_2) ? $city->adminCodes1->ISO3166_2 : "")
                                        ]);
                                    endforeach;
                                endif;

                            endforeach; //states
                        endif;

                    endforeach;//countries
                endif;

            endforeach; //continents
        endif;
    }

    private function get($id="6295630")
    {
        try{
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
        catch(\Exception $e)
        {
            $result = null;
            while ($result == null) 
            {
                $result = $this->get($id);
            }
            return $result;
        }
        
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

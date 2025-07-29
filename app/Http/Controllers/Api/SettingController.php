<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\RelatedNewsSite;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function getSettings(Setting $setting)
    {
        $related_site = $this->relatedSites();
        if(!$setting){
            return $this->apiResponse(404 , 'Setting is empty');
        }
        $data = [
            'related_site' => $this->relatedSites(),
            'setting' => new SettingResource($setting)
        ];
        return $this->apiResponse(200 , 'This is site Setting' , $data);
    }
    public function relatedSites()
    {
        $related_site = RelatedNewsSite::select('name' , 'url')->get();
        if(!$related_site){
            return $this->apiResponse(404 , 'There are not related sites');
        }
        return $related_site;
    }
}

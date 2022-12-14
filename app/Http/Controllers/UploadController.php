<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    public function uploadForm()
    {
        return view ('upload');
    }

    public function uploadFile(Request $request)
    {
        //Plockar ut bildfilen från requesten och sparar i image variabeln.
        $image = $request->file;
        //Sparar bildfilen i public och behåller orginalnamnet.
        $image->storeAs('public',$image->getClientOriginalName());
        //Gör en instans av image make.
        $img = Image::make(storage_path('app/public').'/'.$image->getClientOriginalName());
        
        
        if($request->get('size') === 'instagram'){
            
            $img->fit(1080, 1080);
    
        }   else{
                $img->fit(1200, 630);
                
        }

       
        if($request->get('logo') === 'svart'){
           
            $logo = Image::make(storage_path('app/public/svartlogga.png'));
            $img->insert($logo,'bottom-right', 10, 10);
            
    
        }   else{
            $logo = Image::make(storage_path('app/public/vitlogga.png'));
            $img->insert($logo,'bottom-right', 10, 10);
            
        } 

      
        $img->save(storage_path('app/public') . '/' . $image->getClientOriginalName()); 
        
        
        return view ('uploadedFile',['img' => asset('storage') . '/' . $image->getClientOriginalName()]); 
       //asset är en säkrare väg att länka till app/public
    }
  
    
  
}

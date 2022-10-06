<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use GDText\Box;
use GDText\Color;

class ApiController extends Controller
{
    /* API documentation
    
    Token angiven i headern "Bearer apa".

    Bildgenerator med flera olika möjligheter.

    *Ange pixlar för att bestämma höjd och bredd på bilden.
     Variabler: height och width. (required)

    *Välja vart man kan placera företagsloggan samt färg (vit/svart).
     Variabler: color och position (optional: default white och top-left)

    *Möjlighet att lägga in en svart eller vit text med vald fontstorlek ovanpå bilden. 
     Variabler: textColor och fontSize (optional: default white och 32px)

    *Möjlighet att ändra storlek på textboxen beroende på längd och storlek på vald text.
     Variabel: textboxWidth (optional, dock required att den inte är större än själva bredden på bilden)
    
    *Möjlighet att kunna göra bilden mörkare för att öka läsbarheten.
      Variabel: brightness (optinal: default vanlig ljusstyrka).
    
    */

    public function generateImage(Request $request){
        
        if ($request->bearerToken() !== 'apa'){
            return response()->json(['error'=>'invalid token'],401);
        }

        $error=[];
        $width = $request->width;
        $height = $request->height;
        $color = $request->color;
        $position = $request->position;
        $text = $request->text;
        $textColor = $request->textColor;
        $brightness = $request->brightness;
        $fontSize =$request->fontSize;
        $textboxWidth = $request->textboxWidth;


        //Plockar ut bildfilen från requesten och sparar i image variabeln.
        $image = $request->image;
    
        
        if (!is_numeric($width) || !is_numeric($height)){
            array_push($error, 'Width and height are required for image and needs to be numeric');
        }

        if ($image === null){
            array_push($error, "Image is required");
        }

        if (!is_numeric($fontSize) && $fontSize != null){
            array_push($error, "fontSize needs to be a numeric value");
        }

        if ($textboxWidth > $width){
            array_push($error, "textboxWidth can not be bigger than the width");
        }
    
        if ($error != null){
            return response()->json (['error' => $error],400);
        }

        $width = (int)$width;
        $height = (int)$height;

        $image->storeAs('public',$image->getClientOriginalName());
        $img = Image::make(storage_path('app/public').'/'.$image->getClientOriginalName());

        $img->fit($width, $height);
     
        //Användaren kan välja färg på loggan, annars är default vit.
        if($color === "black"){
           
            $logo = Image::make(storage_path('app/public/svartlogga.png'));
            $img->insert($logo,$position, 10, 10);
            
        }   else{
            $logo = Image::make(storage_path('app/public/vitlogga.png'));
            $img->insert($logo,$position, 10, 10);   
        }
        
        $textboxPosition = ($width-$textboxWidth)/2;

        $coreImage = $img->getCore();
        $box = new Box($coreImage);
        $box->setBox($textboxPosition, null, $textboxWidth, $height);
        $box->setTextAlign('center', 'center');
        $box->setFontFace(storage_path('GT-Cinetype-Light.ttf')); 

     
        //Om användaren vill ändra textfärg, annars är default vit.
        if($text !== null && $textColor === 'black'){
            $box->setFontColor(new Color(0, 0, 0));
        }

        else{
            $box->setFontColor(new Color(255, 255, 255));
        }

        //Om användaren vill ändra textstorlek, annars är default 32px.
        if($fontSize){
            $box->setFontSize($fontSize);
        }

        elseif($fontSize === null){
            $box->setFontSize(32);
        }

        //Om användaren vill ändra ljusstyrkan.
        if($brightness === 'darker'){
            $img->insert(Image::canvas($img->width(), $img->height(), 'rgba(0,0,0,0.2)'));
        }

        //Skriver ut text på bilden
        $box->draw($text);

        $img->save(storage_path('app/public') . '/' . $image->getClientOriginalName()); 

        return response()->json ([
 
            'url' => ['img' => asset('storage') . '/' . $image->getClientOriginalName()]   
        ]);

    }
  
}

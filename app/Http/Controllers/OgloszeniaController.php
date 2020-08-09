<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ogloszenie;
use DB;
use App\User;



class OgloszeniaController extends Controller
{

// Check for user Auth and verify on all pages except index, show, search resources.
  public function __construct(){
      $this->middleware(['auth','verified'], ['except' => ['index', 'show', 'search']]);
  }

// Return view to add new Ogloszenie.
    public function create(){
      return view('pages/ogloszenia/dodajogloszenie');
    }


// Create new Ogloszenie.
    public function store(Request $request){

      $customMessages = [
        'image' => 'Wysłane zdjęcia muszą być w następujących formatach: jpeg, png, jpg, gif, svg.',
        'mimes' => 'Wysłane zdjęcia muszą być w następujących formatach: jpeg, png, jpg, gif, svg.',
        'title.unique' => "Ogłoszenie o podanej nazwie już istnieje.",
        'images.max' => 'Możesz wysłać maksymalnie :max zdjęć.',
        'images.*.max' => 'Wysyłane zdjęcia nie mogą być większe niż 5MB.',
        'title.min' => 'Tytuł jest zbyt krótki.',
        'title.max' => 'Tytuł jest zbyt długi',
        'city.max' => 'Nazwa miasta jest zbyt długa.',
        'district.max' => 'Nazwa dzielnicy jest zbyt długa.',
        'description.min' => 'Opis jest zbyt krótki.',
        'description.max' => 'Opis jest zbyt długi',
        'gt' => 'Podana wartość jest nieprawidłowa.',
        'rok.before' => 'Podaj poprawną datę.',
        'rok.gt' => 'Podaj poprawną datę'
      ];

// Validate inputs
      $this->validate($request, [
        'title' => 'required|min:8|unique:ogloszenia|max:191',
        'city' => 'required|max:191',
        'district' => 'max:191|nullable',
        'description' => 'required|min:8|max:5000',
        'size' => 'required|numeric|gt:0',
        'price' => 'required|numeric|gt:0',
        'images' => 'required|max:16',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        'dodatkowy_czynsz' => 'numeric|nullable|gt:0',
        'rok' => 'numeric|nullable|date_format:Y|before:tommorow|gt:1800',
        'kaucja' => 'numeric|nullable|gt:0',
        'pokoje' => 'in:wybierz,1,2,3,4,5,więcej_niż_5|nullable',
        'pietro' => 'in:wybierz,parter,1,2,3,4,5,6,7,8,9,10,więcej_niż_10|nullable',
        'stan' => 'in:wybierz,do_zamieszkania,do_remontu,do_wykończenia|nullable',
        'ogrzewanie' => 'in:wybierz,miejskie,gazowe,piec_kaflowy,elektryczne,kotłownia,inne|nullable',
        'equipment.*' => 'in:meble,pralka,zmywarka,lodówka,kuchenka,piekarnik,telewizor|nullable',
        'additional_info.*' => 'in:balkon,garaż,miejsce_parkingowe,piwnica,ogródek,klimatyzacja,winda|nullable'
      ], $customMessages);




// If validation passes, Create new Model and bind values from request.
      $ogloszenie = new Ogloszenie;
      $ogloszenie->user_id = auth()->user()->id;
      $ogloszenie->title = $request->input('title');
      $ogloszenie->city = $request->input('city');
      $ogloszenie->district = $request->input('district');
      $ogloszenie->description = $request->input('description');
      $ogloszenie->size = $request->input('size');
      $ogloszenie->price = $request->input('price');
      $ogloszenie->to_negotiate = $request->input('to_negotiate');
      $ogloszenie->additional_costs = $request->input('dodatkowy_czynsz');
      $ogloszenie->year_of_construction = $request->input('rok');
      $ogloszenie->deposit = $request->input('kaucja');

// Check for default values and insert NULL into DB if user has not selected any option.
      if($request->input('pokoje') == 'wybierz'){
        $ogloszenie->rooms = NULL;
      }else{
        $ogloszenie->rooms = $request->input('pokoje');
      }

      if($request->input('pietro') == 'wybierz'){
        $ogloszenie->floor = NULL;
      }else{
        $ogloszenie->floor = $request->input('pietro');
      }

      if($request->input('stan') == 'wybierz'){
        $ogloszenie->condition = NULL;
      }else{
        $ogloszenie->condition = $request->input('stan');
      }

      if($request->input('ogrzewanie') == 'wybierz'){
        $ogloszenie->heating = NULL;
      }else{
        $ogloszenie->heating = $request->input('ogrzewanie');
      }



// Check if uses checked to_negotiate chechbox. If not remain it as false.
      if ($request->has('to_negotiate')) {
        $ogloszenie->to_negotiate = true;
      }else{
        $ogloszenie->to_negotiate = false;
      }

// Get last id stored in DB and increments $id variable.
// Works only in MySQL?
// Might change it later to be more universal.
      $id=DB::select("SHOW TABLE STATUS LIKE 'ogloszenia'");
      $next_id=$id[0]->Auto_increment;

// Binds each image file to $image variable.
      foreach($request->file('images') as $image){
// Gets original name of the file user puts into input.
        $newImage=$image->getClientOriginalName();
// Move image file into 'images' folder to store it in certain folder which have name of our Model id.
// After moving the file put it to an array.
        $image->move(public_path().'/images/'.$next_id, $newImage);
        $imageArray[] = $newImage;
      }

// Encode images array to json.
      $ogloszenie->image=json_encode($imageArray);

// Encode checkbox values to json if they arent empty.
    if(empty($request->get('equipment'))){
      $ogloszenie->equipment = NULL;
    }else{
      $ogloszenie->equipment = json_encode($request->get('equipment'));
    }

    if(empty($request->get('additional_info'))){
      $ogloszenie->additional_info = NULL;
    }else{
      $ogloszenie->additional_info = json_encode($request->get('additional_info'));
    }

// Save data into DB.
      $saved = $ogloszenie->save();

// If Ogloszenie is successfully saved redirect user to his advertisements tab.
      if($saved){
        $message = 'Ogłoszenie zostało wystawione.';
        return redirect('/twojeogloszenia')->with('message', $message);
      }else{
        return redirect('/twojeogloszenia');
      }
    }


// Find Ogloszenie Model by id and redirect user for certain advertisement page.
    public function show($id){
      $ogloszenie = Ogloszenie::find($id);

      if($ogloszenie){
      return view('pages/ogloszenia/podgladogloszenia')->with('ogloszenie', $ogloszenie);
      }else{
        return redirect()->back();
      }
    }

// Show contact button on advertisement page which forces user to login after he clicks the button in case to send message to other users.
    public function showContact($id){
      $ogloszenie = Ogloszenie::find($id);
      if($ogloszenie){
      return view('pages/ogloszenia/podgladogloszenia')->with('ogloszenie', $ogloszenie);
      }else{
        return redirect()->back();
      }
    }


// Show page for editing user Ogloszenie.
    public function edit($id){
      $ogloszenie = Ogloszenie::find($id);

// Create an array to fill selectbox options in view
    $roomsArray = array('wybierz', '1', '2', '3', '4', '5', 'więcej_niż_5');
    $floorArray = array('wybierz', 'parter', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'więcej_niż_10');
    $stanArray = array('wybierz', 'do_zamieszkania', 'do_wykończenia', 'do_remontu');
    $heatingArray = array('wybierz', 'miejskie', 'gazowe', 'piec_kaflowy', 'elektryczne', 'kotłownia', 'inne');
    $equipmentArray = array('meble', 'pralka', 'zmywarka', 'lodówka', 'kuchenka', 'piekarnik', 'telewizor');
    $additional_infoArray = array('balkon', 'garaż', 'miejsce_parkingowe', 'piwnica', 'ogródek', 'klimatyzacja', 'winda');

// Checks if user logged is owner of the Model.
      if(auth()->user()->id !== $ogloszenie->user_id){
          return redirect('/ogloszenia');
      }
      return view('pages/ogloszenia/edytujogloszenie')->with(['ogloszenie' => $ogloszenie,
                                                              'roomsArray' => $roomsArray,
                                                              'floorArray' => $floorArray,
                                                              'stanArray' => $stanArray,
                                                              'heatingArray' => $heatingArray,
                                                              'equipmentArray' => $equipmentArray,
                                                              'additional_infoArray' => $additional_infoArray]);
    }


// Update edited data for Ogloszenie Model.
    public function update(Request $request, $id){

      $customMessages = [
        'image' => 'Wysłane zdjęcia muszą być w następujących formatach: jpeg, png, jpg, gif, svg.',
        'mimes' => 'Wysłane zdjęcia muszą być w następujących formatach: jpeg, png, jpg, gif, svg.',
        'title.unique' => "Ogłoszenie o podanej nazwie już istnieje.",
        'images.max' => 'Możesz wysłać maksymalnie :max zdjęć.',
        'images.*.max' => 'Wysyłane zdjęcia nie mogą być większe niż 5MB.',
        'title.min' => 'Tytuł jest zbyt krótki.',
        'title.max' => 'Tytuł jest zbyt długi',
        'city.max' => 'Nazwa miasta jest zbyt długa.',
        'district.max' => 'Nazwa dzielnicy jest zbyt długa.',
        'description.min' => 'Opis jest zbyt krótki.',
        'description.max' => 'Opis jest zbyt długi',
        'gt' => 'Podana wartość jest nieprawidłowa.',
        'rok.before' => 'Podaj poprawną datę.',
        'rok.gt' => 'Podaj poprawną datę'
      ];

// Validate input data.
      $this->validate($request, [
        'title' => 'required|min:8|unique:ogloszenia,title,'.$id.'|max:191',
        'city' => 'required|max:191',
        'district' => 'max:191|nullable',
        'description' => 'required|min:8|max:5000',
        'size' => 'required|numeric|gt:0',
        'price' => 'required|numeric|gt:0',
// Check for old values of image. This allows to submit form without adding new images just validating those added before.
        'images' => 'required_without:old|max:16',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        'dodatkowy_czynsz' => 'numeric|nullable|gt:0',
        'rok' => 'numeric|nullable|date_format:Y|before:tommorow|gt:1800',
        'kaucja' => 'numeric|nullable|gt:0',
        'pokoje' => 'in:wybierz,1,2,3,4,5,więcej_niż_5|nullable',
        'pietro' => 'in:wybierz,parter,1,2,3,4,5,6,7,8,9,10,więcej_niż_10|nullable',
        'stan' => 'in:wybierz,do_zamieszkania,do_remontu,do_wykończenia|nullable',
        'ogrzewanie' => 'in:wybierz,miejskie,gazowe,piec_kaflowy,elektryczne,kotłownia,inne|nullable',
        'equipment.*' => 'in:meble,pralka,zmywarka,lodówka,kuchenka,piekarnik,telewizor|nullable',
        'additional_info.*' => 'in:balkon,garaż,miejsce_parkingowe,piwnica,ogródek,klimatyzacja,winda|nullable'
      ], $customMessages);

// Checks if images form is purged. If old images are deleted and user did not put any new into the form he will be redirected back.
      if(empty($request->old) && empty($request->file('images'))){
        return redirect()->back();
      }

// Create array from preloaded images.
      if(!empty($request->old)){
        foreach ($request->old as $oldimage){
          $imagepath = basename($oldimage);
          $newImages[] = $imagepath;
        }
      }

// Bind request values to variables.
      $ogloszenie = Ogloszenie::find($id);
      $ogloszenie->title = $request->input('title');
      $ogloszenie->city = $request->input('city');
      $ogloszenie->district = $request->input('district');
      $ogloszenie->description = $request->input('description');
      $ogloszenie->size = $request->input('size');
      $ogloszenie->price = $request->input('price');
      $ogloszenie->to_negotiate = $request->input('to_negotiate');
      $ogloszenie->additional_costs = $request->input('dodatkowy_czynsz');
      $ogloszenie->year_of_construction = $request->input('rok');
      $ogloszenie->deposit = $request->input('kaucja');

// Check for default values and insert NULL into DB if user has not selected any option.
      if($request->input('pokoje') == 'wybierz'){
        $ogloszenie->rooms = NULL;
      }else{
        $ogloszenie->rooms = $request->input('pokoje');
      }

      if($request->input('pietro') == 'wybierz'){
        $ogloszenie->floor = NULL;
      }else{
        $ogloszenie->floor = $request->input('pietro');
      }

      if($request->input('stan') == 'wybierz'){
        $ogloszenie->condition = NULL;
      }else{
        $ogloszenie->condition = $request->input('stan');
      }

      if($request->input('ogrzewanie') == 'wybierz'){
        $ogloszenie->heating = NULL;
      }else{
        $ogloszenie->heating = $request->input('ogrzewanie');
      }

// Check if uses checked to_negotiate chechbox. If not remain it as false.
      if ($request->has('to_negotiate')) {
        $ogloszenie->to_negotiate = true;
      }else{
        $ogloszenie->to_negotiate = false;
      }

// Decodes json value of images array.
      $currentStoredImages = json_decode($ogloszenie->image);

// Binds original name of each new image inserted to the form by user.
// Creates an array which contains all images(old and new) not allowing them to duplicate by searching in array for original name.
    if (!empty($request->file('images'))){
      foreach($request->file('images') as $image){
        $newName=$image->getClientOriginalName();
        if(!empty($request->old)){
          if(!in_array($newName, $newImages)){
            $image->move(public_path().'/images/'.$ogloszenie->id, $newName);
            $newImages[] = $newName;
          }
        }else{
          $image->move(public_path().'/images/'.$ogloszenie->id, $newName);
          $newImages[] = $newName;
        }
      }
    }

// Compare both arrays to check for deleted images.
// If user deletes image, automatically delete it from storage folder.
      foreach($currentStoredImages as $currentImage){
        if(!in_array($currentImage, $newImages)){
          unlink(public_path('images/'.$ogloszenie->id.'/').$currentImage);
        }
      }

// Encode final array.
      $ogloszenie->image=json_encode($newImages);

// Encode checkbox values to json if they arent empty.
    if(empty($request->get('equipment'))){
      $ogloszenie->equipment = NULL;
    }else{
      $ogloszenie->equipment = json_encode($request->get('equipment'));
    }

    if(empty($request->get('additional_info'))){
      $ogloszenie->additional_info = NULL;
    }else{
      $ogloszenie->additional_info = json_encode($request->get('additional_info'));
    }

// Save Model changes into DB and redirect user back to edited advertisement page.
      $saved = $ogloszenie->save();
      if($saved){
        $message = 'Twoje ogłoszenie zostało poprawnie edytowane.';
        return redirect('/ogloszenia/'.$ogloszenie->id)->with('message', $message);
      }else{
        return redirect('/ogloszenia/'.$ogloszenie->id);
      }
    }

// Delete advertisement and Ogloszenie Model.
    public function destroy($id)
    {
      $ogloszenie = Ogloszenie::find($id);

      if ($ogloszenie) {
      if(auth()->user()->id !== $ogloszenie->user_id){
          return redirect('/ogloszenia');
          // error handler
      }

// Decode json data from DB into an array.
      $imageArray = json_decode($ogloszenie->image);
      foreach ($imageArray as $imageName) {
// Delete each element of array from storage.
        unlink(public_path('images/'.$ogloszenie->id.'/').$imageName);
      }
// Remove images folder of deleted Model.
      rmdir(public_path('images/'.$ogloszenie->id));
// Delete Model and redirect to user advertisements tab.
      $ogloszenie->delete();
      }
      $message = 'Ogłoszenie zostało usunięte.';
      return redirect('/twojeogloszenia')->with('message', $message);
    }

// Show user advertisements tab.
  public function twojeogloszenia(){
      $user_id = auth()->user()->id;
      $user = User::find($user_id);

// Get items favorited by user.
      $favoriteOgloszenia = $user->getFavoriteItems(Ogloszenie::class)->get();

// Return view with all advertisements added by user and those which he like.
      return view('pages/ogloszenia/twojeogloszenia')->with(['ogloszenia' => $user->ogloszenia,
                                                             'favoriteOgloszenia' => $favoriteOgloszenia]);
    }


// Search function
  function search(Request $request){
// Check for ajax request
       if($request->ajax()){
// bind query sent from request and replacing all white spaces with '%'.
        $query = str_replace(" ", "%", $request->get('query'));

// If query is not empty get sort_by and order_by value from request.
        if($query != ''){
        $sort_by = $request->get('sort_by');
        if(substr($sort_by, -5) == '_desc'){
          $sort_by = trim(str_replace('_desc', '', $sort_by));
          $sort_order = 'desc';
        }elseif(substr($sort_by, -4) == '_asc'){
          $sort_by = trim(str_replace('_asc', '', $sort_by));
          $sort_order = 'asc';
        }

// Search '$query' value in all Models sorting it and ordering properly.
// Pagination. Show 15 items per page.
        $data = Ogloszenie::Where('city', 'like', '%'.$query.'%')
                              ->orWhere('district', 'like', '%'.$query.'%')
                              ->orderBy($sort_by, $sort_order)->paginate(15);


// Check if user which posted advertisement deleted(disabled) his account.
// In result all advertisements which belongs to deleted users won't be shown.
        $i = 0;
        foreach($data as $dataa){
          $useride = $dataa->user_id;
          $userdata = User::find($useride);
        if($userdata->deleted == true){
          unset($data[$i]);
        }
          $i++;
        }

// Check if array is empty. If not then post data into view.
      if($data->isEmpty()){
        $message = 'Brak wyników dla frazy "'.$query.'"';
        return view('pages/ogloszenia/ajax_search')->with('message', $message);
        }else{
          $message = 'Wyniki wyszukiwania frazy "'.$query.'"';
          return view('pages/ogloszenia/ajax_search', ['data' => $data,
                                                       'message' => $message])->render();
        }
      }
    }
  }

// Check Ogloszenie as Favorite on toggle.
  public function favRequest(Request $request){
    $user = User::find(auth()->user()->id);
    $ogloszenie = Ogloszenie::find($request->id);

    $user->toggleFavorite($ogloszenie);

    return response()->json(['success' => true]);
  }

}

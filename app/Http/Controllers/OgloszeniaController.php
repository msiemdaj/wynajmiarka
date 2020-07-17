<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ogloszenie;
use DB;
use App\User;



class OgloszeniaController extends Controller
{

  public function __construct()
  {
      $this->middleware(['auth','verified'], ['except' => ['index', 'show', 'search']]);
  }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $ogloszeniaAll = Ogloszenie::all();

          return view('pages/ogloszenia/ogloszenia')->with('ogloszeniaAll', $ogloszeniaAll);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages/ogloszenia/dodajogloszenie');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'title' => 'required|min:8|unique:ogloszenia',
        'city' => 'required',
        'district' => 'required',
        'description' => 'required|min:8',
        'size' => 'required|numeric',
        'price' => 'required|numeric',
        'images' => 'required',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
      ]);

      $ogloszenie = new Ogloszenie;
      $ogloszenie->user_id = auth()->user()->id;
      $ogloszenie->title = $request->input('title');
      $ogloszenie->city = $request->input('city');
      $ogloszenie->district = $request->input('district');
      $ogloszenie->description = $request->input('description');
      $ogloszenie->size = $request->input('size');
      $ogloszenie->price = $request->input('price');
      $ogloszenie->to_negotiate = $request->input('to_negotiate');

      if ($request->has('to_negotiate')) {
        $ogloszenie->to_negotiate = true;
      }else{
        $ogloszenie->to_negotiate = false;
      }

      $id=DB::select("SHOW TABLE STATUS LIKE 'ogloszenia'");
      $next_id=$id[0]->Auto_increment;

      foreach($request->file('images') as $image){
        $newImage=$image->getClientOriginalName();
        $image->move(public_path().'/images/'.$next_id, $newImage);
        $imageArray[] = $newImage;
      }

      $ogloszenie->image=json_encode($imageArray);
      $saved = $ogloszenie->save();

      if($saved){
        $message = 'Ogłoszenie zostało wystawione.';
        return redirect('/twojeogloszenia')->with('message', $message);
      }else{
        return redirect('/twojeogloszenia');
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $ogloszenie = Ogloszenie::find($id);

      if($ogloszenie){
      return view('pages/ogloszenia/podgladogloszenia')->with('ogloszenie', $ogloszenie);
      }else{
        return redirect()->back();
      }
    }

    public function showContact($id){
      $ogloszenie = Ogloszenie::find($id);
      if($ogloszenie){
      return view('pages/ogloszenia/podgladogloszenia')->with('ogloszenie', $ogloszenie);
      }else{
        return redirect()->back();
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $ogloszenie = Ogloszenie::find($id);

      if(auth()->user()->id !== $ogloszenie->user_id){
          return redirect('/ogloszenia');
          // error handler
      }
      return view('pages/ogloszenia/edytujogloszenie')->with('ogloszenie', $ogloszenie);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      $this->validate($request, [
        'title' => 'required|min:8',
        'city' => 'required',
        'district' => 'required',
        'description' => 'required|min:8',
        'size' => 'required|numeric',
        'price' => 'required|numeric',
        'images' => 'required_without:old',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
      ]);

      // create array from preloaded images
      if(empty($request->old) && empty($request->file('images'))){
        return redirect()->back();
      }

      if(!empty($request->old)){
        foreach ($request->old as $oldimage){
          $imagepath = basename($oldimage);
          $newImages[] = $imagepath;
        }
      }

      $ogloszenie = Ogloszenie::find($id);
      $ogloszenie->title = $request->input('title');
      $ogloszenie->city = $request->input('city');
      $ogloszenie->district = $request->input('district');
      $ogloszenie->description = $request->input('description');
      $ogloszenie->size = $request->input('size');
      $ogloszenie->price = $request->input('price');

      if ($request->has('to_negotiate')) {
      $ogloszenie->to_negotiate = true;
    }else{
      $ogloszenie->to_negotiate = false;
    }

      $currentStoredImages = json_decode($ogloszenie->image);

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

      foreach($currentStoredImages as $currentImage){
        if(!in_array($currentImage, $newImages)){
          unlink(public_path('images/'.$ogloszenie->id.'/').$currentImage);
        }
      }


      $ogloszenie->image=json_encode($newImages);

      $saved = $ogloszenie->save();
      if($saved){
        $message = 'Twoje ogłoszenie zostało poprawnie edytowane.';
        return redirect('/ogloszenia/'.$ogloszenie->id)->with('message', $message);
      }else{
        return redirect('/ogloszenia/'.$ogloszenie->id);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $ogloszenie = Ogloszenie::find($id);

      if ($ogloszenie) {
      if(auth()->user()->id !== $ogloszenie->user_id){
          return redirect('/ogloszenia');
          // error handler
      }

      $imageArray = json_decode($ogloszenie->image);
      foreach ($imageArray as $imageName) {
        unlink(public_path('images/'.$ogloszenie->id.'/').$imageName);
      }
      rmdir(public_path('images/'.$ogloszenie->id));

      $ogloszenie->delete();
      }
      $message = 'Ogłoszenie zostało usunięte.';
      return redirect('/twojeogloszenia')->with('message', $message);
    }

    public function twojeogloszenia(){
      $user_id = auth()->user()->id;
      $user = User::find($user_id);
      return view('pages/ogloszenia/twojeogloszenia')->with('ogloszenia', $user->ogloszenia);
    }

  function search(Request $request){
       if($request->ajax()){
        $query = str_replace(" ", "%", $request->get('query'));

        if($query != ''){
        $sort_by = $request->get('sort_by');
        if(substr($sort_by, -5) == '_desc'){
          $sort_by = trim(str_replace('_desc', '', $sort_by));
          $sort_order = 'desc';
        }elseif(substr($sort_by, -4) == '_asc'){
          $sort_by = trim(str_replace('_asc', '', $sort_by));
          $sort_order = 'asc';
        }

        $data = DB::table('ogloszenia')
                      ->Where('city', 'like', '%'.$query.'%')
                      ->orWhere('district', 'like', '%'.$query.'%')
                      ->orderBy($sort_by, $sort_order)->paginate(1);

                      // paginate
                      // return compact(?)

                      $i = 0;
                      foreach($data as $dataa){
                        $useride = $dataa->user_id;
                        $userdata = User::find($useride);
                        if($userdata->deleted == true){
                          unset($data[$i]);
                        }
                        $i++;
                      }

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
}

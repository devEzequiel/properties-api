<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\newPropertyAddedToYourList;
use App\Models\Api\SavedProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SavedPropertyController extends Controller
{
    private $savedProperty;

    public function __construct(SavedProperty $savedProperty)
    {
        $this->savedProperty = $savedProperty;
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $id)
    {

        $savedProperty = DB::table('saved_properties')
                                ->where('user_id', '=', Auth::user()->id)
                                ->where('property_id', '=', $id)
                                ->first();
        
        // dd($property);
        if ($savedProperty) {
            return response()->json(['msg' => 'Imóvel já salvo']);
        }

        $property = DB::table('properties')
                            ->where('id', $id)
                            ->first();

        try {
            $this->savedProperty->user_id = Auth::user()->id;
            $this->savedProperty->property_id = $id;
            $this->savedProperty->details = $request->details;
            $this->savedProperty->save();

            Mail::send(new newPropertyAddedToYourList(
                Auth::user()->email, Auth::user()->name, $property->title
            ));

            return response()->json(['status' => 'success'], 201);
        } catch (\Exception $e) {
 
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try {
            $savedProperties = DB::table('saved_properties')
                                        ->where('user_id', Auth::user()->id);
            foreach ($savedProperties as $s){
                var_dump($s);
                break;
            }
        // dd($this->savedProperty);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {

        $savedProperty = DB::table('saved_properties')
                                ->where('user_id', '=', Auth::user()->id)
                                ->where('property_id', '=', $id)
                                ->first();
        
        // dd($property);
        if (!$savedProperty) {
            return response()->json(['msg' => 'Nenhuma propriedade encontrada']);
        }

        try {
            $this->savedProperty = DB::table('saved_properties')
                                        ->where('property_id', $id)
                                        ->where('user_id', Auth::user()->id)
                                        ->delete();

            return response()->json(['msg' => 'Propriedade removida da sua lista'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }
    }
}

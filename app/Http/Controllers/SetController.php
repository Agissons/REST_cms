<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Boxe;
use App\Models\Mealworm;
use App\Models\Set;

use App\Models\Users_work_set;
use Illuminate\Http\Request;
use App\Models\Setsview3;
use Illuminate\Validation\Rule;

class SetController extends Controller
{
    //

    public function display()
    {
        $sets=Setsview3::select(auth()->user()->id);

        return view('sets.gestion',['sets'=>$sets]);
    }

    public function create(Request $request)
    {
        $formFields = $request->validate([
            // verifie si l'utilisateur existe déjà
            'name' => ['required', Rule::unique('sets','name')]

        ]);

        $formFields['users_id'] = auth()->user()->id;
        $formFields['created_at'] = date('Y-m-d H:i:s',strtotime('now'));
        $setId =Set::insertGetId($formFields);
        Users_work_set::create(['users_id'=>auth()->user()->id,'sets_id'=>$setId]);


        return redirect('/set/'.$setId);

    }

    public function full($id)
    {
        $set = Set::firstwhere('id', $id);

        if($set)
        {
            $exist = Users_work_set::where('sets_id','=',$id)->where('users_id','=',auth()->user()->id)->get();

            if($exist)
            {
                $boxes = Boxe::select('boxes.name', 'types.name as type' , 'boxes.created_at' , 'boxes.updated_at' , 'boxes.weight' ,'users.username')
                    ->join('users','users.id',"=" ,'boxes.users_id')
                    ->join('types','types.id',"=" ,'boxes.types_id')
                    ->where('boxes.active' ,'=' ,1)
                    ->where('boxes.sets_id' ,'=' ,$id)
                    ->get();

                $worms= Mealworm::select('boxes.name as boxe','mealworms.code', 'mealworms.created_at' , 'mealworms.updated_at' , 'mealworms.weight' )
                    ->join('boxes','boxes.id',"=" ,'mealworms.boxes_id')
                    ->where('mealworms.active' ,'=' ,1)
                    ->where('mealworms.sets_id' ,'=' ,$id)
                    ->get();

                return view('boxes.display',['sets'=>$set, 'boxes'=>$boxes, 'worms'=>$worms]);
            }
            else
            {
                return back()->with('Operation non autorisé vous ne fait pas partie de cet ensemble');
            }
        }
        else
        {
            return back()->with('cet ensemble n\'existe pas ');
        }


    }



}

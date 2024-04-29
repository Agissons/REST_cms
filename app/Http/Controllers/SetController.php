<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Boxe;
use App\Models\Mealworm;
use App\Models\Set;
use App\Models\Guano;

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
                $boxes = Boxe::select('boxes.id','boxes.name', 'types.name as type' , 'boxes.created_at' , 'boxes.updated_at' , 'boxes.weight' ,'users.username','users_give_aliments.created_at as nourish')
                    ->join('users','users.id',"=" ,'boxes.users_id')
                    ->join('types','types.id',"=" ,'boxes.types_id')
                    ->leftjoin('users_give_aliments','users_give_aliments.boxes_id','=','boxes.id')
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

    public function guanoadd(Request $request)
    {
        $formFields = $request->validate([
            // verifie si l'utilisateur existe déjà
            'guano' => 'required',
            'id' => 'required',
            'name'=> 'max:50'
        ]);
        

        if($formFields['guano']<0)
        {
            if($formFields['name']==null)
            {
                return back()->withErrors(['name'=>'renseigner à qui vous le donner'])->onlyInput('name');
            }
            Guano::create(['name'=>$formFields['name'],'weight'=>-$formFields['guano'], 'sets_id'=>$formFields['id']]);
        }
        $set = Set::firstwhere('id', $formFields['id']);
        $set->weight += $formFields['guano'];
        $set->save();

        return back();
    }

    public function wormsadd(Request $request)
    {
        $formFields = $request->validate([
            // verifie si l'utilisateur existe déjà
            'worms' => 'required',
            'id' => 'required',
            'weight'=>'requiered',
            'code'=>['required', Rule::unique('Mealworms','code')]
        ]);

        Mealworms::create([]);
        create(['users_id'=>auth()->user()->id,'sets_id'=>$setId]);
        $set = Set::firstwhere('id', $formFields['id']);
        $set->weight += $formFields['guano'];
        $set->save();

        return back();
    }



}

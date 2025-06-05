<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use App\Models\Exel;
use App\Models\Volunteer;
use App\Models\Volunteer_act_campaign;
use App\Models\Volunteer_does_donation;
use App\Models\Volunteer_scale;
use App\Models\Volunteer_sign_call;
use App\Models\Volunteer_use_canal;
use App\Models\Volunteer_answers_question;
use App\Models\Volunteer_does_action;
use App\Models\Call;
use App\Models\Campaign;
use App\Models\Phone;
use App\Models\Email;
use App\Models\Interaction_type;
use App\Models\Interaction;
use App\Models\Action;
use App\Models\Action_got_answer;
use App\Models\Actions_question;
use App\Models\Activist;
use Throwable;

use Illuminate\Support\Collection;
use SebastianBergmann\Type\VoidType;
use Termwind\Components\Li;

use function Illuminate\Events\queueable;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class ExelController extends Controller
{
    //
    public function create()
    {
        $volunteer = [];
    }
    
    public function combine()
    {
        $header = null;
        $header2 = null;
        $header3 = null;

        $acdata = array();
        $docdata = array();
        $rndata = array();

        if (($handle = fopen(public_path('csv/used_file.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header3)
                    $header3 = $row;
                else
                    $docdata[] = array_combine($header3, $row);
            }
            fclose($handle);
        }

        foreach ($docdata as $row) {

            //dd($row);

            $user = Exel::select()->firstWhere('id', $row['id']);

            $user->update([
                'wa_enter_way' => $row["wa_enter_way"], "wa_enter_date" => $row['wa_enter_date'],
                'wa_exit_date' => $row['wa_exit_date'], "wa2_enter_date" => $row['wa2_enter_date'],
                'wa2_exit_date' => $row['wa2_exit_date'], "wa3_enter_date" => $row['wa3_enter_date'],
                'wa3_exit_date' => $row['wa3_exit_date'], 'rank' => $row["rank"], "organiser" => $row['organiser']
            ]);

            //dd($user->last_name==null);



            //return view('fail',[]);
        }
        

        if (($handle = fopen(public_path('csv/action_network.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $acdata[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        $acdata = array_filter($acdata, fn ($e) => ($e['Mobile Number'] != ""));
        foreach ($acdata as $row) {

            $row["Mobile Number"] = preg_replace('/\+/', '', $row["Mobile Number"]);

            $info = 0;
            $soutien = 0;
            if (boolval($row["Sympathisant X Bénévole_Je souhaite en savoir plus sur la campagne (soirée d'info, discussion, ...)"]) || boolval($row['Sympathisant X Bénévole_En savoir plus']) || boolval($row["Sympathisant X Bénévole_En savoir plus sur la campagne (soirée d'information, conversation, ...)"]) || boolval($row['Sympathisant X Bénévole_Suivre les informations de la campagne "Nos Transports Publics"']) || boolval($row["Sympathisant X Bénévole_Recevoir des infos"])) {
                $info = 1;
            }
            if (boolval($row['Sympathisant X Bénévole_Aider ~ Soutenir plus activement la campagne']) || boolval($row["Sympathisant X Bénévole_Soutenir la campagne"])) {
                $soutien = 1;
            }
            //dd($row);
            if ($row["Mobile Number"] != '') {
                $user = Exel::select()->firstWhere('phone_number', $row["Mobile Number"]);
                //dd($user);
                if ($user == null) {
                    $user = Exel::select()->firstWhere('email', $row["Email"]);
                    //dd($user);
                    if ($user == null) {
                        $user = Exel::select()->Where('first_name', '=', $row["First name"])->Where('last_name', '=', $row["Last name"])->limit(1)->get();

                        if ($user->isEmpty()) {
                            Exel::insert([
                                "first_name" => $row['First name'], "last_name" => $row['Last name'], "phone_number" => $row['Mobile Number'],
                                'email' => $row["Email"],
                                'primary_zip' => $row['Zip code'], "appel" => 1,
                                "info" => $info, "question" => $row['Question ouverte'], "soutien" => $soutien
                            ]);
                        } else {

                            $user[0]->update([
                                "phone_number" => $row['Mobile Number'],
                                'email' => $row["Email"],
                                'primary_zip' => $row['Zip code'], "appel" => 1,
                                "info" => $info, "question" => $row['Question ouverte'], "soutien" => $soutien
                            ]);
                        }
                    } else {
                        $user->update([
                            "phone_number" => $row['Mobile Number'],

                            'primary_zip' => $row['Zip code'], "appel" => 1,
                            "info" => $info, "question" => $row['Question ouverte'], "soutien" => $soutien
                        ]);
                    }
                } else {
                    $user->update([
                        'primary_zip' => $row['Zip code'], "appel" => 1,
                        "info" => $info, "question" => $row['Question ouverte'], "soutien" => $soutien
                    ]);
                }
            }


            //return view('fail',[]);
        }

        if (($handle = fopen(public_path('csv/raise_now.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header2)
                    $header2 = $row;
                else
                    $rndata[] = array_combine($header2, $row);
            }
            fclose($handle);
        }

        foreach ($rndata as $row) {

            $row['amount_formatted'] = floatval($row['amount_formatted']);
            //dd($row);
            $user = Exel::select()->firstWhere('email', $row["stored_customer_email"]);
            //dd($user);
            if ($user == null) {
                $user = Exel::select()->Where('first_name', '=', $row["stored_customer_firstname"])->Where('last_name', '=', $row["stored_customer_lastname"])->limit(1)->get();

                if ($user->isEmpty()) {
                    Exel::insert([
                        "first_name" => $row['stored_customer_firstname'], "last_name" => $row['stored_customer_lastname'],
                        'email' => $row["stored_customer_email"], "donations_amount" => $row['amount_formatted'],
                        "new_donations_amount" => $row['amount_formatted']
                    ]);
                } else {

                    $user[0]->update([
                        'email' => $row["stored_customer_email"], "donations_amount" => $user[0]->donations_amount + $row['amount_formatted'],
                        "new_donations_amount" => $row['amount_formatted']
                    ]);
                }
            } else {
                $user->update([
                    "donations_amount" => $user->donations_amount + $row['amount_formatted'],
                    "new_donations_amount" => $row['amount_formatted']
                ]);
                //dd($user);
            }

            //return view('fail',[]);
        }
        //dd($rndata);

        dd($docdata);





        return view('success');
        return view('fail', []);
    }
    public function extract()
    {
        $this->listCutter("question");



        /*$data= Activist::where('donations_amount','>=',200)
        ->select("first_name","last_name","phone_number", 'email','primary_zip',"donations_amount", "last_donated_at")
        ->get();
        $handle = fopen(public_path('csv/Nbdon.csv'), 'w');
        fputcsv($handle, ["first_name","last_name","phone_number", 'email','primary_zip',"donations_amount", "last_donated_at"], ',');
        foreach ($data as $row) {
            
            fputcsv($handle, $row->toArray(), ','); 
        }
        fclose($handle);
        dd($data);*/

        $data = Volunteer_does_action::select(
                "volunteers_id",
                "volunteers_new_id",
                "actions_id",
                "created_at") 
        /*$data = DB::table('exels')->where('soutien', '=', 1)->orWhere('info', '=', 1)->orWhere(function (Builder $query) {
            $query->whereNotNull('wa2_enter_date')
                ->Where(function (Builder $query2) {
                    $query2->whereNull('wa2_exit_date')
                        ->orWhere('wa2_exit_date', '=', '0000-00-00 00:00:00');
                });
        })
            ->orWhere(function (Builder $query) {
                $query->wherenotNull('wa3_exit_date')
                    ->Where(function (Builder $query2) {
                        $query2->whereNull('wa3_exit_date')
                            ->orWhere('wa3_exit_date', '=', '0000-00-00 00:00:00');
                    });            })*/
            
            /*->orderBy('soutien', 'asc')->orderBy('wa3_enter_date', 'desc')->orderBy('wa2_enter_date', 'desc')->orderBy('info', 'desc')*/
            ->get();
            //dd($data[0]);
            
        $handle = fopen(public_path('csv/newVol1.csv'), 'w');
        fputcsv($handle, [
            "volunteers_id",
                "volunteers_new_id",
                "actions_id",
                "created_at"
        ], ',');
        
        foreach ($data as $row) {


            $row2=$row->toArray();
            $row2["created_at"]=str_replace(["T",".000000Z"],[" ",""],$row2["created_at"]);
            //dd($row2);
            fputcsv($handle, $row2, ',');
        }
        fclose($handle);
        dd($row2);
    }

    public function dbToexel()
    {
        $data = Activist::where('phone_number', '!=', '')->Where('mobile_opt_in', '=', '1')
            ->select("id", "first_name", "last_name", "phone_number", 'email', "donations_amount", "donations_pledged_amount", "priority_level", 'primary_zip')
            ->get();

        foreach ($data as $row) {

            Exel::insert(["first_name" => $row->first_name, "last_name" => $row->last_name, "phone_number" => $row->phone_number, 'email' => $row->email, "donations_amount" => $row->donations_amount, "donations_pledged_amount" => $row->donations_pledged_amount, "priority_level" => $row->priority_level, 'primary_zip' => $row->primary_zip, 'db' => 1]);
        }
    }

    public function NPA()
    {
        $header = null;

        $npa = array();

        if (($handle = fopen(public_path('csv/NPA/NPA.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $npa[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        //dd($npa);


        $data = Exel::select("id", 'primary_zip','npa')
            ->get();

        foreach ($data as $row) {
            $canton = array_column($npa, 'NPA');
            $found_key = array_search($row->primary_zip, $canton);
            //dd($npa[$found_key]['Canton']);
            $row->npa=$npa[$found_key]['Canton'];
            $row->save();

            
        }
        dd($data);
    }

    public function raisenowSynthesis()
    {

        $header2 = null;

        $data = array();
        $emaillist = array();
        $construct = array();

        if (($handle = fopen(public_path('csv/raisenow.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header2)
                    $header2 = $row;
                else
                    $data[] = array_combine($header2, $row);
            }
            fclose($handle);
        }

        foreach ($data as $row) {

            $row['amount'] = intval($row['amount']/100);
            if (in_array($row["email"], $emaillist)) {
                for ($x = 0; $x < count($construct); $x++) {
                    if ($row["email"] == $construct[$x]["email"]) {
                        $construct[$x]['amount'] +=  ($row['amount']);
                    }
                }
            } else {
                array_push($emaillist, $row["email"]);
                array_push($construct, $row);
            }



            //return view('fail',[]);
        }


        //$construct = array_filter($construct, fn ($e) => ($e['amount_formatted'] >= 150));

        $handle = fopen(public_path('csv/donresume.csv'), 'w');
        fputcsv($handle, $header2, ',');
        foreach ($construct as $row) {
            fputcsv($handle, $row, ',');
        }
        dd($construct);
        $nbdata = Activist::where('donations_amount', '>=', 100)
            ->select("first_name", "last_name", "phone_number", 'email', 'primary_zip', "donations_amount", "last_donated_at")
            ->get();
        $handle = fopen(public_path('csv/Nbdon.csv'), 'w');
        fputcsv($handle, ["first_name", "last_name", "phone_number", 'email', 'primary_zip', "donations_amount", "crowdfunding", "last_donated_at"], ',');
        foreach ($nbdata as $row) {
            if (in_array($row->email, $emaillist)) {
                foreach ($construct as $row2) {
                    if ($row->email == $row2["stored_customer_email"]) {
                        $row->crowdfunding =  $row2['amount_formatted'];
                    }
                }
            }


            fputcsv($handle, $row->toArray(), ',');
        }
        fclose($handle);
        dd($nbdata);
        dd($construct);
    }

    public function peopleFilter()
    {

        $header2 = null;

        $data = array();
        $emaillist = array();
        $dbdata = array();
        if (($handle = fopen(public_path('csv/peoplewzip/db.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header2)
                    $header2 = $row;
                else
                    $data[] = array_combine($header2, $row);
            }
            fclose($handle);
        }
        $data = array_filter($data, fn ($e) => ($e['email']!=""));

        
            
        $handle = fopen(public_path('csv/havemail.csv'), 'w');
        fputcsv($handle, $header2, ',');
        foreach ($data as $row) {
            fputcsv($handle, $row, ',');
        }
        dd($data);
        
        
        $dbdata = Exel::select("id", 'email','npa','last_name','first_name','phone_number','rank',"organiser","primary_zip")
            ->get();

        
        
        
        
        foreach ($data as $row) {

            $row['amount'] = intval($row['amount']);
            if (in_array($row["email"], $emaillist)) {
                for ($x = 0; $x < count($construct); $x++) {
                    if ($row["email"] == $construct[$x]["email"]) {
                        $construct[$x]['amount'] +=  $row['amount'];
                    }
                }
            } else {
                array_push($emaillist, $row["email"]);
                array_push($construct, $row);
            }



            //return view('fail',[]);
        }
        

        //$construct = array_filter($construct, fn ($e) => ($e['amount_formatted'] >= 150));

        $handle = fopen(public_path('csv/doncf.csv'), 'w');
        fputcsv($handle, $header2, ',');
        foreach ($construct as $row) {
            fputcsv($handle, $row, ',');
        }
        
        $nbdata = Activist::where('donations_amount', '>=', 100)
            ->select("first_name", "last_name", "phone_number", 'email', 'primary_zip', "donations_amount", "last_donated_at")
            ->get();
        $handle = fopen(public_path('csv/Nbdon.csv'), 'w');
        fputcsv($handle, ["first_name", "last_name", "phone_number", 'email', 'primary_zip', "donations_amount", "crowdfunding", "last_donated_at"], ',');
        foreach ($nbdata as $row) {
            if (in_array($row->email, $emaillist)) {
                foreach ($construct as $row2) {
                    if ($row->email == $row2["stored_customer_email"]) {
                        $row->crowdfunding =  $row2['amount_formatted'];
                    }
                }
            }


            fputcsv($handle, $row->toArray(), ',');
        }
        fclose($handle);
        dd($nbdata);
        dd($construct);
    }

    public function listCutter(string $file)
    {
        $header2 = null;

        $data = array();
        $emaillist = array();
        $dbdata = array();
        if (($handle = fopen(public_path('csv/use/'.$file.'.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header2)
                    $header2 = $row;
                else
                    $data[] = array_combine($header2, $row);
                
            }
            fclose($handle);
        }
        $quantity=floor(sizeof($data)/500);
        $rest=sizeof($data)%500;
        $listcut=[];
        for ($x = 0; $x < $quantity; $x++) {  
            array_push( $listcut,array_slice($data, $x*500, 500));
        }
        array_push( $listcut,array_slice($data, -$rest));
       
        $x=1;
        foreach ($listcut as $list){
            $handle = fopen(public_path('csv/use/'.$file.$x.'.csv'), 'w');
            fputcsv($handle, $header2, ',');
            foreach ($list as $row) {
                fputcsv($handle, $row, ',');
            }
            $x++;
            

        }
        dd($listcut);

    
    }

    public function emailCombine()
    {
        
        $header = null;
        $header2 = null;

        $data = array();
        $emaillist = array();
        $dbdata = array();

        $users = Email::select("email" , "opt_in", "volunteer_id" , 'volunteer_new_id')->get();
        //dd($users);
        $handle = fopen(public_path('csv/mails.csv'), 'w');

        foreach ($users as $row) {


            fputcsv($handle, $row->toArray(), ',');
        }
        fclose($handle);
        dd($users);




        if (($handle = fopen(public_path('csv/use/emailtable.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header2)
                {
                    $header2 = $row;
                    
                }

                else
                {
                    
                    $dbdata[] = array_combine($header2, $row);
                }
                    
            }
            fclose($handle);
        }

        foreach( $dbdata as $row){
            
            Email::insertOrIgnore(["email" => $row['email'], "opt_in" => 1, "volunteer_id" => intval($row['volunteer_id']), 'volunteer_new_id' => intval($row['volunteer_new_id'])]);
            

            

        }
        dd($dbdata);

    
        if (($handle = fopen(public_path('csv/use/peoplenozip.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header)
                {
                    $header = $row;
                    array_push($header,'fullname');
                }

                else
                {
                    $row['fullname']= $row[0].' '.$row[1];
                    $row['fullname']=preg_replace('%  %', ' ', $row['fullname']);
                    $row['fullname']=preg_replace('/\s+$/', '', $row['fullname']);
                    

                    $dbdata[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        foreach( $dbdata as $row){
            
            $found= Volunteer::select('id', 'fullname','new_id')->firstWhere('fullname', $row['fullname']);
            
            if(is_null($found)){
                dd($found,$row);
            }
            
            array_push($emaillist,[$row['email'],$found->id,$found->new_id,0]);

            

            

        }

        $handle = fopen(public_path('csv/use/emailtablebis2.csv'), 'w');
        fputcsv($handle, ["email",
        "volunteer_id",
        "volunteer_new_id",'opt_in'], ',');
        foreach ($emaillist as $row) {


            fputcsv($handle, $row, ',');
        }
        fclose($handle);
        dd($emaillist);
       




        if (($handle = fopen(public_path('csv/use/havemail.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header)
                {
                    $header = $row;
                    array_push($header,'fullname');
                }

                else
                {
                    $row['fullname']= $row[4].' '.$row[3];
                    $row['fullname']=preg_replace('%  %', ' ', $row['fullname']);
                    $row['fullname']=preg_replace('/\s+$/', '', $row['fullname']);
                    

                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        
        
        
        //dd($emaillist);

       

        
        
        $users = Volunteer::select("first_name",
        "last_name",
        "primary_address1",
        "primary_city",
        "primary_state",
        "primary_zip",
        "npa",
        "primary_country",
        "organizer",
        "volunteer_scale",
        "id")->get();
        //dd($users);
        $handle = fopen(public_path('csv/noco.csv'), 'w');

        foreach ($users as $row) {


            fputcsv($handle, $row->toArray(), ',');
        }
        fclose($handle);

        
        
        Email::insertOrIgnore(["email" => "test@hotmail.com", "opt_in" => 0, "volunteer_id" => 9, 'volunteer_new_id' => 4]);
        
        

       
       
        
        
    }

    public function phoneCombine()
    {
        $header = null;
        $header2 = null;

        $data = array();
        $phonelist = array();
        $dbdata = array();


        $users = Phone::select("phone_number" , "opt_in", "volunteer_id" , 'volunteer_new_id')->get();
        //dd($users);
        $handle = fopen(public_path('csv/phones.csv'), 'w');

        foreach ($users as $row) {


            fputcsv($handle, $row->toArray(), ',');
        }
        fclose($handle);
        dd($users);

        if (($handle = fopen(public_path('csv/use/phonetable.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header2)
                {
                    $header2 = $row;
                    
                }

                else
                {
                    
                    $dbdata[] = array_combine($header2, $row);
                }
                    
            }
            fclose($handle);
        }

        foreach( $dbdata as $row){
            
            Phone::insertOrIgnore(["phone_number" => $row['phone'], "opt_in" => 1, "volunteer_id" => intval($row['volunteer_id']), 'volunteer_new_id' => intval($row['volunteer_new_id'])]);
            

            

        }
        dd($dbdata);


    
        if (($handle = fopen(public_path('csv/use/phone2.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header)
                {
                    $header = $row;
                    array_push($header,'fullname');
                }

                else
                {
                    $row['fullname']= $row[1].' '.$row[2];
                    $row['fullname']=preg_replace('%  %', ' ', $row['fullname']);
                    $row['fullname']=preg_replace('/\s+$/', '', $row['fullname']);
                    

                    $dbdata[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }


        foreach( $dbdata as $row){
            
            $found= Volunteer::select('id', 'fullname','new_id')->firstWhere('exel_id', $row['id']);
            
            if(is_null($found)){
                
                $found= Volunteer::select('id', 'fullname','new_id')->firstWhere('fullname', $row['fullname']);
                if(is_null($found)){
                    dd($found,$row);
                    
                    
                }
            }
            
            array_push($phonelist,[$row['phone'],$found->id,$found->new_id,0]);

            

            

        }

        $handle = fopen(public_path('csv/use/emailtablebis2.csv'), 'w');
        fputcsv($handle, ["phone",
        "volunteer_id",
        "volunteer_new_id",'opt_in'], ',');
        foreach ($phonelist as $row) {


            fputcsv($handle, $row, ',');
        }
        fclose($handle);
        dd($phonelist);
        dd($dbdata);




        if (($handle = fopen(public_path('csv/use/havemail.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header)
                {
                    $header = $row;
                    array_push($header,'fullname');
                }

                else
                {
                    $row['fullname']= $row[4].' '.$row[3];
                    $row['fullname']=preg_replace('%  %', ' ', $row['fullname']);
                    $row['fullname']=preg_replace('/\s+$/', '', $row['fullname']);
                    

                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        
        
        
        //dd($emaillist);

       

        
        
        $users = Volunteer::select("first_name",
        "last_name",
        "primary_address1",
        "primary_city",
        "primary_state",
        "primary_zip",
        "npa",
        "primary_country",
        "organizer",
        "volunteer_scale",
        "id")->get();
        //dd($users);
        $handle = fopen(public_path('csv/noco.csv'), 'w');

        foreach ($users as $row) {


            fputcsv($handle, $row->toArray(), ',');
        }
        fclose($handle);

        
        
        Volunteer_does_donation::insertOrIgnore(["donations_amount" => 1, "created_at" => "2024-11-11 00:13:53", "volunteer_id" => 9, 'volunteer_new_id' => 4, "recurrent" =>1]);
        
        

       
        if (($handle = fopen(public_path('csv/use/nmail.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header2)
                {
                    $header2 = $row;
                    array_push($header2,'fullname');
                }

                else
                {
                    if($row[3]!=''&&' '){
                        
                    }
                    else{
                        $row['fullname'] =$row[4];
                        $row['fullname']=preg_replace('%  %', ' ', $row['fullname']);
                    }
                    
                    $dbdata[] = array_combine($header2, $row);
                }
                    
            }
            fclose($handle);
        }
        
        
        foreach($users as $user){
            
            $user->fullname =substr($user->fullname, 0, -1);
            
            $user->save();
           
        }
       
        
        

        
        
        $dbdata = Exel::select("id", 'email','npa','last_name','first_name','phone_number','rank',"organiser","primary_zip")
            ->get();

        
        
        
        
        foreach ($data as $row) {

            $row['amount'] = intval($row['amount']);
            if (in_array($row["email"], $emaillist)) {
                for ($x = 0; $x < count($construct); $x++) {
                    if ($row["email"] == $construct[$x]["email"]) {
                        $construct[$x]['amount'] +=  $row['amount'];
                    }
                }
            } else {
                array_push($emaillist, $row["email"]);
                array_push($construct, $row);
            }



            //return view('fail',[]);
        }
        

        //$construct = array_filter($construct, fn ($e) => ($e['amount_formatted'] >= 150));

        $handle = fopen(public_path('csv/doncf.csv'), 'w');
        fputcsv($handle, $header2, ',');
        foreach ($construct as $row) {
            fputcsv($handle, $row, ',');
        }
        
        $nbdata = Activist::where('donations_amount', '>=', 100)
            ->select("first_name", "last_name", "phone_number", 'email', 'primary_zip', "donations_amount", "last_donated_at")
            ->get();
        
        dd($nbdata);
        dd($construct);
    }

    public function donationToDb()
    {
        $header = null;
        $header2 = null;

        $data = array();
        $donationlist = array();
        $dbdata = array();

        if (($handle = fopen(public_path('csv/raisenow.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header)
                {
                    $header = $row;
                    array_push($header,'fullname');
                }

                else
                {
                    $row['fullname']= $row[5].' '.$row[6];
                    $row['fullname']=preg_replace('%  %', ' ', $row['fullname']);
                    $row['fullname']=preg_replace('/\s+$/', '', $row['fullname']);
                    $row['0']=date('Y-m-d H:i:s',strtotime($row['0']));

                    $dbdata[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        dd($dbdata);
        
        

        foreach( $dbdata as $row){
            
            $found= Email::select("email" , "volunteer_id" , 'volunteer_new_id')->firstWhere('email', $row['email']);
            //dd($found,$row);
            
            
            if(is_null($found)){
                //dd($found,$row);
                $found= Volunteer::select('id', 'fullname','new_id')->firstWhere('fullname', $row['fullname']);
                array_push($donationlist,[$row['created'],$found->id,$found->new_id,intval($row["amount"])/100,$row["is_recurring"]]);
                if(is_null($found)){
                    dd($found,$row);
                    
                    
                }
            }
            else{
                array_push($donationlist,[$row['created'],$found->volunteer_id,$found->volunteer_new_id,intval($row["amount"])/100,$row["is_recurring"]]);
            }
            
            //array_push($donationlist,[$row['created'],$found->volunteer_id,$found->volunteer_new_id,intval($row["amount"])/100,$row["is_recurring"]]);
        }
        

        $handle = fopen(public_path('csv/donationformated.csv'), 'w');
        fputcsv($handle, ["created",
        "volunteer_id",
        "volunteer_new_id",'amount','recurrent'], ',');
        foreach ($donationlist as $row) {


            fputcsv($handle, $row, ',');
        }
        fclose($handle);
        //dd($donationlist);
        

        foreach ($donationlist as $row) {
            if($row[4]=="true"){
                $row[4]=1;
            }else{
                $row[4]=0;
            }
            Volunteer_does_donation::insert(["donations_amount" => $row[3], "created_at" => $row[0], "volunteer_id" => $row[1], 'volunteer_new_id' => $row[2], "recurrent" =>$row[4]]);
            //dd($row);


           
        }
        dd($donationlist);

        $users = Email::select("email" , "volunteer_id" , 'volunteer_new_id')->get();
        //dd($users);
        $handle = fopen(public_path('csv/donationformated.csv'), 'w');

        

        

        foreach( $dbdata as $row){
            
            Phone::insertOrIgnore(["phone_number" => $row['phone'], "opt_in" => 1, "volunteer_id" => intval($row['volunteer_id']), 'volunteer_new_id' => intval($row['volunteer_new_id'])]);
            

            

        }
       


    
        


        foreach( $dbdata as $row){
            
            $found= Volunteer::select('id', 'fullname','new_id')->firstWhere('exel_id', $row['id']);
            
            if(is_null($found)){
                
                $found= Volunteer::select('id', 'fullname','new_id')->firstWhere('fullname', $row['fullname']);
                if(is_null($found)){
                    dd($found,$row);
                    
                    
                }
            }
            
            array_push($phonelist,[$row['phone'],$found->id,$found->new_id,0]);

            

            

        }

        $handle = fopen(public_path('csv/use/emailtablebis2.csv'), 'w');
        fputcsv($handle, ["phone",
        "volunteer_id",
        "volunteer_new_id",'opt_in'], ',');
        foreach ($phonelist as $row) {


            fputcsv($handle, $row, ',');
        }
        fclose($handle);
        dd($phonelist);
        dd($dbdata);




        if (($handle = fopen(public_path('csv/use/havemail.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header)
                {
                    $header = $row;
                    array_push($header,'fullname');
                }

                else
                {
                    $row['fullname']= $row[4].' '.$row[3];
                    $row['fullname']=preg_replace('%  %', ' ', $row['fullname']);
                    $row['fullname']=preg_replace('/\s+$/', '', $row['fullname']);
                    

                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        
        
        
        //dd($emaillist);

       

        
        
        $users = Volunteer::select("first_name",
        "last_name",
        "primary_address1",
        "primary_city",
        "primary_state",
        "primary_zip",
        "npa",
        "primary_country",
        "organizer",
        "volunteer_scale",
        "id")->get();
        //dd($users);
        $handle = fopen(public_path('csv/noco.csv'), 'w');

        foreach ($users as $row) {


            fputcsv($handle, $row->toArray(), ',');
        }
        fclose($handle);

        
        
        Phone::insertOrIgnore(["phone" => "test@hotmail.com", "opt_in" => 0, "volunteer_id" => 9, 'volunteer_new_id' => 4]);
        
        

       
        if (($handle = fopen(public_path('csv/use/nmail.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header2)
                {
                    $header2 = $row;
                    array_push($header2,'fullname');
                }

                else
                {
                    if($row[3]!=''&&' '){
                        
                    }
                    else{
                        $row['fullname'] =$row[4];
                        $row['fullname']=preg_replace('%  %', ' ', $row['fullname']);
                    }
                    
                    $dbdata[] = array_combine($header2, $row);
                }
                    
            }
            fclose($handle);
        }
        
        
        foreach($users as $user){
            
            $user->fullname =substr($user->fullname, 0, -1);
            
            $user->save();
           
        }
       
        
        

        
        
        $dbdata = Exel::select("id", 'email','npa','last_name','first_name','phone_number','rank',"organiser","primary_zip")
            ->get();

        
        
        
        
        foreach ($data as $row) {

            $row['amount'] = intval($row['amount']);
            if (in_array($row["email"], $emaillist)) {
                for ($x = 0; $x < count($construct); $x++) {
                    if ($row["email"] == $construct[$x]["email"]) {
                        $construct[$x]['amount'] +=  $row['amount'];
                    }
                }
            } else {
                array_push($emaillist, $row["email"]);
                array_push($construct, $row);
            }



            //return view('fail',[]);
        }
        

        //$construct = array_filter($construct, fn ($e) => ($e['amount_formatted'] >= 150));

        $handle = fopen(public_path('csv/doncf.csv'), 'w');
        fputcsv($handle, $header2, ',');
        foreach ($construct as $row) {
            fputcsv($handle, $row, ',');
        }
        
        $nbdata = Activist::where('donations_amount', '>=', 100)
            ->select("first_name", "last_name", "phone_number", 'email', 'primary_zip', "donations_amount", "last_donated_at")
            ->get();
        
        dd($nbdata);
        dd($construct);
    }

     public function actionToDb()
    {
        $header = null;
        

        $data = array();
        $donationlist = array();
        $dbdata = array();
        $id =1;

        for ($j = 37; $j <= 38; $j++) {
            if (($handle = fopen(public_path('csv/actions/Reports_AN2/'.'action_'.strval($j).'.csv'), 'r')) !== false) {
                while (($row = fgetcsv($handle, 2000, ',')) !== false) {
                    if (!$header)
                    {
                        //dd($header, $row);
                        $header = $row;
                    }

                    else
                    {
                        
                    $dbdata[] = array_combine($header, $row);
                    }
                }
                fclose($handle);
            }
            foreach ($dbdata as $row) {
            $volunteer=Email::select('volunteer_id','volunteer_new_id')->firstWhere('email', $row["email"]);
            //dd($row, is_null($volunteer));
            if(is_null($volunteer)){
                //dd($row);
                $volid=Volunteer::select('id','new_id')->firstWhere( "fullname","=",$row["first_name"].' '.$row['last_name']);
                //dd($volid,$row);
                Email::insertOrIgnore(['volunteer_id' => $volid->id,  'volunteer_new_id' => $volid->new_id, 'email' => $row["email"],"opt_in" => 1 ]);
                if(!$row["can2_phone"]==''){
                    Phone::insertOrIgnore(['volunteer_id' => $volid->id,  'volunteer_new_id' => $volid->new_id, 'phone_number' => intval($row["can2_phone"]),"opt_in" => 0 ]);
                }


            }
            Volunteer_does_action::insert(['volunteers_id' => $volunteer->volunteer_id, "created_at" => substr($row["can2_user_time_stamp"], 0, -4), 'volunteers_new_id' => $volunteer->volunteer_new_id, 'actions_id' => ($j+1)]);
            //dd(['volunteer_id' => $volunteer->volunteer_id, "created_at" => substr($row["can2_user_time_stamp"], 0, -4), 'volunteer_new_id' => $volunteer->volunteer_new_id, 'actions_id' => $id]);
            if(count($row)>6)
            for ($i = 6; $i < count($row); $i++) {
        if(!$row[$header[$i]]==''){
            //dd(['volunteers_id' => $volunteer->volunteer_id, "created_at" => substr($row["can2_user_time_stamp"], 0, -4), 'volunteers_new_id' => $volunteer->volunteer_new_id, 'actions_questions_id' =>intval( $header[$i]), 'answers'=>$row[$header[$i]]]);
            Volunteer_answers_question::insert(['volunteers_id' => $volunteer->volunteer_id, "created_at" => substr($row["can2_user_time_stamp"], 0, -4), 'volunteers_new_id' => $volunteer->volunteer_new_id, 'actions_questions_id' => $header[$i], 'answers'=>$row[$header[$i]]]);
                }
                
            }

        }
        
         $dbdata = array();
            $header = null;

            /*if(count($header)>6){

            //dd($header);
            for ($i = 6; $i < count($header); $i++) {
                $question=Actions_question::select("id" )->firstWhere("name", "=",$header[$i]);
                $header2[$i]= $question->id;
                
                
            }
            $handle = fopen(public_path('csv/actions/Reports_AN2/'.'action_'.strval($j).'.csv'), 'w');
                fputcsv($handle, $header2, ',');
                foreach ($dbdata as $row) {
                    fputcsv($handle, $row, ',');
                }
                fclose($handle);
                $header2 = null;
            }
            else{
                $handle = fopen(public_path('csv/actions/Reports_AN2/'.'action_'.strval($j).'.csv'), 'w');
                fputcsv($handle, $header, ',');
                foreach ($dbdata as $row) {
                    fputcsv($handle, $row, ',');
                }
                fclose($handle);
                

            }
            $dbdata = array();
            $header = null;
            */
                


        }
        dd($dbdata, $header);

        

        if (($handle = fopen(public_path('csv/actions/Reports_AN/'.'action_'.strval($id-1).'.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header)
                {
                    $header = $row;
                }

                else
                {
                    $dbdata[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        //$questions = Actions_question::select("id" , "name")->get()->toArray();
        
        
        
        dd($dbdata, $header);

        $actions = Action::select("id" , "name", "type", "description" )->get()->toArray();
        
        $answers = Action_got_answer::select("id" , "actions_id", "actions_questions_id" )->get()->toArray();
         

        $handle = fopen(public_path('csv/actions/action.csv'), 'w');
        fputcsv($handle, ["id" , "name", "type", "description"], ',');
        foreach ($actions as $row) {


            fputcsv($handle, $row, ',');
        }
        fclose($handle);
        $handle = fopen(public_path('csv/actions/Reports_AN2/'.'action_'.strval($j).'.csv'), 'w');
        fputcsv($handle, ["id" , "name", "label"], ',');
        foreach ($questions as $row) {


            fputcsv($handle, $row, ',');
        }
        fclose($handle);
        $handle = fopen(public_path('csv/actions/answer.csv'), 'w');
        fputcsv($handle, ["id" , "actions_id", "actions_questions_id"], ',');
        foreach ($answers as $row) {


            fputcsv($handle, $row, ',');
        }
        fclose($handle);
        dd($dbdata);
        
        
        

        foreach( $actions as $row){
            $usedquestions = Actions_question::select("id" , "id_action" )->where("id_action","regexp", $row['name'] )->get();
           
            foreach( $usedquestions as $question){
                //dd( $row , $question );

                Action_got_answer::create(['actions_id' => $row["id"], 'actions_questions_id' => $question["id"]]);
                }

            
            
            
            
            

        }
        dd($dbdata);

        
        

        $handle = fopen(public_path('csv/donationformated.csv'), 'w');
        fputcsv($handle, ["created",
        "volunteer_id",
        "volunteer_new_id",'amount','recurrent'], ',');
        foreach ($donationlist as $row) {


            fputcsv($handle, $row, ',');
        }
        fclose($handle);
        //dd($donationlist);
        

        foreach ($donationlist as $row) {
            if($row[4]=="true"){
                $row[4]=1;
            }else{
                $row[4]=0;
            }
            Volunteer_does_donation::insert(["donations_amount" => $row[3], "created_at" => $row[0], "volunteer_id" => $row[1], 'volunteer_new_id' => $row[2], "recurrent" =>$row[4]]);
            //dd($row);


           
        }
        dd($donationlist);

        $users = Email::select("email" , "volunteer_id" , 'volunteer_new_id')->get();
        //dd($users);
        $handle = fopen(public_path('csv/donationformated.csv'), 'w');

        

        

        foreach( $dbdata as $row){
            
            Phone::insertOrIgnore(["phone_number" => $row['phone'], "opt_in" => 1, "volunteer_id" => intval($row['volunteer_id']), 'volunteer_new_id' => intval($row['volunteer_new_id'])]);
            

            

        }
       


    
        


        foreach( $dbdata as $row){
            
            $found= Volunteer::select('id', 'fullname','new_id')->firstWhere('exel_id', $row['id']);
            
            if(is_null($found)){
                
                $found= Volunteer::select('id', 'fullname','new_id')->firstWhere('fullname', $row['fullname']);
                if(is_null($found)){
                    dd($found,$row);
                    
                    
                }
            }
            
            array_push($phonelist,[$row['phone'],$found->id,$found->new_id,0]);

            

            

        }

        $handle = fopen(public_path('csv/use/emailtablebis2.csv'), 'w');
        fputcsv($handle, ["phone",
        "volunteer_id",
        "volunteer_new_id",'opt_in'], ',');
        foreach ($phonelist as $row) {


            fputcsv($handle, $row, ',');
        }
        fclose($handle);
        dd($phonelist);
        dd($dbdata);




        if (($handle = fopen(public_path('csv/use/havemail.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header)
                {
                    $header = $row;
                    array_push($header,'fullname');
                }

                else
                {
                    $row['fullname']= $row[4].' '.$row[3];
                    $row['fullname']=preg_replace('%  %', ' ', $row['fullname']);
                    $row['fullname']=preg_replace('/\s+$/', '', $row['fullname']);
                    

                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        
        
        
        //dd($emaillist);

       

        
        
        $users = Volunteer::select("first_name",
        "last_name",
        "primary_address1",
        "primary_city",
        "primary_state",
        "primary_zip",
        "npa",
        "primary_country",
        "organizer",
        "volunteer_scale",
        "id")->get();
        //dd($users);
        $handle = fopen(public_path('csv/noco.csv'), 'w');

        foreach ($users as $row) {


            fputcsv($handle, $row->toArray(), ',');
        }
        fclose($handle);

        
        
        Phone::insertOrIgnore(["phone" => "test@hotmail.com", "opt_in" => 0, "volunteer_id" => 9, 'volunteer_new_id' => 4]);
        
        

       
        if (($handle = fopen(public_path('csv/use/nmail.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header2)
                {
                    $header2 = $row;
                    array_push($header2,'fullname');
                }

                else
                {
                    if($row[3]!=''&&' '){
                        
                    }
                    else{
                        $row['fullname'] =$row[4];
                        $row['fullname']=preg_replace('%  %', ' ', $row['fullname']);
                    }
                    
                    $dbdata[] = array_combine($header2, $row);
                }
                    
            }
            fclose($handle);
        }
        
        
        foreach($users as $user){
            
            $user->fullname =substr($user->fullname, 0, -1);
            
            $user->save();
           
        }
       
        
        

        
        
        $dbdata = Exel::select("id", 'email','npa','last_name','first_name','phone_number','rank',"organiser","primary_zip")
            ->get();

        
        
        
        
        foreach ($data as $row) {

            $row['amount'] = intval($row['amount']);
            if (in_array($row["email"], $emaillist)) {
                for ($x = 0; $x < count($construct); $x++) {
                    if ($row["email"] == $construct[$x]["email"]) {
                        $construct[$x]['amount'] +=  $row['amount'];
                    }
                }
            } else {
                array_push($emaillist, $row["email"]);
                array_push($construct, $row);
            }



            //return view('fail',[]);
        }
        

        //$construct = array_filter($construct, fn ($e) => ($e['amount_formatted'] >= 150));

        $handle = fopen(public_path('csv/doncf.csv'), 'w');
        fputcsv($handle, $header2, ',');
        foreach ($construct as $row) {
            fputcsv($handle, $row, ',');
        }
        
        $nbdata = Activist::where('donations_amount', '>=', 100)
            ->select("first_name", "last_name", "phone_number", 'email', 'primary_zip', "donations_amount", "last_donated_at")
            ->get();
        
        dd($nbdata);
        dd($construct);
    }
}

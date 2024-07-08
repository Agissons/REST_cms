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
use App\Models\Volunteer_use_group;
use App\Models\Next_move;
use App\Models\Call;
use App\Models\Campaign;
use App\Models\Phone;
use App\Models\Email;
use App\Models\Interaction_type;
use App\Models\Interaction;
use App\Models\Note;
use App\Models\Canal;
use App\Models\Canal_group;
use App\Models\Activist;
use Throwable;

use Illuminate\Support\Collection;

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

        if (($handle = fopen(public_path('csv/usedfile.csv'), 'r')) !== false) {
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

        //$data = DB::table('exels')->where('donations_amount','>=',200) 
        $data = DB::table('exels')->where('soutien', '=', 1)->orWhere('info', '=', 1)->orWhere(function (Builder $query) {
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
                    });
            })
            ->select(
                "id",
                "first_name",
                "last_name",
                "phone_number",
                "db",
                "primary_zip",
                "wa_enter_way",
                "wa_enter_date",
                "wa_exit_date",
                "wa2_enter_date",
                "wa2_exit_date",
                "wa3_enter_date",
                "wa3_exit_date",
                "appel",
                "info",
                "soutien",
                "donations_amount",
                "new_donations_amount",
                "rank",
                "organiser"
            )
            ->orderBy('soutien', 'desc')->orderBy('wa3_enter_date', 'desc')->orderBy('wa2_enter_date', 'desc')->orderBy('info', 'desc')
            ->get();
        //dd($data);

        $handle = fopen(public_path('csv/prio.csv'), 'w');
        fputcsv($handle, [
            'ID', 'Prénom', 'Nom', 'Numéro de téléphone', 'AN?', "Canton (selon NPA)",
            'Suivi des mouvements dans les groupes Whatsapp - Communauté générale', '', '', '', '', '', '',
            "Informations sur l'Appel", '', '', 'Informations concernant les Dons',
            '', 'Indications générale de suivi', '', '', '', '', ''
        ], ',');
        fputcsv($handle, [
            '', '', '', '', '', '', 'A! - Nos Transports Publics (Nos TP) (communauté)', '', '',
            'A! - Nos TP - Accueil', '', 'A! - Nos TP - Actions de terrain', '', 'signé ?', 'recevoir des infos',
            'soutenir activement', 'Somme dons précédents',
            'Montant du don pour la levée de fonds NTP', 'Statut du(/de la) membre', 'Personne en charge'
        ], ',');
        fputcsv($handle, [
            '', '', '', '', '', '', "Moyen d'entrée", "Date d'entrée", 'Date de sortie', "Date d'entrée", 'Date de sortie', "Date d'entrée",
            'Date de sortie', '', '', '', '', '', '', ''
        ], ',');
        foreach ($data as $row) {


            $collec = collect($row);
            if ($collec['wa_enter_date'] == '0000-00-00 00:00:00') {
                $collec['wa_enter_date'] = '';
            }
            if ($collec['wa_exit_date'] == '0000-00-00 00:00:00') {
                $collec['wa_exit_date'] = '';
            }
            if ($collec['wa2_enter_date'] == '0000-00-00 00:00:00') {
                $collec['wa2_enter_date'] = '';
            }
            if ($collec['wa2_exit_date'] == '0000-00-00 00:00:00') {
                $collec['wa2_exit_date'] = '';
            }
            if ($collec['wa3_enter_date'] == '0000-00-00 00:00:00') {
                $collec['wa3_enter_date'] = '';
            }
            if ($collec['wa3_exit_date'] == '0000-00-00 00:00:00') {
                $collec['wa3_exit_date'] = '';
            }
            if ($collec['db'] == 0) {

                $collec['db'] = 'non';
            } else {
                $collec['db'] = 'oui';
            }
            if ($collec['appel'] == 0) {
                $collec['appel'] = 'non';
            } else {
                $collec['appel'] = 'oui';
            }
            if ($collec['info'] == 0) {
                $collec['info'] = 'non';
            } else {
                $collec['info'] = 'oui';
            }
            if ($collec['soutien'] == 0) {
                $collec['soutien'] = 'non';
            } else {
                $collec['soutien'] = 'oui';
            }

            fputcsv($handle, $collec->toArray(), ',');
        }
        fclose($handle);
        dd($data);
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
    public function raisenowSynthesis()
    {

        $header2 = null;

        $data = array();
        $emaillist = array();
        $construct = array();

        if (($handle = fopen(public_path('csv/crowfunding.csv'), 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header2)
                    $header2 = $row;
                else
                    $data[] = array_combine($header2, $row);
            }
            fclose($handle);
        }

        foreach ($data as $row) {

            $row['amount_formatted'] = floatval($row['amount_formatted']);
            if (in_array($row["stored_customer_email"], $emaillist)) {
                for ($x = 0; $x < count($construct); $x++) {
                    if ($row["stored_customer_email"] == $construct[$x]["stored_customer_email"]) {
                        $construct[$x]['amount_formatted'] +=  $row['amount_formatted'];
                    }
                }
            } else {
                array_push($emaillist, $row["stored_customer_email"]);
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
        dd($construct);
        $nbdata = Activist::where('donations_amount', '>=', 200)
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
}

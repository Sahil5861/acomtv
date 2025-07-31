<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ClientUser;
use App\Models\AdminSuperAdminPlan;
use App\Models\Role;
use App\Models\UserPlanDetails;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\AdminPlan;
use App\Models\SadminPlan;
use App\Models\AdminWallet;
use App\Models\ResellerAdminPlan;
use App\Models\ResellerPlan;
use App\Models\ResellerWallet;
use App\Models\Userauth;
use DB; 
use App\Models\NetAdminWallet;

class ManageUser extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    /* Process ajax request */
    public function getUserList(Request $request)
    {

        $loggedUser = \Auth::user();
        // echo $loggedUser->id; exit();
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        if($loggedUser->role == 1){
            // Total records
            $totalRecords = ClientUser::select('count(*) as allcount')->count();
            $inactiveRecords = ClientUser::select('count(*) as allcount')->where('status','0')->whereNull('clientusers.deleted_at')->count();
            $activeRecords = ClientUser::select('count(*) as allcount')->where('status','1')->whereNull('clientusers.deleted_at')->count();
            $deletedRecords = ClientUser::select('count(*) as allcount')->whereNotNull('clientusers.deleted_at')->count();

            $totalRecordswithFilter = ClientUser::select('count(*) as allcount')

            ->where('clientusers.name', 'like', '%' . $searchValue . '%')

            ->orWhere(function($query) use ($searchValue,$loggedUser)
            {
                $query->where('clientusers.city', 'like', '%' . $searchValue . '%')
                ->whereNull('clientusers.deleted_at')
                ;

            })

            ->orWhere(function($query) use ($searchValue,$loggedUser)
            {
                $query->where('clientusers.email', 'like', '%' . $searchValue . '%')
                ->whereNull('clientusers.deleted_at')
                ;

            })

            ->orWhere(function($query) use ($searchValue,$loggedUser)
            {
                $query->where('clientusers.login_pin', 'like', '%' . $searchValue . '%')
                ->whereNull('clientusers.deleted_at')
                ;

            })

            ->orWhere(function($query)  use ($searchValue,$loggedUser)
            {
                $query->Where('clientusers.mobile', 'like', '%' . $searchValue . '%')
                ->whereNull('clientusers.deleted_at')
                ;

            })
            ->count();

            // Get records, also we have included search filter as well
            $records = ClientUser::orderBy($columnName, $columnSortOrder)
            // ->leftJoin('userauths','userauths.user_id','=','clientusers.id')
            ->whereNull('clientusers.deleted_at')
            ->where('clientusers.name', 'like', '%' . $searchValue . '%')
            ->whereNull('clientusers.deleted_at')
            ->orWhere(function($query) use ($searchValue,$loggedUser)
            {
                $query->where('clientusers.city', 'like', '%' . $searchValue . '%')
                ->whereNull('clientusers.deleted_at')
                ;

            })

            ->orWhere(function($query)  use ($searchValue,$loggedUser)
            {
                $query->Where('clientusers.mobile', 'like', '%' . $searchValue . '%')
                ->whereNull('clientusers.deleted_at')
                ;

            })
            ->orWhere(function($query)  use ($searchValue,$loggedUser)
            {
                $query->Where('clientusers.email', 'like', '%' . $searchValue . '%')
                ->whereNull('clientusers.deleted_at')
                ;

            })


            // ->orWhere('Users.description', 'like', '%' . $searchValue . '%')
            // ->orWhere('Users.contact_email', 'like', '%' . $searchValue . '%')
            ->select('clientusers.*', DB::Raw("(select userauths.ip_address from userauths where userauths.user_id = clientusers.id order by userauths.id desc limit 1) as ip_address"))
            // ->leftJoin('users', 'clientusers.id', '=', 'Channel.user_id')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        }else{
            // Total records
            $totalRecords = ClientUser::select('count(*) as allcount')->where('clientusers.created_by',$loggedUser->id)->whereNull('clientusers.deleted_at')->count();
            $inactiveRecords = ClientUser::select('count(*) as allcount')->where('clientusers.created_by',$loggedUser->id)->where('status','0')->whereNull('clientusers.deleted_at')->count();
            $activeRecords = ClientUser::select('count(*) as allcount')->where('clientusers.created_by',$loggedUser->id)->where('status','1')->whereNull('clientusers.deleted_at')->count();
            $deletedRecords = ClientUser::select('count(*) as allcount')->where('clientusers.created_by',$loggedUser->id)->whereNotNull('clientusers.deleted_at')->count();

            $totalRecordswithFilter = ClientUser::select('count(*) as allcount')
            ->where('clientusers.created_by',$loggedUser->id)
            ->where('name', 'like', '%' . $searchValue . '%')

            ->orWhere(function($query) use ($searchValue,$loggedUser)
            {
                $query->where('clientusers.city', 'like', '%' . $searchValue . '%')
                ->whereNull('clientusers.deleted_at')
                ->where('clientusers.created_by',$loggedUser->id);

            })

            ->orWhere(function($query) use ($searchValue,$loggedUser)
            {
                $query->where('clientusers.login_pin', 'like', '%' . $searchValue . '%')
                ->whereNull('clientusers.deleted_at')
                ->where('clientusers.created_by',$loggedUser->id);

            })

            ->orWhere(function($query) use ($searchValue,$loggedUser)
            {
                $query->where('clientusers.email', 'like', '%' . $searchValue . '%')
                ->whereNull('clientusers.deleted_at')
                ->where('clientusers.created_by',$loggedUser->id);

            })

            ->orWhere(function($query)  use ($searchValue,$loggedUser)
            {
                $query->Where('clientusers.mobile', 'like', '%' . $searchValue . '%')   
                ->whereNull('clientusers.deleted_at')
                ->where('clientusers.created_by',$loggedUser->id);

            })
            ->count();

            // Get records, also we have included search filter as well
            $records = ClientUser::orderBy($columnName, $columnSortOrder)
            // ->leftJoin('userauths','userauths.user_id','=','clientusers.id')
            ->where('clientusers.created_by',$loggedUser->id)
            ->whereNull('clientusers.deleted_at')
            ->where('clientusers.name', 'like', '%' . $searchValue . '%')
            ->whereNull('clientusers.deleted_at')
            ->orWhere(function($query) use ($searchValue,$loggedUser)
            {
                $query->where('clientusers.city', 'like', '%' . $searchValue . '%')
                ->whereNull('clientusers.deleted_at')
                ->where('clientusers.created_by',$loggedUser->id);

            })

            ->orWhere(function($query)  use ($searchValue,$loggedUser)
            {
                $query->Where('clientusers.mobile', 'like', '%' . $searchValue . '%')
                ->whereNull('clientusers.deleted_at')
                ->where('clientusers.created_by',$loggedUser->id);

            })
            ->orWhere(function($query)  use ($searchValue,$loggedUser)
            {
                $query->Where('clientusers.login_pin', 'like', '%' . $searchValue . '%')
                ->whereNull('clientusers.deleted_at')
                ->where('clientusers.created_by',$loggedUser->id);

            })
            ->orWhere(function($query)  use ($searchValue,$loggedUser)
            {
                $query->Where('clientusers.email', 'like', '%' . $searchValue . '%')
                ->whereNull('clientusers.deleted_at')
                ->where('clientusers.created_by',$loggedUser->id);

            })


            // ->orWhere('Users.description', 'like', '%' . $searchValue . '%')
            // ->orWhere('Users.contact_email', 'like', '%' . $searchValue . '%')
            ->select('clientusers.*', DB::Raw("(select userauths.ip_address from userauths where userauths.user_id = clientusers.id order by userauths.id desc limit 1) as ip_address"))
            // ->leftJoin('users', 'clientusers.id', '=', 'Channel.user_id')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        }

        $data_arr = array();

        foreach ($records as $record) {
            if($record->status == 1){
                $status = '<a onchange="updateStatus(\''.url('user/update-status',base64_encode($record->id)).'\')" href="javascript:void(0);"><label class="switch s-primary mr-2"><input type="checkbox" value="1" checked id="accountSwitch{{$record->id}}"><span class="slider round"></span></label> </a>';
            }else{
                $status = '<a onchange="updateStatus(\''.url('user/update-status',base64_encode($record->id)).'\')" href="javascript:void(0);"><label class="switch s-primary   mr-2"><input type="checkbox" value="0" id="accountSwitch{{$record->id}}"><span class="slider round"></span></label></a>';
            }
            if(\Auth::user()->role==1){
                $action = '<div class="action-btn">
                                <a  href="user-history/'.base64_encode($record->id).'"><i class="fa fa-history" aria-hidden="true"></i></a>
                                <a href="javascript:;" onclick="delete_item(\''.base64_encode($record->id).'\',\'user\')"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
                            </div>';
            }else{
                $action =    '<div class="action-btn">
                                    <a  href="edit-user/'.base64_encode($record->id).'"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                                    <a  href="user-history/'.base64_encode($record->id).'"><i class="fa fa-history" aria-hidden="true"></i></a>
                                    <a href="javascript:;" onclick="delete_item(\''.base64_encode($record->id).'\',\'user\')"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
                                </div>';
            }
            $data_arr[] = array(
                "name" => $record->name,
                "email" => $record->email,
                "mobile" => $record->mobile,
                "wallet_amount" => $record->current_amount,
                "address" => $record->address,
                "ip_address" => $record->mac_address,
                "login_pin" => $record->login_pin,
                "city" => $record->city,
                "country" => $record->country,
                "company_name" => $record->company_name,
                "status" => $status,
                "created_at" => date('j M Y h:i a',strtotime($record->created_at)),
                "action" => $action,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
            "totalRecords" => number_format($totalRecords),
            "activeRecords" => number_format($activeRecords),
            "inactiveRecords" => number_format($inactiveRecords),
            "deletedRecords" => number_format($deletedRecords),
        );

        echo json_encode($response);
    }

    public function addUser(){
        $this->data['roles'] = Role::where('status',1)->get();
        $this->data['packages'] = AdminPlan::where('user_id',\Auth::user()->id)->where('status',1)->get();
        return view('admin.user.add',$this->data);
    }

    public function updateStatus($id){
        $user = ClientUser::find(base64_decode($id));
        if($user){
            $user->status = $user->status == '1' ? '0' : '1';
            $user->save();
            echo json_encode(['message','User status successfully']);
        }else{
            echo json_encode(['message','Something went wrong!!']);
        }
    }


    public function add(Request $request){
        $request->validate([
            'name' => 'required',
            // 'email' => 'required|email',
            'mobile' => 'required',
            // 'address' => 'required',
            // 'password' => 'required',
            // 'role' => 'required',
            // 'country' => 'required',
            // 'city' => 'required',
            // 'hf_number' => 'required',
            // 'street_number' => 'required',
            // 'pincode' => 'required',
            // 'company_name' => 'required',
        ]);

        if(!empty($request->id)){
            $emailExists = ClientUser::where('email',$request->email)->where('created_by',\Auth::user()->id)->where('id','!=',$request->id)->whereNull('deleted_at')->first();
            if($emailExists){
                return back()->with('error','This email already exists.');
            }
            $user = ClientUser::firstwhere('id',$request->id);

            $real_password = $request->password;
            $password = bcrypt($real_password);
            // $password = md5($hash_pass1);

            $user->name = $request->name;
            $user->email = $request->email ?? '';
            $user->mobile = $request->mobile;
            $user->address = $request->address ?? '';
            $user->hf_number = $request->hf_number ?? '';
            $user->street_number = $request->street_number ?? '';
            $user->landmark = $request->landmark ?? '';
            $user->country = $request->country ?? '';
            $user->city = $request->city ?? '';
            $user->pincode = $request->pincode ?? '';
            $user->created_by = \Auth::user()->id;
            $user->created_by_role = (\Auth::user()->role == 6) ? 'netadmin' : '';
            if($request->updatePin){
                $user->login_pin = User::generateLoginPin();
                $user->mac_address = '';
                Userauth::where('user_id', $request->id)->update(['status'=> 0]);
            }

            if($request->updateAppPin){
                $user->login_pin_app = User::generateLoginAppPin();  
                $user->mac_address_app = '';   
                Userauth::where('user_id', $request->id)->update(['status'=> 0]);           
            }

            if($request->updateOver18Pin){
                $user->over18_pin = User::generateOver18Pin();                 
            }
            // $user->password = $real_password;
            // $user->user_plan_id = $user_plan;
            $user->real_password = $real_password;
            $user->role = 4;
            $user->status = $request->status;
            if($user->save()){

                if($request->wallet_amount){
                    $admin = User::find(\Auth::user()->id);
                    if($admin->current_amount < $request->wallet_amount){
                        return back()->with('error','Insufficient Amount!!');
                    }
                    $admin->current_amount = $admin->current_amount - $request->wallet_amount;
                    // $admin->save();

                    $wallet = (\Auth::user()->role == 2) ? new AdminWallet() : ((\Auth::user()->role == 3) ? new ResellerWallet() : new NetAdminWallet());
                    $wallet->debit_amount = $request->wallet_amount;
                    $wallet->user_id = $user->id;
                    $wallet->message = "Add amount in wallet for user (".$user->email.")";
                    $wallet->credit_amount_by = \Auth::user()->id;
                    $wallet->save();

                    $wallet = new UserWallet();
                    $wallet->credit_amount = $request->wallet_amount;
                    $wallet->user_id = $user->id;
                    $wallet->message = "Add recieve from admin in wallet (".$user->email.")";
                    $wallet->credit_amount_by = \Auth::user()->id;
                    $wallet->save();

                    $user->current_amount = $user->current_amount + $request->wallet_amount;
                    $user->save();
                }

                if($request->user_plan){

                    /***************************For Wallet Checking**********************************************/
                    $user_purchase_price = 0;
                    foreach ($request->user_plan as $key => $value) {
                        if(($value == 1000 || $value > 1000) && $value < 10000){ //superadmin plan_id started from 1000
                            $planDetails = SadminPlan::find($value);
                            if(\Auth::user()->role == 6){
                                $user_purchase_price +=  $planDetails->net_admin_price;
                            }else{
                                $user_purchase_price +=  $planDetails->price;
                            }
                        }else{
                            if(\Auth::user()->role == 2){ //admin plan_id started from 10000
                                $planDetails = AdminPlan::find($value);
                            }else{
                                $planDetails = ResellerPlan::find($value);
                            }        
                            $user_purchase_price +=  $planDetails->total_price;
                        }
                    }
                    if(\Auth::user()->role == 6){
                        if($user_purchase_price > \Auth::user()->current_amount){
                            return back()->with('error',"Your wallet amount is less than ".$user_purchase_price.". Recharge customer's wallet.");
                        }
                    }
                    if($user_purchase_price > $user->current_amount){
                        return back()->with('error',"Customer's wallet amount is less than ".$user_purchase_price.". Recharge customer's wallet.");
                    }

                    /***************************For Wallet Checking End**********************************************/

                    
                    foreach ($request->user_plan as $key => $value) {
                        // $planCost = $this->getSadminPrice($value, \Auth::user()->role);
                        if(($value == 1000 || $value > 1000) && $value < 10000){ //superadmin plan_id started from 1000
                            $planDetails = SadminPlan::find($value);
                            if(\Auth::user()->role == 6){
                                $price = $planDetails->net_admin_price;
                            }else{
                                $price = $planDetails->price;
                            }
                        }else{
                            if(\Auth::user()->role == 2){ //admin plan_id started from 10000
                                $planDetails = AdminPlan::find($value);
                            }else{
                                $planDetails = ResellerPlan::find($value);
                            }        
                            $price = $planDetails->total_price;
                        }

                        $plan = new UserPlanDetails();
                        $plan->user_id = $user->id;
                        $plan->plan_id = $value; //superadmin plan_id started from 1000.
                        $plan->plan_original_price = $price; // super admin price
                        $plan->plan_validity = $planDetails->plan_validity;
                        $plan->role = ((\Auth::user()->role == 2) ? 'admin': ((\Auth::user()->role == 3) ? 'reseller': 'netadmin'));

                        $plan->plan_purchase_price = $price;
                        // $plan->plan_profite_percentage = (($user_purchase_price - $planCost)/$planCost)*100;
                        $plan->plan_purchased_by = \Auth::user()->id;
                        $plan_end_date=Date('Y-m-d H:i:s', strtotime('+'.$planDetails->plan_validity.' days'));
                        $plan->plan_end_date = $plan_end_date;
                        $plan->status = 1;
                        $plan->save();

                        if(\Auth::user()->role == 6){
                            User::where('id',\Auth::user()->id)->update(['current_amount'=> (\Auth::user()->current_amount - $price)]);
                            $wallet = new NetAdminWallet();
                            $wallet->debit_amount = $price;
                            $wallet->user_id = $user->id;
                            $wallet->message = "Assign plan to user (".$user->email.")";
                            $wallet->credit_amount_by = \Auth::user()->id;
                            $wallet->save();
                        }
                    }
                    
                    $wallet = new UserWallet();
                    $wallet->debit_amount = $user_purchase_price;
                    $wallet->user_id = $user->id;
                    $wallet->message = "Plan purchased by wallet amount (".$user->email.")";
                    $wallet->credit_amount_by = \Auth::user()->id;
                    $wallet->save();

                    $user->current_amount = $user->current_amount - $user_purchase_price;
                    $user->save();


                }
                return back()->with('message','User updated successfully');
            }else{
                return back()->with('message','User not updated successfully');
            }

        }else{
            $emailExists = ClientUser::where('email',$request->email)->where('created_by',\Auth::user()->id)->whereNull('deleted_at')->first();
            // print_r($emailExists); exit;
            if($emailExists){
                return back()->with('error','This email already exists.');
            }

            // print_r($request->all()); exit;
            $user = new ClientUser();
            $real_password = $request->password;
            $password = bcrypt($real_password);
            // $password = md5($hash_pass1);

            $user->name = $request->name;
            $user->email = $request->email ?? '';
            $user->mobile = $request->mobile;
            $user->address = $request->address ?? '';
            $user->hf_number = $request->hf_number ?? '';
            $user->street_number = $request->street_number ?? '';
            $user->landmark = $request->landmark ?? '';
            $user->country = $request->country ?? '';
            $user->city = $request->city ?? '';
            $user->pincode = $request->pincode ?? '';
            $user->created_by = \Auth::user()->id;
            $user->created_by_role = (\Auth::user()->role == 6) ? 'netadmin' : '';

            $user->current_amount = 0;
            $user->password = $password;
            $user->real_password = $real_password;
            $user->role = 4;
            $user->status = $request->status;
            if($user->save()){

                if($request->wallet_amount){
                    $admin = User::find(\Auth::user()->id);
                    if($admin->current_amount < $request->wallet_amount){
                        return back()->with('error','Insufficient Amount!!');
                    }
                    $admin->current_amount = $admin->current_amount - $request->wallet_amount;
                    $admin->save();

                    if(\Auth::user()->role == 2){
                        $wallet = new AdminWallet();
                        $wallet->debit_amount = $request->wallet_amount;
                        $wallet->user_id = $user->id;
                        $wallet->message = "Add amount in wallet for user (".$user->email.")";
                        $wallet->credit_amount_by = \Auth::user()->id;
                        $wallet->save();
                    }elseif(\Auth::user()->role == 3){
                        $wallet = new ResellerWallet();
                        $wallet->debit_amount = $request->wallet_amount;
                        $wallet->user_id = $user->id;
                        $wallet->message = "Add amount in wallet for user (".$user->email.")";
                        $wallet->credit_amount_by = \Auth::user()->id;
                        $wallet->save();
                    }else{
                        $wallet = new NetAdminWallet();
                        $wallet->debit_amount = $request->wallet_amount;
                        $wallet->user_id = $user->id;
                        $wallet->message = "Add amount in wallet for user (".$user->email.")";
                        $wallet->credit_amount_by = \Auth::user()->id;
                        $wallet->save();
                    }

                    $wallet = new UserWallet();
                    $wallet->credit_amount = $request->wallet_amount;
                    $wallet->user_id = $user->id;
                    $wallet->message = "Add recieve from admin in wallet (".$user->email.")";
                    $wallet->credit_amount_by = \Auth::user()->id;
                    $wallet->save();
                    $user->current_amount = $user->current_amount + $request->wallet_amount;
                }

                $user->login_pin = User::generateLoginPin();
                //
                $user->save();
                return back()->with('message','User added successfully');
            }else{
                return back()->with('message','User not added successfully');
            }
        }

    }

    public function editUser($id){
        // $userPlan = UserPlanDetails::where('user_plan_details.user_id',base64_decode($id))->where('user_plan_details.status',1)->leftJoin('super_admin_plans','super_admin_plans.id','=','user_plan_details.plan_id')->get();
        $plans = array();
        $existing_plan = array();
        $userPlan = UserPlanDetails::where('user_plan_details.user_id',base64_decode($id))->whereDate('plan_end_date','>=',date('Y-m-d'))->where('user_plan_details.status',1)->get();
        foreach ($userPlan as $key => $value) {
            array_push($existing_plan, $value->plan_id);
            if(($value->plan_id == 1000 || $value->plan_id > 1000) && ($value->plan_id < 10000)){
                $plans[] = SAdminPlan::where('status',1)->where('id',$value->plan_id)->whereNull('deleted_at')->first();
            }else{
                if($value->role == 'admin'){
                    $plans[] = AdminPlan::where('status',1)->where('id',$value->plan_id)->whereNull('deleted_at')->first();
                }else{
                    $plans[] = ResellerPlan::where('status',1)->where('id',$value->plan_id)->whereNull('deleted_at')->first();
                }
            }
        }
        // echo "<pre>";
        // print_r($existing_plan); exit;
        $this->data['user'] = ClientUser::where('id',base64_decode($id))->first();
        $this->data['userPlan'] = $plans;
        // print_r($this->data['userPlan']); exit;
        $this->data['roles'] = Role::where('status',1)->get();
        $packages = array();
        $sadminPackages = SAdminPlan::where('status',1)->where('plan_type',1)->whereNotIn('id',$existing_plan)->whereNull('deleted_at')->get();
        foreach ($sadminPackages as $key => $value) {
            $packages[] = array(
                'id' => $value->id, 
                'title' => $value->title,
                'total_price' => $value->price,
            );
        }
        if(\Auth::user()->role == 2){
            $plans = AdminPlan::where('user_id',\Auth::user()->id)->where('status',1)->whereNotIn('id',$existing_plan)->whereNull('admin_plans.deleted_at')->get();
        }elseif(\Auth::user()->role == 3){
            $plans = ResellerPlan::where('user_id',\Auth::user()->id)->where('status',1)->whereNotIn('id',$existing_plan)->whereNull('reseller_plans.deleted_at')->get();
        }elseif(\Auth::user()->role == 6){
            $plans = DB::select("SELECT sa.title, sa.id, sa.net_admin_price as total_price FROM netadmin_plans_details np LEFT JOIN super_admin_plans sa ON sa.id = np.plan_id WHERE np.user_id = ".\Auth::user()->id);
        }
        foreach ($plans as $key => $value) {
            $packages[] = array(
                'id' => $value->id, 
                'title' => $value->title,
                'total_price' => $value->total_price,
            );
        }
        $this->data['packages'] = $packages;
        // print_r($this->data['packages']); exit;
        return view('admin.user.add',$this->data);
    }

    public function userHistory($id){
        $id = base64_decode($id);
        $this->data['user'] = ClientUser::where('id',$id)->first();
        $this->data['authusers'] = Userauth::where('user_id',$id)->where('type', 'tv')->orderBy('id','desc')->get();
        $this->data['authusers_app'] = Userauth::where('user_id',$id)->where('type', 'app')->orderBy('id','desc')->get();

        $userPlanDetails = UserPlanDetails::select('user_plan_details.*','clientusers.name','clientusers.mac_address','clientusers.updated_at')->leftJoin('clientusers','clientusers.id','=','user_plan_details.user_id')->where('user_plan_details.user_id',$id)->orderBy('user_plan_details.status','desc')->get();
        if(isset($userPlanDetails[0]->id)){
            foreach ($userPlanDetails as $key => $value) {
                if(($value->plan_id == 1000 || $value->plan_id > 1000) && ($value->plan_id < 10000)){
                    $planDetails = SadminPlan::where('id',$value->plan_id)->first();
                }else{
                    $checkRole = User::where('id',$value->plan_purchased_by)->first();
                    if($checkRole->role == 2){
                        $planDetails = AdminPlan::where('user_id',$checkRole->id)->where('id',$value->plan_id)->first();
                    }else{
                        $planDetails = ResellerPlan::where('user_id',$checkRole->id)->where('id',$value->plan_id)->first();
                    }
                }

                $this->data['user_plan_details'][] = array(
                    'username' => $value->name,
                    'mac_address' => $value->mac_address,
                    'updated_at' => $value->updated_at,
                    'plan_purchase_price' => $value->plan_purchase_price,
                    'plan' => isset($planDetails->title) ? $planDetails->title : '',
                    'plan_purchased_by' => isset($checkRole->name) ? $checkRole->name : '',
                    'plan_purchased_date' => $value->purchased_date,
                    'plan_end_date' => $value->plan_end_date,
                    'plan_validity' => $value->plan_validity,
                    'status' => ($value->status == 1) ? '<span class="text-success">Active</span>' : '<span class="text-secondary">Inactive</span>',
                );
            }
        }else{
            $this->data['user_plan_details'] = array();
        }

        return view('admin.user.history',$this->data);
    }

    public function checkWalletAdmin(Request $request){
        $plan_id =  $request->plan_id;
        $user_id =  $request->id;
        if(isset($request->plan_id) && $plan_id != ''){
            $user = ClientUser::find($user_id);
            $Plans = AdminPlan::where('id',$plan_id)->first();
            $superAdminPlans = SAdminPlan::where('id',$plan_id)->first();

            if($superAdminPlans){
                $planCost = $this->getSadminPrice($plan_id,2);
                $user_purchase_price = $this->getDiscountValue($superAdminPlans);
                $user_purchase_price = $user_purchase_price + $Plans->profit_price;
                if($user_purchase_price > $user->current_amount){
                    print_r(json_encode(array("status"=>true,"msg"=>"Customer's wallet amount is less than ".$user_purchase_price.". Recharge customer's wallet.")));
                    // wallet amount is less
                    exit;
                }else{
                    print_r(json_encode(array("status"=>false,"msg"=>"Balance is available in wallet.")));
                    exit;
                }
            }else{
                print_r(json_encode(array("status"=>false,"msg"=>"plan id is invalid.")));
            exit;
            }
        }else{
            print_r(json_encode(array("status"=>false,"msg"=>"plan id is missing.")));
            exit;
        }

    }

    public function getSadminPrice($admin_plan_id, $role)
    {
        $price = 0; 
        if($role == 2){
            $sAdminPlans = AdminSuperAdminPlan::select('super_admin_plans.*')->where('admin_super_admin_plans.admin_plan_id',$admin_plan_id)->leftJoin('super_admin_plans','super_admin_plans.id','=','admin_super_admin_plans.super_admin_plan_id')->get();
        }else{
            $sAdminPlans = ResellerAdminPlan::select('admin_plans.*')->leftJoin('admin_plans','admin_plans.id','=','reseller_admin_plans.admin_plan_id')->where('reseller_admin_plans.reseller_plan_id',$admin_plan_id)->get();
        }
        
        foreach ($sAdminPlans as $key => $relation) {
            $price = $relation->total_price + $price;
        }

        return $price;
    }

    public function destroy(Request $request){
        $user = ClientUser::where('id',base64_decode($request->id))->first();
        $user->deleted_at = time();
        if($user->save()){
            echo json_encode(['message','User deleted successfully']);
        }else{
            echo json_encode(['message','User not deleted successfully']);
        }
    }

    public function checkEmail(Request $request){
        $email = $request->email;
        $check = ClientUser::where('email',$email)->whereNull('deleted_at')->first();
        if($check){
            return false;
        }else{
            return true;
        }
    }
}

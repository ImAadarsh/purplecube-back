<?php

namespace App\Http\Controllers;

use App\Models\Betaform;
use App\Models\Contact;
use App\Models\Download;
use App\Models\Email;
use App\Models\Member;
use App\Models\Partner;
use App\Models\Resource;
use App\Notifications\AdvisoryNotification;
use App\Notifications\BetaFormVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use App\Notifications\ContactNotification;
use App\Notifications\DownloadNotification;
use App\Notifications\EmailNotification;
use App\Notifications\PartnershipNotification;
use App\Notifications\ResourceAccessForm;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

function callAPI($data){
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://accounts.zoho.com/oauth/v2/token',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('client_id' => '1000.NHVIRWECREWUIOP6QEPWE13PTDLGWA','client_secret' => 'babad4b7ac2764501a9ebacb0a5c687be04208a6cc','refresh_token' => '1000.61d8b30da8e16d5ad6f8338007b94ac5.6273d605decb72c1102d972949180ee1','grant_type' => 'refresh_token'),
    CURLOPT_HTTPHEADER => array(
        'Cookie: JSESSIONID=93028ACD709B6F6D4DA6C1ED25F526F6; _zcsr_tmp=33949c6b-577b-43b7-9fd8-c0a1a4569cd6; b266a5bf57=9f371135a524e2d1f51eb9f41fa26c60; e188bc05fe=412d04ceb86ecaf57aa7a1d4903c681d; iamcsr=33949c6b-577b-43b7-9fd8-c0a1a4569cd6'
    ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $data1 = json_decode($response, true);
    $token = $data1['access_token'];

    $method = "POST";
    $token = "Authorization: Bearer ".$token."";
    $url = 'https://www.zohoapis.com/crm/v2/Leads';
    $curl = curl_init($url);
    switch ($method){
       case "POST":
          curl_setopt($curl, CURLOPT_POST, 1);
          if ($data)
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          break;
       case "PUT":
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
          if ($data)
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
          break;
       case "DELETE":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");		 					
            break;
       default:
          if ($data)
             $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       'Content-Type: application/json',
       $token
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_BINARYTRANSFER,TRUE);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTE:
    $result = curl_exec($curl);
    // echo $result;
    if(!$result){echo curl_error($curl);}
    curl_close($curl);
    return $result;
 }
 function callAPI1($list,$email){
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://accounts.zoho.com/oauth/v2/token',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('client_id' => '1000.NHVIRWECREWUIOP6QEPWE13PTDLGWA','client_secret' => 'babad4b7ac2764501a9ebacb0a5c687be04208a6cc','refresh_token' => '1000.5f38181886086cbd82326654d61aa7b5.417c26d42488ba4c98bda210a3a0be90','grant_type' => 'refresh_token'),
    CURLOPT_HTTPHEADER => array(
        'Cookie: JSESSIONID=93028ACD709B6F6D4DA6C1ED25F526F6; _zcsr_tmp=33949c6b-577b-43b7-9fd8-c0a1a4569cd6; b266a5bf57=9f371135a524e2d1f51eb9f41fa26c60; e188bc05fe=412d04ceb86ecaf57aa7a1d4903c681d; iamcsr=33949c6b-577b-43b7-9fd8-c0a1a4569cd6'
    ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $data1 = json_decode($response, true);
    $token = $data1['access_token'];

    $method = "POST";
    $token = "Authorization: Bearer ".$token."";
    $url = 'https://www.zohoapis.com/crm/v2/Leads';
    $content = "listkey=".$list."&emailids=".$email;
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://campaigns.zoho.com/api/v1.1/addlistsubscribersinbulk',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => $content,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded',
    $token,
    'Cookie: 805f8c68aa=4402ff4f2f194db3c7fa8fde4b2a9adc; JSESSIONID=62DAEA388E9201587AE3BBCD29D28812; ZCAMPAIGN_CSRF_TOKEN=d5a84041-f10c-40dc-94f9-2ad477f29ebd; _zcsr_tmp=d5a84041-f10c-40dc-94f9-2ad477f29ebd'
  ),
));

$response = curl_exec($curl);
curl_close($curl);
// echo $response;
 }

class Admin extends Controller
{
    public function getToken(){
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://accounts.zoho.com/oauth/v2/token',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('client_id' => '1000.NHVIRWECREWUIOP6QEPWE13PTDLGWA','client_secret' => 'babad4b7ac2764501a9ebacb0a5c687be04208a6cc','refresh_token' => '1000.61d8b30da8e16d5ad6f8338007b94ac5.6273d605decb72c1102d972949180ee1','grant_type' => 'refresh_token'),
    CURLOPT_HTTPHEADER => array(
        'Cookie: JSESSIONID=93028ACD709B6F6D4DA6C1ED25F526F6; _zcsr_tmp=33949c6b-577b-43b7-9fd8-c0a1a4569cd6; b266a5bf57=9f371135a524e2d1f51eb9f41fa26c60; e188bc05fe=412d04ceb86ecaf57aa7a1d4903c681d; iamcsr=33949c6b-577b-43b7-9fd8-c0a1a4569cd6'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $data = json_decode($response, true);
    $token = "'Authorization: Bearer ".$data['access_token']."'";
    return $token;

    }

   
   public function contactForm(Request $request)
{
    $rules = array(
       
    );

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response(["status" => false, "message" => "Validation failed.", "errors" => $validator->errors()], 422);
    }

    try {
        $data_array = [
            "data" => [
                [
                    "Owner" => [
                        "id" => "665758951"
                    ],
                    "Last_Name" => $request->last_name,
                    "Email" => $request->email,
                    "First_Name" => $request->first_name,
                    "Lead_Status" => "Attempted to Contact",
                    "Company" => $request->organization_name,
                    "Email_Opt_Out" => false,
                    "Designation" => $request->current_role,
                    "Currently_using_which_platform" => $request->tools,
                    "Key_metrics_and_outcome" =>$request->outcomes,
                    "Challenges_Your_Organization_Face" =>$request->challenges,
                    "Desired_timeline_to_implement_tool" =>$request->timeline,
                    "Estimated_budget" => $request->budget,
                    "Mobile" => $request->mobile,
                    "Lead_Source" => "Contact Form",
                    "trigger" => [
                         "approval",
    "workflow",
    "blueprint",
    "pathfinder",
    "orchestration"
                        ]
                ]
            ]
        ];
        // "No_of_Employees" => 1791,
        $r = callAPI(json_encode($data_array,true));  
        // $s = callAPI1("3z97a4db966d089ae9f8622b3b351ac97a94f454ee6269617785e033bf09591640",$request->email);     
        
    if (true) {
            $user = new Contact();
            $user->first_name = $request->first_name; // Use first_name instead of name
            $user->last_name = $request->last_name; // If you don't have last_name in the request, set it to an appropriate value
            $user->email = $request->email;
            $user->organization_name = $request->organization_name;
            $user->mobile = $request->mobile; // Use mobile instead of contact
            $user->current_role = $request->current_role; // Set an appropriate value for current_role
            $user->tools = $request->tools; // Set an appropriate value for tools
            $user->challenges = $request->challenges; // Set an appropriate value for challenges
            $user->outcomes = $request->outcomes; // Set an appropriate value for outcomes
            $user->timeline = $request->timeline; // Set an appropriate value for timeline
            $user->budget = $request->budget; // Set an appropriate value for budget
            $user->overview = $request->overview; // Set an appropriate value for overview
            $user->save();

            $emailData = [
                'name' => $request->name,
                'email' => $request->email,
                'organization_name' => $request->organization_name,
                'job_title' => $request->job_title,
                'country' => $request->country,
                'message' => $request->message,
                'contact' => $request->contact,
            ];

            FacadesNotification::route('mail', 'kirsten.kopke@purplecube.ai')->notify(new ContactNotification($emailData));
            return response(["status" => true, "message" => "Contact is successfully submitted."], 200);
    }
    }
    catch (\Exception $e) {
        return response(["status" => false, "message" => "Please Try with  Another Email. Looks like you have already filled this email id.", "error" => $e->getMessage()], 500);
    }


    
}

   public function FreeTrail(Request $request)
{
    $rules = array(
       
    );

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response(["status" => false, "message" => "Validation failed.", "errors" => $validator->errors()], 422);
    }

    try {
        $data_array = [
            "data" => [
                [
                    "Owner" => [
                        "id" => "665758951"
                    ],
                    "Last_Name" => $request->last_name,
                    "Email" => $request->email,
                    "First_Name" => $request->first_name,
                    "Lead_Status" => "Attempted to Free Trail",
                    "Company" => $request->organization_name,
                    "Email_Opt_Out" => false,
                    "Designation" => $request->current_role,
                    "Currently_using_which_platform" => $request->tools,
                    "Key_metrics_and_outcome" =>$request->outcomes,
                    "Challenges_Your_Organization_Face" =>$request->challenges,
                    "Desired_timeline_to_implement_tool" =>$request->timeline,
                    "Estimated_budget" => $request->budget,
                    "Mobile" => $request->mobile,
                    "Lead_Source" => "Email Form",
                    "trigger" => [
                         "approval",
    "workflow",
    "blueprint",
    "pathfinder",
    "orchestration"
                        ]
                ]
            ]
        ];
        // "No_of_Employees" => 1791,
        $r = callAPI(json_encode($data_array,true));  
        // $s = callAPI1("3z97a4db966d089ae9f8622b3b351ac97a94f454ee6269617785e033bf09591640",$request->email);     
        
    if (true) {
            $user = new Contact();
            $user->first_name = $request->first_name; // Use first_name instead of name
            $user->last_name = $request->last_name; // If you don't have last_name in the request, set it to an appropriate value
            $user->email = $request->email;
            $user->organization_name = $request->organization_name;
            $user->mobile = $request->mobile; // Use mobile instead of contact
            $user->current_role = $request->current_role; // Set an appropriate value for current_role
            $user->tools = $request->tools; // Set an appropriate value for tools
            $user->challenges = $request->challenges; // Set an appropriate value for challenges
            $user->outcomes = $request->outcomes; // Set an appropriate value for outcomes
            $user->timeline = $request->timeline; // Set an appropriate value for timeline
            $user->budget = $request->budget; // Set an appropriate value for budget
            $user->overview = $request->overview; // Set an appropriate value for overview
            $user->save();

            $emailData = [
                'name' => $request->name,
                'email' => $request->email,
                'organization_name' => $request->organization_name,
                'job_title' => $request->job_title,
                'country' => $request->country,
                'message' => $request->message,
                'contact' => $request->contact,
            ];

            FacadesNotification::route('mail', 'kirsten.kopke@purplecube.ai')->notify(new ContactNotification($emailData));
            return response(["status" => true, "message" => "Contact is successfully submitted."], 200);
    }
    }
    catch (\Exception $e) {
        return response(["status" => false, "message" => "Please Try with  Another Email. Looks like you have already filled this email id.", "error" => $e->getMessage()], 500);
    }


    
}



//////////////////// Email FORM //////////////////////////

    public function emailForm(Request $request){
    $rules = array(
        'email' => 'required|email',
    );
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response(['status' => false, 'message' => $validator->errors()], 400);
    }

    $workEmailDomains = ['gmail.com', 'yahoo.com', 'outlook.com','yandex.com','zoho.com','icloud.com','aol.com']; // Add your list of work email domains here

    $email = $request->email;
    $domain = explode('@', $email)[1];

    if (in_array($domain, $workEmailDomains)) {
        return response(['status' => false, 'email' => 'Please try again by entering the work email..'], 400);
    }
    $user = new Email();
            $user->email = $email;
            $user->save();

            $emailData = [
                'email' => $request->email,
            ];
            // FacadesNotification::route('mail', 'kirsten.kopke@purplecube.ai')->notify(new EmailNotification($emailData));
           
         try {
            $data_array = [
                "data" => [
                    [
                        "Owner" => [
                            "id" => "665758951"
                        ],
                        "Last_Name" => " .",
                        "Email" => $request->email,
                        "First_Name" => " .",
                        "Lead_Status" => "Attempted to Email",
                        "Company" => "NA",
                        "Email_Opt_Out" => false,
                        "Designation" => "Na",
                        "Mobile" => "Na",
                        "Lead_Source" => "Homepage Leads",
                    "trigger" => [
                         "approval",
    "workflow",
    "blueprint",
    "pathfinder",
    "orchestration"
                        ]
                    ]
                ]
            ];
            $r = callAPI(json_encode($data_array,true));  
            // $s = callAPI1("3z97a4db966d089ae9f8622b3b351ac97a94f454ee6269617785e033bf09591640",$request->email);  

    }
    catch (\Exception $e) {
        return response(["status" => false, "email" => "Please Try with Another Email. Looks like you have already filled this email id.", "error" => $e->getMessage()], 500);
    }
            return response(['status' => true, 'email' => 'We have sucessfully recieved your response. Our team will contact you shortly.'], 200);
        
  
}

public function emailFormC(Request $request)
{
    $rules = [
       
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response(['status' => false, 'message' => $validator->errors()], 400);
    }

    try {
        // Insert data into the "campaigns" table
        $c = new Betaform();
        $c->interest = $request->interest;
        $c->business_sector = $request->business_sector;
        $c->company_size = $request->company_size;
        $c->country = $request->country;
        $c->company = $request->company;
        $c->contact = $request->contact;
        $c->work_email = $request->work_email;
        $c->job_title = $request->job_title;
        $c->full_name = $request->full_name;
        $c->save();
        // $s = callAPI1("3z1c521ec5c988870e64375dbb7519f1a3912828bc5c7e8cf71ad483dcc67766c1",$request->email);  
        $emailData = [
                'email' => $request->work_email,
            ];
            FacadesNotification::route('mail', 'kirsten.kopke@purplecube.ai')->notify(new BetaFormVersion($emailData));
        // ...

        return response(['status' => true, 'message' => 'We have successfully received your response. Our team will contact you shortly.'], 200);
    } catch (\Exception $e) {
        return response(['status' => false, 'message' => 'Failed to insert data.', 'error' => $e->getMessage()], 500);
    }
}
public function downloadForm(Request $request)
{
    $rules = array(
        'name' => 'required',
        'email' => 'required|email',
        'job_title' => 'required',
        'company_name' => 'required',
        'industry' => 'required',
        'country' => 'required',
        'mobile' => 'required',
    );

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response(['status' => false, 'message' => $validator->errors()], 400);
    }

    $workEmailDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'yandex.com', 'zoho.com', 'icloud.com', 'aol.com'];

    $email = $request->email;
    $domain = explode('@', $email)[1];

    if (in_array($domain, $workEmailDomains)) {
        return response(['status' => false, 'message' => 'Not a work email.'], 400);
    }

    $download = new Download();
    $download->name = $request->name;
    $download->email = $request->email;
    $download->job_title = $request->job_title;
    $download->company_name = $request->company_name;
    $download->industry = $request->industry;
    $download->country = $request->country;
    $download->mobile = $request->mobile;
    $download->save();

    $data_array = [
        "data" => [
            [
                "Owner" => [
                    "id" => "665758951"
                ],
                "Last_Name" => " .",
                "Email" => $request->email,
                "First_Name" => $request->name,
                "Lead_Status" => "Attempted to Download",
                "Industry" => $request->industry,
                "country" => $request->country,
                "Email_Opt_Out" => false,
                "Designation" => $request->company_title,
                "Mobile" => $request->mobile,
                "Lead_Source" => "Download Form",
                    "trigger" => [
                         "approval",
    "workflow",
    "blueprint",
    "pathfinder",
    "orchestration"
                        ]
            ]
        ]
    ];
    $r = callAPI(json_encode($data_array,true));  
    // $s = callAPI1("3z1c521ec5c988870e64375dbb7519f1a351db46e841b64662e55d0079811c38d3",$request->email);  

    try {
       
        if (true) {
            // Send email notification
            $emailData = [
                'name' => $request->name,
                'email' => $request->email,
                'job_title' => $request->job_title,
                'company_name' => $request->company_name,
                'industry' => $request->industry,
                'country' => $request->country,
                'mobile' => $request->mobile,
            ];

            // Notify via email
            FacadesNotification::route('mail', 'kirsten.kopke@purplecube.ai')->notify(new DownloadNotification($emailData));

            return response(['status' => true, 'message' => 'Request is successfully submitted.'], 200);
        } else {
            return response(['status' => false, 'message' => 'Failed to submit ']);
        }
    } catch (\Exception $e) {
        return response(['status' => false, 'message' => 'Failed to submit request to Mailchimp.', 'error' => $e->getMessage()], 500);
    }
}

//////////////////////////////////// Advisory Form //////////////////////////////

        public function advisoryForm(Request $request)
        {
            $rules = array(
                'name' => 'required',
                'email' => 'required|email',
                'company_name' => 'required',
                'company_address' => 'required',
                'country' => 'required',
                'interested' => 'required',
                'feedback' => 'required',
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response(['status' => false, 'message' => $validator->errors()], 400);
            }

            $workEmailDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'yandex.com', 'zoho.com', 'icloud.com', 'aol.com'];

            $email = $request->email;
            $domain = explode('@', $email)[1];

            if (in_array($domain, $workEmailDomains)) {
                return response(['status' => false, 'message' => 'Not a work email.'], 400);
            }

            $member = new Member();
            $member->name = $request->name;
            $member->email = $request->email;
            $member->company_name = $request->company_name;
            $member->company_address = $request->company_address;
            $member->country = $request->country;
            $member->interested = $request->interested;
            $member->feedback = $request->feedback;
            $member->save();

            // Send to Mailchimp
            $data_array = [
                "data" => [
                    [
                        "Owner" => [
                            "id" => "665758951"
                        ],
                        "Last_Name" => " .",
                        "Email" => $request->email,
                        "First_Name" => $request->name,
                        "Lead_Status" => "Attempted to Fill Advisory Form",
                        "Industry" => $request->company_name,
                        "address" => $request->company_address,
                        "Email_Opt_Out" => false,
                        "Mobile" => $request->mobile,
                        "Lead_Source" => "Advisory Form",
                    "trigger" => [
                         "approval",
    "workflow",
    "blueprint",
    "pathfinder",
    "orchestration"
                        ]
                    ]
                ]
            ];
            $r = callAPI(json_encode($data_array,true));  
            //  $s = callAPI1("3z1c521ec5c988870e64375dbb7519f1a375bbe26188a73cd9670cef0940688324",$request->email);  

                // Check the status code to determine if the request was successful
                if (true) {
                    // Send email notification
                    $emailData = [
                        'name' => $request->name,
                        'email' => $request->email,
                        'company_name' => $request->company_name,
                        'company_address' => $request->company_address,
                        'country' => $request->country,
                        'interested' => $request->interested,
                        'feedback' => $request->feedback,
                    ];

                    FacadesNotification::route('mail', 'kirsten.kopke@purplecube.ai')->notify(new AdvisoryNotification($emailData));

                    return response(['status' => true, 'message' => 'Request is successfully submitted.'], 200);
                } else {
                    return response(['status' => false, 'message' => 'Failed to submit request.']);
                }
        }
        public function partnershipForm(Request $request)
        {
            $rules = array(
                'name' => 'required',
                'job_title' => 'required',
                'email' => 'required|email',
                'company_name' => 'required',
                'company_address' => 'required',
                'county' => 'required',
                'mobile' => 'required',
                'no_of_employee' => 'required',
                'why_interest' => 'required',
                'cloud_provider' => 'required',
                'cloud_data' => 'required',
                'partnership' => 'required',
                'verticals' => 'required',
                'expertise' => 'required',
                'region_served' => 'required',
            );
        
            $validator = Validator::make($request->all(), $rules);
        
            if ($validator->fails()) {
                return response(['status' => false, 'message' => $validator->errors()], 400);
            }
        
            $workEmailDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'yandex.com', 'zoho.com', 'icloud.com', 'aol.com'];
        
            $email = $request->email;
            $domain = explode('@', $email)[1];
        
            if (in_array($domain, $workEmailDomains)) {
                return response(['status' => false, 'message' => 'Not a work email.'], 400);
            }
        
            $partner = new Partner();
            $partner->name = $request->name;
            $partner->job_title = $request->job_title;
            $partner->email = $request->email;
            $partner->company_name = $request->company_name;
            $partner->company_address = $request->company_address;
            $partner->county = $request->county;
            $partner->mobile = $request->mobile;
            $partner->no_of_employee = $request->no_of_employee;
            
            $partner->why_interest = $request->why_interest;
            $partner->cloud_provider = $request->cloud_provider;
            $partner->cloud_data = $request->cloud_data;
            $partner->partnership = $request->partnership;
            
            $partner->verticals = $request->verticals;
            $partner->expertise = $request->expertise;
            $partner->region_served = $request->region_served;
            $partner->save();
        
        
            try {
                $data_array = [
                    "data" => [
                        [
                            "Owner" => [
                                "id" => "665758951"
                            ],
                            "Last_Name" => " .",
                            "Email" => $request->email,
                            "First_Name" => $request->name,
                            "Lead_Status" => "Attempted to Contact",
                            "Company" => $request->company_name,
                            "Email_Opt_Out" => false,
                            "Company_Address" => $request->company_address,
                            "Designation" => $request->job_title,
                            "Country" => $request->county,
                            "No_of_Employees" =>  $request->no_of_employee,
                            "Mobile" => $request->mobile,
                            "Partner_Type" => $request->Partner_Type,
                            "Cloud_Provider_Partnership" =>$request->cloud_provider,
                            "Why_are_you_interested_to_be_a_partner" =>$request->why_interest,
                            "Cloud_data_platform_partnerships" => $request->cloud_data,
                            "BI_Visualization_Analytics_partnerships" => $request->bi_visualization_analytics_partnerships,
                            "Data_Management_Partnerships" =>$request->partnership,
                            "Your_focus_verticals" => $request->verticals,
                            "Your_Data_Analytics_Expertise" => $request->expertise,
                            "Regions_Served" => $request->region_served,
                            "Lead_Source" => "Partnership Form",
                    "trigger" => [
                         "approval",
    "workflow",
    "blueprint",
    "pathfinder",
    "orchestration"
                        ]
                        ]
                    ]
                ];
                $r = callAPI(json_encode($data_array,true));  
                // $s = callAPI1("3z97a4db966d089ae9f8622b3b351ac97a6cb0fb2e7c9f217b3a9c49a695315ef4",$request->email);  
        
                if (true) {
                    // Send email notification
                    $emailData = [
                        'name' => $request->name,
                        'email' => $request->email,
                        'job_title' => $request->job_title,
                        'company_name' => $request->company_name,
                        'company_address' => $request->company_address,
                        'county' => $request->county,
                        'mobile' => $request->mobile,
                        'no_of_employee' => $request->no_of_employee,
                        'why_interest' => $request->why_interest,
                        'cloud_provider' => $request->cloud_provider,
                        'cloud_data' => $request->cloud_data,
                        'partnership' => $request->partnership,
                        'verticals' => $request->verticals,
                        'expertise' => $request->expertise,
                        'region_served' => $request->region_served,
                    ];
        
                    // Notify via email
                    FacadesNotification::route('mail', 'kirsten.kopke@purplecube.ai')->notify(new PartnershipNotification($emailData));
        
                    return response(['status' => true, 'message' => 'Request is successfully submitted.'], 200);
                } else {
                    return response(['status' => false, 'message' => 'Failed to submit request to Mailchimp.']);
                }
            } catch (\Exception $e) {
                return response(['status' => false, 'message' => 'Failed to submit request to Mailchimp.', 'error' => $e->getMessage()], 500);
            }
        }

public function resourceForm(Request $request)
{
    $rules = array(
       
    );

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response(["status" => false, "message" => "Validation failed.", "errors" => $validator->errors()], 422);
    }
    $client = new Client();
    if (true) {
            $user = new Resource();
            $user->first_name = $request->name; // Use first_name instead of name
            $user->last_name = $request->last_name; // If you don't have last_name in the request, set it to an appropriate value
            $user->email = $request->email;
            $user->company = $request->company;
            $user->job_title = $request->job_title; // Set an appropriate value for current_role
            $user->save();
            // $s = callAPI1("3z97a4db966d089ae9f8622b3b351ac97a94f454ee6269617785e033bf09591640",$request->email);  

            $emailData = [
                'name' => $request->name,
                'email' => $request->email,
            ];
             $data_array = [
                "data" => [
                    [
                        "Owner" => [
                            "id" => "665758951"
                        ],
                        "Last_Name" =>  $request->last_name,
                        "Email" => $request->email,
                        "First_Name" => $request->first_name,
                        "Lead_Status" => "Attempted to Access the Resource.",
                        "Company" => $request->company,
                        "Email_Opt_Out" => false,
                        "Designation" => $request->job_title,
                        "Mobile" => $request->contact,
                        "Lead_Source" => "Gated Assets Leads",
                    "trigger" => [
                         "approval",
    "workflow",
    "blueprint",
    "pathfinder",
    "orchestration"
                        ]
                    ]
                ]
            ];
            $r = callAPI(json_encode($data_array,true)); 

            FacadesNotification::route('mail', 'kirsten.kopke@purplecube.ai')->notify(new ResourceAccessForm($emailData));

            return response(["status" => true, "message" => "Resource Can be Accessed Now."], 200);
    }
}
        
}

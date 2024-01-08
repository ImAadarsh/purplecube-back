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




class Admin extends Controller{
 
   public function contactForm(Request $request)
{
    $rules = array(
       
    );

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response(["status" => false, "message" => "Validation failed.", "errors" => $validator->errors()], 422);
    }

    try {    
        
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
            FacadesNotification::route('mail', 'kirsten.kopke@purplecube.ai')->notify(new ResourceAccessForm($emailData));

            return response(["status" => true, "message" => "Resource Can be Accessed Now."], 200);
    }
}
        
}

<?php

namespace SocialNetwork\Http\Controllers;
use Auth;
use DB;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(){
        return view('dashboard.company.index');
    }
    public function addJobSubmit(Request $r){
        $skills = implode($r->skills,',');
        $contact_email = $r->contact_email;
        $job_title = $r->job_title;
        $requirements = $r->requirements;
        $com_id = Auth::user()->id;
        $add_job = DB::table('jobs')->insert([
            'skills' => $skills,
            'contact_email' => $contact_email,
            'job_title' => $job_title,
            'requirements' => $requirements,
            'company_id' => $com_id,
        ]);
        if($add_job){
            $jobs = DB::table('jobs')->where('company_id', Auth::user()->id)->get();
            return view('dashboard.company.jobs');
        }
    }

    public function viewJobs(){
        $jobs = DB::table('jobs')->where('company_id', Auth::user()->id)->get();
        return view('dashboard.company.jobs', compact('jobs'));
    }

}

<?php

namespace App\Http\Controllers;

use App\Group;
use App\Member;

class FrontendController extends Controller
{
    /**
     * Display a listing of different groups the user belongs to.
     *
     * @return \Illuminate\Http\Response
     */
    public function group_insights_1()
    {
        $my_group = auth()->user()->activeGroup;

        //the functions below should be put somewhere else            

            $progress['ideal'] = rand(0,100); //should be % of objectives completed / objectives due
            $effort['ideal'] =rand(0,100); //should be % of comitments completed / commitments
            $predictor['ideal'] =rand(0,100); // the predictor
            $engagement['ideal'] =rand(0,100); //engagement value

            $progress['average'] = rand(0,100); //should be % of objectives completed / objectives due
            $effort['average'] =rand(0,100); //should be % of comitments completed / commitments
            $predictor['average'] =rand(0,100); // the predictor
            $engagement['average'] =rand(0,100); //engagement value

        foreach($my_group->members as $member){
            $progress[$member->name] = rand(0,100); //should be % of objectives completed / objectives due
            $effort[$member->name] =rand(0,100); //should be % of comitments completed / commitments
            $predictor[$member->name] =rand(0,100); // the predictor
            $engagement[$member->name] =rand(0,100); //engagement value
        }

        return view('frontend.group_insights_analytics', compact('progress','effort','predictor','engagement'));
    }

    public function group_insights_2()
    {
        $group=auth()->user()->activeGroup;
        $members = $group->members;
        //will need to pull data 
            //member names
            //last reviews from each member

        //will need the average the score here or on view?

        return view('frontend.group_insights_feedback',compact('members','group'));
    }

    public function group_insights_3()
    {
        $group=auth()->user()->activeGroup;
        $members = $group->members;
        //will need to pull data 
            //member names
            //All reviews from each member, order by date

        return view('frontend.group_insights_history',compact('members','group'));
    }

    public function manage_member_1()
    {
        $group=auth()->user()->activeGroup;
        $members = $group->members->load('user');
        //will need to pull data 
            //member names
            //All reviews from each member, order by date
        return view('frontend.manage_member_1',compact('members','group'));
    }

    public function edit_group_profile_1()
    {
        $group=auth()->user()->activeGroup;
        //will need to pull data 
            //member names
            //All reviews from each member, order by date
        return view('frontend.group_profile_1',compact('group'));
    }

    public function group_configuration_1()
    {
        //need to pull what we are about screens
        $screens=['TODO'];

        return view('frontend.group_configuration_1',compact('screens'));
    }

    public function group_configuration_2()
    {
        $group=auth()->user()->activeGroup;
        //will need to pull data 
            //member names
            //All reviews from each member, order by date
        return view('frontend.group_configuration_2',compact('group'));
    }


    public function group_configuration_3()
    {
        $group=auth()->user()->activeGroup;
        //will need to pull data 
            //member names
            //All reviews from each member, order by date
        return view('frontend.group_configuration_3',compact('group'));
    }

    public function group_configuration_4()
    {
        $group=auth()->user()->activeGroup;
        //will need to pull data 
            //member names
            //All reviews from each member, order by date
        return view('frontend.group_configuration_4',compact('group'));
    }

    public function group_configuration_5()
    {
        $group=auth()->user()->activeGroup;
        //will need to pull data 
            //member names
            //All reviews from each member, order by date
        return view('frontend.group_configuration_5',compact('group'));
    }

    public function group_configuration_6()
    {
        $group=auth()->user()->activeGroup;
        //will need to pull data 
            //member names
            //All reviews from each member, order by date
        return view('frontend.group_configuration_6',compact('group'));
    }

    public function group_configuration_7()
    {
        $group=auth()->user()->activeGroup;
        //will need to pull data 
            //member names
            //All reviews from each member, order by date
        return view('frontend.group_configuration_7',compact('group'));
    }

    public function account_1()
    {
        $group=auth()->user()->activeGroup;
        //will need to pull data 
            //member names
            //All reviews from each member, order by date
        return view('frontend.account_1',compact('group'));
    }

    public function account_2()
    {
        $group=auth()->user()->activeGroup;
        //will need to pull data 
            //member names
            //All reviews from each member, order by date
        return view('frontend.account_2',compact('group'));
    }

    public function account_3()
    {
        $group=auth()->user()->activeGroup;
        //will need to pull data 
            //member names
            //All reviews from each member, order by date
        return view('frontend.account_3',compact('group'));
    }

    public function account_4()
    {
        $group=auth()->user()->activeGroup;
        //will need to pull data 
            //member names
            //All reviews from each member, order by date
        return view('frontend.account_4',compact('group'));
    }

    public function account_5()
    {
        $group=auth()->user()->activeGroup;
        //will need to pull data 
            //member names
            //All reviews from each member, order by date
        return view('frontend.account_5',compact('group'));
    }

    public function account_6()
    {
        $group=auth()->user()->activeGroup;
        //will need to pull data 
            //member names
            //All reviews from each member, order by date
        return view('frontend.account_6',compact('group'));
    }

    public function account_7()
    {
        $group=auth()->user()->activeGroup;
        //will need to pull data 
            //member names
            //All reviews from each member, order by date
        return view('frontend.account_7',compact('group'));
    }

    public function overview()
    {
        return view('frontend.overview',compact('group'));
    }
}

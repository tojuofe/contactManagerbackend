<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contacts;
use Validator;
use Illuminate\Routing\UrlGenerator;

class ContactController extends Controller
{
    //
    protected $contacts;
    protected $base_url;

    public function __construct(UrlGenerator $urlGenerator)
    {
        // Middleware to Protect a Route
        $this->middleware('auth:users');
        // Contacts Variable to Contacts Model
        $this->contacts = new contacts;
        // For Absolute Path
        $this->base_url= $urlGenerator->to('/');
    }

    // Create Contacts 
    public function addContacts(Request $request)
    {
        // Laravel Validator for Data passed in
        $validator = Validator::make($request->all(),
        [
            'firstname'=>'required|string',
            'phonenumber'=>'required|string',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'success'=>false,
                'message'=>$validator->messages()->toArray()
            ], 500);
        }

        $profile_picture = $request->profile_image;
        $file_name = '';
        if($profile_picture != null)
        {
             // Generate Random Image Name
             $generate_name = uniqid().'_'.time().date('Ymd').'_IMG';
             $base64Image = $profile_picture;
 
             $fileBin = file_get_contents($base64Image);
 
             $mimetype = mime_content_type($base64Image);
             
             if('image/png'==$mimetype)
             {
                 $file_name = $generate_name.".png";
             }
             else if('image/jpeg'==$mimetype)
             {
                 $file_name = $generate_name.".jpeg";
             }
             else if('image/jpg'==$mimetype)
             {
                 $file_name = $generate_name.".jpg";
             }
             else {
                 return response()->json([
                     'success'=>false,
                     'message'=>'Invalid Format! png/jpg/jpeg only'
                 ],500);
             }
        } 
        else
        {
            $file_name = 'default-avatar.png';
           
        }
        
        // Extract User Id from token
        $user_token = $request->token;
        $user = auth('users')->authenticate($user_token);
        $user_id = $user->id;

        $this->contacts->user_id = $user_id;
        $this->contacts->phonenumber = $request->phonenumber;
        $this->contacts->firstname = $request->firstname;
        $this->contacts->lastname = $request->lastname;
        $this->contacts->email = $request->email;
        $this->contacts->image_file = $file_name;
        $this->contacts->save();

        // error_log($this->contacts);

        $contact = $this->contacts->refresh();

        if($profile_picture != null)
        {
            file_put_contents('./profile_images/'.$file_name,$fileBin);
        }

        return response()->json([
            'success'=>true,
            'message'=> 'Contacts Saved Successfully',
            'data'=> $contact
        ], 201);
    }


    // GET CONTACTS TO SPECIFIC USER
    public function getPaginatedData(Request $request, $pagination=null)
    {
        
        $file_directory = $this->base_url."/profile_images";
        $user_token = $request->token;
        $user = auth('users')->authenticate($user_token);
        $user_id = $user->id;
       
        if($pagination == null || $pagination =='')
        {
            $contacts = $this->contacts->where('user_id',$user_id)->orderBy('id','DESC')->get()->toArray();
            return response()->json([
                'success'=>true,
                'count'=>count($contacts),
                'data'=> $contacts,
                'file_directory'=>$file_directory
            ], 200);
            
        }
        
        
        // GET PAGINATED CONTACTS
        $contacts_paginated = $this->contacts->where('user_id',$user_id)->orderBy('id', 'DESC')->paginate($pagination);
        return response()->json([
            'success'=>true,
            'count'=>count($contacts_paginated),
            'data'=> $contacts_paginated,
            'file_directory'=>$file_directory
        ], 200);

    }

    // UPDATE CONTACTS
    public function editSingleData(Request $request, $id)
        {
           
            $validator = Validator::make($request->all(),
            [
                'firstname'=>'required|string',
                'phonenumber'=>'required|string',
            ]);

            if($validator->fails())
            {
                return response()->json([
                    'success'=>false,
                    'message'=>$validator->messages()->toArray()
                ], 500);
            }
            

            $findData = $this->contacts::find($id);
            if(!$findData)
            {
                return response()->json([
                    'success'=>false,
                    'message'=>'Please no valid ID'
                ],500);
            }
           
            // GET IMAGE FILES
            $getFile = $findData->image_file;

            // DELETE PROFILE IMAGE
            $getFile !='default-avatar.png' && unlink('./profile_images/'.$getFile);
            
            // SET PROFILE IMAGE
            $profile_picture = $request->profile_image;
            $file_name = '';
            if($profile_picture != null)
            {
                    // Generate Random Image Name
                    $generate_name = uniqid().'_'.time().date('Ymd').'_IMG';
                    $base64Image = $profile_picture;
        
                    $fileBin = file_get_contents($base64Image);
                    $minetype = mime_content_type($base64Image);
                    if('image/png'==$minetype)
                    {
                        $file_name = $generate_name.".png";
                    }
                    else if('image/jpeg'==$minetype)
                    {
                        $file_name = $generate_name.".jpeg";
                    }
                    else if('image/jpg'==$minetype)
                    {
                        $file_name = $generate_name.".jpg";
                    }
                    else {
                        return response()->json([
                            'success'=>false,
                            'message'=>'Invalid Format! png/jpg/jpeg only'
                        ],500);
                    }
            } 
            else
            {
                $file_name = 'default-avatar.png';
                
            }
                $findData->firstname = $request->firstname;
                $findData->lastname = $request->lastname;
                $findData->phonenumber = $request->phonenumber;
                $findData->email = $request->email;
                $findData->image_file = $file_name;
                $findData->save();

                $updated_contact = $findData->refresh();

                if(!$profile_picture == null)
                {
                    file_put_contents('./profile_images/'.$file_name,$fileBin);
                }

                return response()->json([
                    'success'=>true,
                    'message'=> 'Contacts Updated Successfully',
                    'data'=> $updated_contact
                ], 200);
                
        }

    // DELETE CONTACTS
    public function deleteContacts($id)
    {
        $findData = $this->contacts::find($id);
        if(!$findData)
        {
            return response()->json([
                'success'=>false,
                'message'=>'Contacts with this ID doesn\'t exist'
            ],500);
        }

        $getFile = $findData->image_file;
        if($findData->delete())
        {
            $getFile != 'default-avatar.png' && unlink('./profile_images/'.$getFile);

            return response()->json([
                'success'=>true,
                'message'=>'Contacts deleted Successfully'
            ],200); 
        }
    }

    // GET SINGLE CONTACT
    public function getSingleData($id)
    {
        $file_directory = $this->base_url.'/profile_images';
        $findData = $this->contacts::find($id);
        if(!$findData)
        {
            return response()->json([
                'success'=>false,
                'message'=>'Contacts with this ID doesn\'t exist'
            ],500); 
        }

        return response()->json([
            'success'=>true,
            'data'=>$findData,
            'file_directory'=> $file_directory
        ],200);
    }

    // SEARCH AND PAGINATE DATA
    public function searchData(Request $request, $search, $pagination=null)
    {
       
        $file_directory = $this->base_url.'/profile_images';
        $user_token = $request->token;
        $user = auth('users')->authenticate($user_token);
        $user_id = $user->id;

        if($pagination == null || $pagination == '')
        {
            $non_paginated_search_query = $this->contacts::where('user_id', $user_id)->where(function($query) use ($search){
            $query->where("firstname","LIKE","%$search%")->orWhere("lastname","LIKE","%$search%")->
            orWhere("email","LIKE","%$search%")->orWhere("phonenumber","LIKE","%$search%");
            })->orderBy("id", "DESC")->get()->toArray();
            return response()->json([
                'success'=>true,
                'data'=>$non_paginated_search_query,
                'file_directory'=> $file_directory
            ],200);
        }

        $paginated_search_query = $this->contacts::where('user_id', $user_id)->where(function($query) use ($search){
            $query->where('firstname','LIKE',"%$search%")->orWhere('lastname','LIKE',"%$search%")->
            orWhere('email','LIKE',"%$search%")->
            orWhere('phonenumber','LIKE',"%$search%");
        })->orderBy('id', 'DESC')->paginate($pagination);
        return response()->json([
            'success'=>true,
            'data'=>$paginated_search_query,
            'file_directory'=> $file_directory
        ], 200);

    }
}

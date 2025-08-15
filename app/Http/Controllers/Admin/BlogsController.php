<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blogs;

use App\Rules\FileTypeValidate;
use DB;
use Hash;
use Auth;
use Session;
class BlogsController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $pageTitle = 'All Blogs';
        $emptyMessage = 'No brand found';
        $blogs = Blogs::query();
        $blogs = $blogs->latest()->paginate(getPaginate());
        return view('admin.blogs.index',compact('pageTitle', 'emptyMessage','blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = 'All Blogs';
        $emptyMessage = 'No brand found';
        return view('admin.blogs.add',compact('pageTitle', 'emptyMessage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'desciption' => 'required'
        ]);

        $input = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');         
            $fileName = $image->getClientOriginalName();
            $fileExtension = $image->getClientOriginalExtension();

             $path = imagePath()['blogs']['path'];
             $size = imagePath()['blogs']['size'];
            $oldFile = null;
            $imageName=uploadImage($request->image, $path, $size, $oldFile);
            //$request->file('image')->move(base_path().'/public/uploads/blogs',$imageName);
            $input['image'] = $imageName;
        } 

        $user = Blogs::create($input);
        //Alert::success('Success', 'Blog created successfully');
        return redirect()->route('admin.blogs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        // $user=Blogs::find($id);
        // $user->group_id=@$request->group_id;
        // $user->save();
        return response()->json(array('status'=>1,'message'=>'Successfully updated.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       // $role = Role::get();
        $pageTitle = 'All Blogs';
        $emptyMessage = 'No brand found';
    	$data = Blogs::where('id',$id)->first();
        return view('admin.blogs.edit',compact('data','pageTitle', 'emptyMessage'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'desciption' => 'required',
        ]);

        $user =Blogs::find($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');         
            $fileName = $image->getClientOriginalName();
            $fileExtension = $image->getClientOriginalExtension();
            $oldFile = null;
             $path = imagePath()['blogs']['path'];
             $size = imagePath()['blogs']['size'];
            $imageName=uploadImage($request->image, $path, $size, $oldFile);
            $user->image = $imageName;
        }  

        $user->title = $request->title;
        $user->date = $request->date;
        $user->desciption = $request->desciption;
    
        $user->save();
        
        return redirect()->route('admin.blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Blogs::find($id)->delete();
        $report =Blogs::find($id);
        $report->deleted_at = date('Y-m-d h:m:i');    
        $report->save();
        Alert::success('Success', 'Blog deleted successfully');
        return redirect()->route('blogs.index');
    }

    public function datatable(Request $request){
        $users=Blogs::where('deleted_at',NULL)->get();
        return DataTables::of($users)
                    ->addColumn('sno',function(){STATIC $count=1; return $count++;})
                    ->rawColumns(['input'=>true,'html'=>true])
                    ->addColumn('image', function ($row) {
                            $image ='<img src="'.asset("uploads/blogs/").'/'.$row->image.'" alt="" width="100" height="100">&nbsp;&nbsp;';                     
                        return $image;
                    })
                  
                    ->addColumn('action', function ($row) {
                        $action='';
                        if(Auth::user()->can('edit-blogs')){
                            $action .='<a href="'.route("blogs.edit",$row->id).'"><i class="fa fa-edit" style="font-size: 24px;"></i></a>&nbsp;&nbsp;';
                        }
                        if(Auth::user()->can('delete-blogs')){
                            $action .='<a href="'.route("blogs.destroy",$row->id).'" onclick="return confitm(\'Are you sure??????.\')"><i class="fa fa-trash" style="color:red;font-size: 24px;"></i></a>';
                        }
                        return $action;
                    })->make();
    }
}
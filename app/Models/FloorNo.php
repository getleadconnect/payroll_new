<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class FloorNo extends Model
{
    use HasFactory;
	
	protected $table='floor_nos';
	
	protected $fillable = ['id','floor_no','status','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//------------fucntions------------------------------
	
	public const RULES=[
	   'floor_no'=>'required|unique:floor_nos',
	];
	
	public const EDIT_RULES=[
	   'ed_floor_no'=>'required',
	];
	
	public function addFloorNo($request)
	{
		return self::create([
		'floor_no'=>Str::upper($request->floor_no),
		'added_by'=>Session::get('admin_id'),
		]);
	}
		
	public function updateFloorNo($request)
	{

		$id=$request->ed_floor_id;

		$dat=[
		  'floor_no'=>Str::upper($request->ed_floor_no),
		  'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);

		return $result;
		
	}


public function viewFloorNos($request)  //view data
	{

		$search=$request->search;
		
		$dats=self::select('floor_nos.*','admins.name')
		->leftJoin('admins','floor_nos.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("floor_nos.floor_no", 'like', '%' .$search . '%');
			  })->orderBy('floor_nos.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				$uData['id'] = ++$key;
				$uData['fno'] =$r->floor_no;
				$uData['addedby'] =$r->name;
				
				$btn='<a href="javascript:void(0)" id="'.$r->id.'" data-val="'.$r->floor_no.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm" title="Delete"><i class="fa fa-trash"></i></a>'; 
				$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		


	public function getFloors()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getFloorById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteFloorNo($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class AssetCategory extends Model
{
    use HasFactory;
	
	protected $table='asset_category';
	
	protected $fillable = ['id','category_name','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'category_name'=>'required|unique:asset_category',
	];
	
	public const EDIT_RULES=[
	'ed_category_name'=>'required',
	];
	
	public function addAssetCategory($request)
	{
		return self::create([
		'category_name'=>Str::upper($request->category_name),
		'added_by'=>Session::get('admin_id'),
		]);
		
	}
		
	public function updateAssetCategory($request)
	{
		
		$id=$request->ed_category_id;

		$dat=[
		'category_name'=>Str::upper($request->ed_category_name),
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewAssetCategories($request)  //view data
	{

		$search=$request->search;
				
		
		$dats=self::select('asset_category.*','admins.name')
		->leftJoin('admins','asset_category.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("asset_category.category_name", 'like', '%' .$search . '%');
			  })->orderBy('asset_category.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					$uData['id'] = ++$key;
					$uData['cat'] =$r->category_name;
					$uData['addedby'] =$r->name;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" data-val="'.$r->category_name.'" class="edit btn-outline-secondary btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getAssetCategories()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getAssetCategoryById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteAssetCategory($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}

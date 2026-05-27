<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class AssetSubCategory extends Model
{
    use HasFactory;
	
	protected $table='asset_sub_category';
	
	protected $fillable = ['id','asset_category_id','sub_category_name','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'category_id'=>'required',
	'sub_category_name'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_category_id'=>'required',
	'ed_sub_category_name'=>'required',
	];
	
	public function addAssetSubCategory($request)
	{
		return self::create([
		'asset_category_id'=>Str::upper($request->category_id),
		'sub_category_name'=>Str::upper($request->sub_category_name),
		'added_by'=>Session::get('admin_id'),
		]);
		
	}
		
	public function updateAssetSubCategory($request)
	{
		
		$id=$request->ed_sub_category_id;

		$dat=[
		'asset_category_id'=>Str::upper($request->ed_category_id),
		'sub_category_name'=>Str::upper($request->ed_sub_category_name),
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewAssetSubCategories($request)  //view data
	{

		$search=$request->search;
		
		$dats=self::select('asset_sub_category.*','admins.name','asset_category.category_name')
		->leftJoin('asset_category','asset_sub_category.asset_category_id','=','asset_category.id')
		->leftJoin('admins','asset_sub_category.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("asset_sub_category.sub_category_name", 'like', '%' .$search . '%')
					      ->orWhere("asset_category.category_name", 'like', '%' .$search . '%')
						  ->orWhere("admins.name", 'like', '%' .$search . '%');
			  })->orderBy('asset_sub_category.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					$uData['id'] = ++$key;
					$uData['cat'] =$r->category_name;
					$uData['scat'] =$r->sub_category_name;
					$uData['addedby'] =$r->name;
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary  shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger  shadow btn-b-sm" title="Delete"><i class="fa fa-trash"></i></a>'; 
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getAssetSubCategories()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getAssetSubCategoryById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteAssetSubCategory($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}

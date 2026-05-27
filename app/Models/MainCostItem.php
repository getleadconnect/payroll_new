<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class MainCostItem extends Model
{
    use HasFactory;
	
	protected $table='main_cost_items';
	
	protected $fillable = ['id','main_item','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//------------fucntions------------------------------
	
	public const RULES=[
	   'main_item'=>'required|unique:main_cost_items',
	];
	
	public const EDIT_RULES=[
	   'ed_main_item'=>'required',
	];
	
	public function addMainCostItem($request)
	{
		return self::create([
		'main_item'=>Str::upper($request->main_item),
		'added_by'=>Session::get('admin_id'),
		]);
	}
		
	public function updateMaincostItem($request)
	{

		$id=$request->ed_cost_item_id;

		$dat=[
			'main_item'=>Str::upper($request->ed_main_item),
			'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);

		return $result;
		
	}


public function viewMainCostItems($request)  //view data
	{

		$search=$request->search;
		
		$dats=self::select('main_cost_items.*','admins.name')
		->leftJoin('admins','main_cost_items.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("main_cost_items.main_item", 'like', '%' .$search . '%')
					->orWhere("admins.name", 'like', '%' .$search . '%');
					
			  })->orderBy('main_cost_items.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				$uData['id'] = ++$key;
				$uData['mitem'] =$r->main_item;
				$uData['addedby'] =$r->name;
				
				$btn='<a href="javascript:void(0)" id="'.$r->id.'" data-val="'.$r->main_item.'" class="edit btn-outline-secondary shadow btn-b-sm " data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
				$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		


	public function getMainCostItems()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getMainCostItemById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	 public function deleteMainCostItem($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}

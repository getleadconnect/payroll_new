<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use App\Models\Company;
//use App\Models\Client;
use DB;
use Session;

class ProjectAsset extends Model
{
    use HasFactory;
	
	protected $table='project_assets';
	
	protected $fillable = ['id','assigned_date','project_id','asset_item_id','quantity',
	'return_date','return_quantity','return_status','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'project_id'=>'required',
	'quantity'=>'required',
	];
	
	public const EDIT_RULES=[
	'project_id'=>'required',
	'quantity'=>'required',
	];
	
	public const ASSIGN_RULES=[
	'ass_project_id'=>'required',
	'ass_quantity'=>'required',
	];
	
	
	public function addProjectAssetItem($request)
	{
		$pid=$request->ass_project_id;
		$aid=$request->ass_item_id;
		
		if($request->ass_available_quantity>=$request->ass_quantity && $request->ass_quantity>0)
		{
			
			$result=self::create([
			'assigned_date'=>date('Y-m-d'),
			'project_id'=>$request->ass_project_id,
			'asset_item_id'=>$request->ass_item_id,
			'quantity'=>$request->ass_quantity,
			'added_by'=>Session::get('admin_id'),
			]);
			
			$aqty=$request->ass_available_quantity-$request->ass_quantity;
			
			$new=['available_quantity'=>$aqty];
			
			$res=AssetItem::where('id',$aid)->update($new);
			
			return $result;
		}
		else
		{
			return false;
		}
		
	}
		

public function viewProjectAssets($request)  //view data
	{

		$search=$request->search;
		$project_id=$request->project_id;
		
		$dts=self::query();
		
		$dts->select('project_assets.*','projects.project_name','asset_items.item_name','admins.name')
		->leftJoin('projects','project_assets.project_id','=','projects.id')
		->leftJoin('asset_items','project_assets.asset_item_id','=','asset_items.id')
		->leftJoin('admins','project_assets.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("asset_items.item_name", 'like', '%' .$search . '%')
						->orWhere("project_assets.quantity", 'like', '%' .$search . '%')
						->orWhere("project_assets.return_date", 'like', '%' .$search . '%');
			  });
		
		if($project_id!="")
		{
			$dts->where('project_assets.project_id',$project_id);
		}
		
		$dats=$dts->orderBy('project_assets.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					
					if($r->return_status==0)
					{
						$st='<span class="badge badge-info">No</span>';
						$rbtn='<a href="#" id="'.$r->id.'" class="return_item btn-rounded btn-info shadow" style="padding:2px 12px !important;font-weight:400 !important;" data-toggle="modal"  title="Return Assigned items from project">Ret.</a>';
					}
					else
					{
						$st='<span class="badge badge-primary">Yes</span>';
						$rbtn="";
					}
					
					$uData['id'] = ++$key;
					$uData['asdate'] =date_create($r->start_date)->format('d-m-Y');
					$uData['pname'] =Str::upper($r->project_name);
					$uData['iname'] =Str::upper($r->item_name);
					$uData['qty'] =$r->quantity;
					$uData['rdate'] = $r->return_date?date_create($r->return_date)->format('d-m-Y'):"";
					$uData['rqty'] =$r->return_quantity;
					$uData['status'] =$st;
					$uData['addedby'] =$r->name;

					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm " data-toggle="modal" title="Edit"><i class="fa fa-edit"></i></a>
					<a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					
					//$uData['action'] = $btn."&nbsp;".$btns;
					$uData['action'] = $rbtn." ".$btn;

			    $data[] = $uData;
			}
        }
		
		return $data;
	}		

	public function getProjectAssets()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getProjectAssetItemById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
	
	public function deleteProjectAssetItem($id)
	{
		$dat=self::find($id);
		$result=false;	

		if(!empty($dat))
		{
			$qty=$dat->quantity;
			$dt=AssetItem::where('id',$dat->asset_item_id)->first();
			if(!empty($dt)){$aqty=$dt->available_quantity;}else {$aqty=0;}
			$new=['available_quantity'=>($aqty+$qty)];
			$res=AssetItem::where('id',$dat->asset_item_id)->update($new);
			$result=$dat->delete();
		}
		
		return $result;
		
	}

	public function updateReturnProjectAssetItem($request)
	{
		$pid=$request->pro_item_id;
		$aid=$request->asset_item_id;
				
		$result=false;
		$status=0;
		
		DB::beginTransaction();
		try{

		     $dat=self::find($pid);
			 
				if(!empty($dat))
				{
					$qty=$request->ret_quantity;
					
					$dt=AssetItem::where('id',$aid)->first();
					if(!empty($dt)){$aqty=$dt->available_quantity;}else {$aqty=0;}

					$qty_1=$request->ret_quantity;

					if(($dat->return_quantity+$request->ret_quantity)==$dat->quantity)
					{
						$qty_1=$dat->quantity;
						$status=1;
					}
					
					$new1=['return_quantity'=>$qty_1,
						'return_date'=>date('Y-m-d'),
						'return_status'=>$status,
						'added_by'=>Session::get('admin_id'),
					];
					
					$new=['available_quantity'=>($aqty+$qty),
					];
					
					$result=AssetItem::where('id',$aid)->update($new);
					$res=ProjectAsset::where('id',$pid)->update($new1);
					DB::commit();
				}
		}
		catch(\Exception $e)
		{
			DB::rollback();
			$result=false;
		}
		
		return $result;
	}
	
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use App\Models\Company;
//use App\Models\Client;
use Session;

class AssetItem extends Model
{
    use HasFactory;
	
	protected $table='asset_items';
	
	protected $fillable = ['id','asset_category_id','company_id','item_name',
	'bill_date','bill_no','available_quantity','unit_price','quantity','amount','description','added_by'];
		
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'category_id'=>'required',
	'company_id'=>'required',
	'item_name'=>'required',
	'bill_date'=>'required',
	'bill_no'=>'required',
	'unit_price'=>'required',
	'quantity'=>'required',
	'amount'=>'required',
	'description'=>'required'
	];
	
	public const EDIT_RULES=[
	'ed_category_id'=>'required',
	'ed_company_id'=>'required',
	'ed_item_name'=>'required',
	'ed_bill_date'=>'required',
	'ed_bill_no'=>'required',
	'ed_unit_price'=>'required',
	'ed_quantity'=>'required',
	'ed_amount'=>'required',
	'ed_description'=>'required'
	];
	
	public function addAssetItem($request)
	{
		return self::create([
		'asset_category_id'=>$request->category_id,
		'company_id'=>$request->company_id,
		'item_name'=>Str::upper($request->item_name),
		'bill_date'=>$request->bill_date,
		'bill_no'=>$request->bill_no,
		'unit_price'=>$request->unit_price,
		'quantity'=>$request->quantity,
		'amount'=>$request->amount,
		'available_quantity'=>$request->quantity,
		'description'=>Str::upper($request->description),
		'added_by'=>Session::get('admin_id'),
		]);
		
	}
		
	public function updateAssetItem($request)
	{
		
		$id=$request->ed_asset_item_id;

		$dat=[
		'asset_category_id'=>$request->ed_category_id,
		'company_id'=>$request->ed_company_id,
		'item_name'=>Str::upper($request->ed_item_name),
		'bill_date'=>$request->ed_bill_date,
		'bill_no'=>$request->ed_bill_no,
		'unit_price'=>$request->ed_unit_price,
		'quantity'=>$request->ed_quantity,
		'amount'=>$request->ed_amount,
		'available_quantity'=>$request->ed_quantity,
		'description'=>Str::upper($request->ed_description),
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewAssetItems($request)  //view data
	{

		$search=$request->search;
		$category_id=$request->category_id;
		
		$dts=self::query();
		
		$dts->select('asset_items.*','admins.name','asset_category.category_name','company.company_name',)
		->leftJoin('asset_category','asset_items.asset_category_id','=','asset_category.id')
		->leftJoin('company','asset_items.company_id','=','company.id')
		->leftJoin('admins','asset_items.added_by','=','admins.id')
		
		->where(function($where) use($search)
			    {
					$where->where("asset_items.item_name", 'like', '%' .$search . '%')
						->orWhere("company.company_name", 'like', '%' .$search . '%')
						->orWhere("asset_items.bill_no", 'like', '%' .$search . '%')
						->orWhere("asset_items.bill_date", 'like', '%' .$search . '%');
			  });
			  
		if($category_id!="")
		{
			$dts->where('asset_category_id',$category_id);
		}
		
		$dats=$dts->orderBy('asset_items.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {

				$uData['id'] = ++$key;
				$uData['comp'] =$r->company_name;
				$uData['cat'] =$r->category_name;
				$uData['item'] =$r->item_name;
				$uData['bdate'] =date_create($r->bill_date)->format('d-m-Y');
				$uData['bno'] =$r->bill_no;
				$uData['aqty'] =$r->available_quantity;
				$uData['uprice'] =number_format($r->unit_price,'2','.',',');
				$uData['qty'] =$r->quantity;
				$uData['amt'] =number_format($r->amount,'2','.',',');
				$uData['desc'] =$r->description;
				$uData['addedby'] =$r->name;
					
				$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					
				//$uData['action'] = $btn."&nbsp;".$btns;
				$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		


public function viewAssetItemsForProjects($request)  //assign asset items to project
	{

		$search=$request->search;
		$category_id=$request->category_id;
		
		$dts=self::query();
		
		$dts->select('asset_items.*','admins.name','asset_category.category_name','company.company_name',)
		->leftJoin('asset_category','asset_items.asset_category_id','=','asset_category.id')
		->leftJoin('company','asset_items.company_id','=','company.id')
		->leftJoin('admins','asset_items.added_by','=','admins.id')
		
		->where(function($where) use($search)
			    {
					$where->where("asset_items.item_name", 'like', '%' .$search . '%')
						->orWhere("company.company_name", 'like', '%' .$search . '%')
						->orWhere("asset_items.bill_no", 'like', '%' .$search . '%')
						->orWhere("asset_items.bill_date", 'like', '%' .$search . '%');
			  });
			  
		if($category_id!="")
		{
			$dts->where('asset_category_id',$category_id);
		}
		
		$dats=$dts->orderBy('asset_items.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {

				$uData['id'] = ++$key;
				$uData['comp'] =Str::upper($r->company_name);
				$uData['cat'] =Str::upper($r->category_name);
				$uData['item'] =Str::upper($r->item_name);
				$uData['aqty'] =$r->available_quantity;
				$uData['qty'] =$r->quantity;
				$uData['amt'] =number_format($r->amount,'2','.',',');
				$uData['addedby'] =$r->name;
				
				if($r->available_quantity>0)
				{
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="assign_item btn-rounded btn-info btn-xs shadow btn-sm" data-toggle="modal"  title="Assign item to project">Assign</a>';
				}
				else
				{
					$btn="";
				}
					  		
				//$uData['action'] = $btn."&nbsp;".$btns;
				$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		
	
	public function getAssetItems()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getAssetItemById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteAssetItem($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}

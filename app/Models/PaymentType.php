<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class PaymentType extends Model
{
    use HasFactory;
	
	protected $table='payment_types';
	
	protected $fillable = ['id','payment_type','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'payment_type'=>'required|unique:payment_types',
	];
	
	public const EDIT_RULES=[
	'ed_payment_type'=>'required',
	];
	
	public function addPaymentType($request)
	{
		return self::create([
		'payment_type'=>Str::upper($request->payment_type),
		'added_by'=>Session::get('admin_id'),
		]);
		
	}
		
	public function updatePaymentType($request)
	{
		
		$id=$request->ed_payment_type_id;

		$dat=[
		'payment_type'=>Str::upper($request->ed_payment_type),
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}

   public function viewPaymentTypes($request)  //view data
	{

		$search=$request->search;
		
		$dats=self::select('payment_types.*','admins.name')
		->leftJoin('admins','payment_types.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("payment_types.payment_type", 'like', '%' .$search . '%');
			  })->orderBy('payment_types.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				
					$uData['id'] = ++$key;
					$uData['ptype'] =$r->payment_type;
					$uData['addedby'] =$r->name;
					
					/*$btn='<a href="javascript:void(0)" id="'.$r->id.'" data-val="'.$r->payment_type.'" data-mode="'.$r->payment_mode.'" class="edit btn btn-rounded btn-secondary btn-xs btn-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a>'; 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn btn-rounded btn-danger btn-xs btn-sm " title="Delete"><i class="fa fa-trash"></i></a>';*/
					/*$uData['action'] = $btn;*/

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getPaymentTypes()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getPaymentTypeById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deletePaymentType($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}
	
	
}

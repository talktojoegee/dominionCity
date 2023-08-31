<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CashBookAttachment extends Model
{
    use HasFactory;
    protected $primaryKey = 'cba_id';


    public function storeAttachment(Request $request, $cashboodId){
        foreach($request->attachments as $attachment){
            $extension = $attachment->getClientOriginalExtension();
            $size = $attachment->getSize();
            $filename = uniqid() . '_' . time() . '_' . date('Ymd') . '.' . $extension;
            $dir = 'assets/drive/cloud/';
            $attachment->move(public_path($dir), $filename);
            $file = new CashBookAttachment();
            $file->cba_attachment = $filename;
            $file->cba_cashbook_id = $cashboodId;
            $file->save();
        }
    }
}

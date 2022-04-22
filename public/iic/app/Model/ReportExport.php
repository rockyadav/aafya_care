<?php
namespace App\Model;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\User;
use App\Helpers\Helper;
use DB;

class ReportExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function collection()
    {
        $session  = session()->get('ReportSession');
        $fromdate = $session['fromdate'];
        $todate   = $session['todate'];
        $reportType = $session['type'];

        $resultArray = array();
        if($reportType=='sales')
        {
          $result = DB::table('countributor_wallets')->leftJoin('images','images.id','=','countributor_wallets.image_id');
          if($fromdate!='')
          {
            $fromdate = date('Y-m-d',strtotime($fromdate));
            $result->whereDate('countributor_wallets.created_at','>=',$fromdate);
          }

          if($todate!='')
          {
            $todate = date('Y-m-d',strtotime($todate));
            $result->whereDate('countributor_wallets.created_at','<=',$todate);
          }

          $result->select('countributor_wallets.*','images.title');
          $result->orderBy('countributor_wallets.created_at','desc');
          $list = $result->get();

            if(count($list)>0)
            {
                foreach ($list as $row) {
                $array = [
                            'Title'=>$row->title,
                            'Amount'=>$row->amount,
                            'Commission'=>$row->commission,
                            'Date'=>date('d-m-Y h:i a',strtotime($row->created_at))
                          ];               
                array_push($resultArray, $array);
                }
            }
        }

        if($reportType=='upload')
        {
          $res = Images::where('images.status',1);
          $res->leftJoin('categories', function ($query) {
              $query->on('categories.id', '=', 'images.cat_id');
              $query->where('categories.status',1);
          });
          $res->leftJoin('sub_categories', function ($query) {
              $query->on('sub_categories.id', '=', 'images.sub_cat_id');
              $query->where('sub_categories.status',1);
          });
          $res->leftJoin('users','users.id','=','images.added_by');
          $res->where('users.role',3);
          $res->select('users.name as user_name','images.id','images.title','images.price','images.image','categories.name as category','sub_categories.name as sub_category','images.created_at');
          if($fromdate!='')
          {
            $fromdate = date('Y-m-d',strtotime($fromdate));
            $res->whereDate('images.created_at','>=',$fromdate);
          }

          if($todate!='')
          {
            $todate = date('Y-m-d',strtotime($todate));
            $res->whereDate('images.created_at','<=',$todate);
          }
          $res->orderBy('images.created_at','desc');
          $list = $res->get();
          
            if(count($list)>0)
            {
                foreach ($list as $row) {
                $array = [
                            'Contributor'=>$row->user_name,
                            'Title'=>$row->title,
                            'Category'=>$row->category,
                            'Sub Category'=>$row->sub_category,
                            'Price'=>$row->price,
                            'Date'=>date('d-m-Y h:i a',strtotime($row->created_at))
                          ];               
                array_push($resultArray, $array);
                }
            }
        }

        if($reportType=='users')
        {
          $res = DB::table('users');
          $res->where('role',2);
          $res->where('status',1);
          if($fromdate!='')
          {
            $fromdate = date('Y-m-d',strtotime($fromdate));
            $res->whereDate('created_at','>=',$fromdate);
          }

          if($todate!='')
          {
            $todate = date('Y-m-d',strtotime($todate));
            $res->whereDate('created_at','<=',$todate);
          }
          $res->orderBy('created_at','desc');
          $list = $res->get();
          
            if(count($list)>0)
            {
                foreach ($list as $row) {
                $array = [
                            'Name'=>$row->name,
                            'Mobile Number'=>$row->mobile,
                            'Email Id'=>$row->email,
                            'Date'=>date('d-m-Y h:i a',strtotime($row->created_at))
                          ];               
                array_push($resultArray, $array);
                }
            }
        }

        if($reportType=='contributor')
        {
          $res = DB::table('users');
          $res->where('role',3);
          $res->where('status',1);
          if($fromdate!='')
          {
            $fromdate = date('Y-m-d',strtotime($fromdate));
            $res->whereDate('created_at','>=',$fromdate);
          }

          if($todate!='')
          {
            $todate = date('Y-m-d',strtotime($todate));
            $res->whereDate('created_at','<=',$todate);
          }
          $res->orderBy('created_at','desc');
          $list = $res->get();

            if(count($list)>0)
            {
                foreach ($list as $row) {
                $array =[
                            'Name'=>$row->name,
                            'Mobile Number'=>$row->mobile,
                            'Email Id'=>$row->email,
                            'Date'=>date('d-m-Y h:i a',strtotime($row->created_at))
                        ];                 
                array_push($resultArray, $array);
                }
            }
        }
        return collect($resultArray);
    }

    public function headings(): array
    {   
        $session  = session()->get('ReportSession');
        $reportType = $session['type'];
        $data = array();
        if($reportType=='sales')
        {     
            $data = [
                        'Title',
                        'Amount',
                        'Commission',
                        'Date'
                    ];   
        }

        if($reportType=='upload')
        {
            $data = [
                        'Contributor',
                        'Title',
                        'Category',
                        'Sub Category',
                        'Price',
                        'Date'
                      ];  
        }

        if($reportType=='users')
        {
            $data = [
                        'Name',
                        'Mobile Number',
                        'Email Id',
                        'Date'
                      ];
        }

        if($reportType=='contributor')
        {
            $data = [
                        'Name',
                        'Mobile Number',
                        'Email Id',
                        'Date'
                      ];
        }
        return $data;
    }
}
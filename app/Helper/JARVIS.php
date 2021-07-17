<?php
namespace App\Helper;
// use App\Events\Admin\Notification as NotificationEvent;
use App\Mail\Common\Commonlayout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class JARVIS //Just A Rather Very Intelligent System(J.A.R.V.I.S)
{
    public static function to_array($object)
    {
        return json_decode(json_encode($object),true);
    }

    public static function print($object)
    {
        $array = json_decode(json_encode($object),true);
        echo '<pre>'; print_r($array);
        return ' ';
    }

    public static function fire_it($table,$where=NULL,$method=NULL,$columns=NULL)
    {
        $datas = DB::table($table);
        if($where != '') {
            $datas = $datas->where($where);
        }
        if($method != '') {
            if($method == 'get') {
                if($columns != '') {
                    if(strlen($columns[0]) > 1) {
                        $second_last = $columns[count($columns)-2];
                        if($second_last == 'orderBy') {
                            $datas = $datas->orderBy(end($columns),'desc');
                            $columns = array_slice($columns,0,-2);
                            return $datas->select($columns)->get();  
                        } else {
                            return $datas->select($columns)->get();  
                        }
                    } else {
                        return $datas->orderBy($columns,'desc')->get();                        
                    }
                } else {
                    return $datas->get();  
                }
            } elseif($method == 'first') {
                if($columns != '') {
                    return $datas->select($columns)->first();
                } else {
                    return $datas->first();
                }
            } elseif($method == 'count') {
                return $datas->count();
            } elseif($method == 'pluck') {
                if(strlen($columns[0]) > 1) {
                    return $datas->orderBy($columns[1],'desc')->pluck($columns[0]);
                } else {
                    $implodee = implode(',',$columns);
                    return $datas->pluck($implodee);
                }
            } elseif($method == 'insert') {
                return $datas->insert($columns);
            } elseif($method == 'update') {
                return $datas->update($columns);
            } elseif($method == 'delete') {
                return $datas->delete();
            } else {
                return $datas->value($method);
            } 
        } else {
            return $datas;
        }
    }
    
    public static function swalOnFree($title,$text,$icon,$danger,$closeOn,$reload)
    {
        ?>
            <script type="text/javascript">
                var title   = '<?php echo $title; ?>';
                var text    = '<?php echo $text; ?>';
                var icon    = '<?php echo $icon; ?>';
                var danger  = '<?php echo $danger; ?>';
                var closeOn = '<?php echo $closeOn; ?>';
                var reload  = '<?php echo $reload; ?>';
                swal({
                    title: title,
                    text: text,
                    icon: icon,
                    dangerMode: danger,
                    closeOnEsc : closeOn,
                    closeOnClickOutside : closeOn,
                }).then((next) => {
                    if (next) {
                        if(reload == true){
                            location.reload(true);
                        } else if(reload == false)
                        {}else{
                            window.location.href=reload;
                        }
                    }
                });
            </script>
        <?php      
    }

    public static function swalOnClick($title,$text,$icon,$danger,$closeOn,$reload)
    {
        ?>
            <script type="text/javascript">
                $("[id^='swal']").click(function(){
                    var title   = '<?php echo $title; ?>';
                    var text    = '<?php echo $text; ?>';
                    var icon    = '<?php echo $icon; ?>';
                    var danger  = '<?php echo $danger; ?>';
                    var closeOn = '<?php echo $closeOn; ?>';
                    var reload  = '<?php echo $reload; ?>';
                    swal({
                        title: title,
                        text: text,
                        icon: icon,
                        dangerMode: danger,
                        closeOnEsc : closeOn,
                        closeOnClickOutside : closeOn,
                    }).then((next) => {
                        if (next) {
                            if(reload == true){
                                location.reload(true);
                            } else if(reload == false)
                            {}else{
                                window.location.href=reload;
                            }
                        }
                    });
                    return false;
                });
            </script>
        <?php      
    }

    public static function cropped_image_to_folder($image,$path)
    {
        $pos        = strrpos($image, ";base64");
        $myFilename = substr($image,0,$pos); 
        if($myFilename == 'data:application/pdf')
        {           
            $data = base64_decode(preg_replace('#^data:application/\w+;base64,#i', '', $image));
            $filename = time().'_'.str_random(5).'_'.rand(1111,9999).'.pdf';
        }
        else
        {
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
            $filename = time().'_'.str_random(5).'_'.rand(1111,9999).'.png';
        }        
        if($_SERVER['REMOTE_ADDR'] == 'sbcexpresscargo.com')
        {
            $result = file_put_contents('/home/sbcexswz/public_html/storage/'.$path.'/'.$filename, $data);            
        }
        else
        {
            $result = file_put_contents(public_path('/storage/'.$path.'/').$filename, $data);
        }

        if($result)
        {
            return $filename;
        }
        else
        {
            return FALSE;
        }
    }

    public static function user($value)
    {   
        $ip     = $_SERVER['REMOTE_ADDR'];    //LIVE
        $result = file_get_contents('http://ip-api.com/json/'.$ip);
        $result = json_decode($result,true);
        return $result[$value];
        //if $result is return, the following result will be printed
        /*
        [as]          => AS24186 RailTel Corporation of India Ltd., Internet Service Provider, New Delhi
        [city]        => Thrissur
        [country]     => India
        [countryCode] => IN
        [isp]         => RailTel Corporation Of India Ltd.
        [lat]         => 10.5167
        [lon]         => 76.2167
        [org]         => RailTel Corporation Of India Ltd.
        [query]       => 112.133.236.227
        [region]      => KL
        [regionName]  => Kerala
        [status]      => success
        [timezone]    => Asia/Kolkata
        [zip]         => 680001
        */
    } 

    public static function discounted_amount($amount,$discount)
    {
        $discounted = ($discount / 100) * $amount;
        $result     = $amount - $discounted;
        return $result;
    }

    public static function calculate($table,$where,$column,$groupby=NULL)
    {     
        if(isset($table[0]->$column))
        {
            $cal = 0;
            foreach ($table as $tab) {
                $cal += $tab->$column;
            }
            return $cal;
        }
        else
        {
            $data = DB::table($table);
            if($where != '') {
                $data = $data->where($where);
            }
            if($groupby != NULL)
            {
                $data = $data->groupBy($groupby);
            }
            $data = $data->pluck($column);
            $data = json_decode(json_encode($data),true);
            return array_sum($data);
        }
    }

    public static function mark($value)
    {
        ?>
            <font style="color:#ff0d00;font-style:italic;font-weight:600;">
                <?php echo strtoupper($value); ?>
            </font>
        <?php
    }

    public static function uri_segment($value)
    {
        $url     = URL::current();
        $explode = explode('/',$url);
        return $explode[$value];
    }

    public static function live()
    {
        $url     = URL::current();
        $explode = explode('/',$url);
        $live    = $explode[2];
        if($live != '127.0.0.1:8000' || $live != 'localhost:8000'){
            return true;
        } else {
            return false;
        }
    }    
}
<?php
namespace Model;

//class Contents extends Model {
class Contents {

    public static function get_list($limit=50, $offset=0)
    {
        $ret = DB::select()->
                from('ai_analysis_log')->
            //    where('published', '>=', $date->format('Y-m-d H:i:s'))->
                order_by('id', 'desc')->
                limit($limit)->
                offset($offset)->
                execute();

        return $ret;
    }

}

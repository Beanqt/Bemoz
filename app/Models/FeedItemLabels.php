<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedItemLabels extends Model {

    protected $table = 'feed_item_labels';

    public static function addLabel($id, $e){
        self::where('item', $id)->delete();

        if(isset($e['label']) && !empty($e['label'])){
            $data = [];

            foreach($e['label'] as $cat){
                $data[] = [
                    'item' => $id,
                    'label' => $cat,
                ];
            }

            self::insert($data);
        }

        return isset($e['label']) ? $e['label'] : [];
    }
}

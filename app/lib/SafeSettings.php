<?php

namespace App\lib;

use App\Models\Safe;

trait SafeSettings
{

    public function getSafe($key){
        $safe = Safe::query()->where('key',$key)->first();
        if($safe){
            return $safe->value;
        }
        return false;
    }

    public function getSmsTariff($key='smsTariff'){
        return $this->getSafe($key);
    }

    public function setSafe($type,$key,$value){
        if ($type != 'deposit' && $type != 'harvest') return false;
        if (! in_array($key,Safe::query()->pluck('key')->toArray())) return false;
        if (!$value || $value==null) return false;

        $safe = Safe::where('key',$key)->first();
        if($safe){
            $old_value = (int)$safe->value;
            $new_value = null;
            if ((int)$value > 0){
                if ($type == 'deposit'){
                    $new_value = $old_value + (int)$value;

                }elseif ($type == 'harvest'){
                    $new_value = $old_value - (int)$value;
                }
            }
            if ($new_value != null){
                $safe->update([
                    'value'=> (string)$new_value
                ]);
                return $new_value;
            }
        }
        return false;
    }



}
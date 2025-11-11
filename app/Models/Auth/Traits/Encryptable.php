<?php
/**
 * Created by PhpStorm.
 * User: SampleJunction
 * Date: 13-08-2019
 * Time: 11:42 PM
 */

namespace App\Models\Auth\Traits;

trait Encryptable
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        //print_r($key);die;
        if (in_array($key, $this->encryptable) && strlen($value) > 100 ) {

            $value = \Crypt::decrypt($value);
            return $value;
        }
        return $value;
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable)) {
            $value = \Crypt::encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }
    /**
     * Code added by Vikash (26-12-2022)
     */
    public function attributesToArray() 
    {

        $attributes = parent::attributesToArray();
        
        foreach($this->encryptable as $key) {
           //echo '<pre>';
            if (in_array($key, $attributes))
            {
                if(!empty($attributes[$key]))
                {
                    //print_r($attributes[$key]);
                    $attributes[$key] = \Crypt::decrypt($attributes[$key]);
                }
                
            }

        }
        //die;
        return $attributes;
        
    }
}

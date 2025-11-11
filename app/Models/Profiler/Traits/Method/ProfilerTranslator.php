<?php
/**
 * Created by PhpStorm.
 * User: SampleJunction
 * Date: 11-03-2019
 * Time: 10:14 PM
 */

namespace App\Models\Profiler\Traits\Method;


trait ProfilerTranslator
{
    public function doTranslate($key = null)
    {
        $translated = [];
        if(!empty($this->translated)){
            $translated = $this->translated[0];
        }
        if(!empty($key)){
            return (!empty($translated) && isset($translated[$key])) ? $translated[$key] : '';
        }

        return $translated;
    }
}

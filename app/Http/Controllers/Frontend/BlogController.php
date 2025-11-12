<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Repositories\Inpanel\General\GeneralRepository;
use Carbon\Carbon;

class BlogController extends Controller
{
    protected $generalRepository;
	/**
     * Show the blog index page.
     *
     * @return View
     */

     public function __construct(  GeneralRepository $generalRepository)
     {
 
         // $this->userRepository = $userRepository;
         $this->generalRepository = $generalRepository;
     }

    public function getPosts(Request $request): View
    {
        $status = [
            'draft','published'
        ];
        
        $data = [
            'posts' => DB::connection('mysql_additional')->table('canvas_posts')
                ->select(['slug', 'thumbnail_image', 'featured_image', 'body', 'title','published_at'])
                ->whereIn('post_status', $status)
                ->where('site_info', '=', '1')
                ->orderByDesc('published_at')
                ->simplePaginate(10),
            // 'topics' => DB::connection('mysql_additional')->table('canvas_topics')->get(['name', 'slug']),
            // 'tags'   => DB::connection('mysql_additional')->table('canvas_tags')->get(['name', 'slug']),
        ];

        $i = 0;
        $read_time = [];
        foreach($data['posts'] as $posts){
            $words = str_word_count(strip_tags($posts->body));
            $minutes = ceil($words / 250);
            $formattedDate = Carbon::parse($posts->published_at)->format('M-y');
            $read_time[$i] = $formattedDate .' '. $minutes.' ' .__('frontend.index.footer.links.minute').' '.__('frontend.index.footer.links.read_time');
            $i++;
        }

        // Modified By obhi
        $uuid = Str::uuid()->toString();
        $ip= request()->ip();
        $DFIQ=config('settings.dfiq.status');
        $geodata = geoip($ip);
        // $countries = $this->generalRepository->getActiveCountries();
        $country=$geodata->getAttribute('country');
        $countryCode = $geodata->getAttribute('iso_code');
        $locale = $request->session()->get('locale');
        if($countryCode!='US'){
            if(!empty($locale)){
                $flags=str_replace('_','-',strtoupper($locale));
            }else{
                app()->setLocale('EN-'.$countryCode);
                $flags='EN-'.$countryCode;  
            }
        }else{
            $flags=str_replace('_','-',strtoupper($locale));
        }

        return view('frontend.blog.index')->with('ip',str_replace('.','-',$ip))
        ->with('uuid',$uuid)
        ->with('dfiq',$DFIQ)
        // ->withCountries($countries) 
        ->with('country_name',strtoupper($country))
        ->with('countryCode',$countryCode)
        ->with('flags',$flags)
        ->with('data',$data)
        ->with('read_time',$read_time);
    }

    
    public function findPostBySlug(string $slug,Request $request): View
    {
        //$posts = DB::connection('mysql_additional')->table('canvas_posts')->where('published_at','!=',null)->get();
		$posts = DB::connection('mysql_additional')->table('canvas_posts')
                //->leftJoin('canvas_tags')
                //->crossJoin('canvas_topics')
                //->where('canvas_posts.published_at','!=',null)
                //->select('canvas_posts.*','canvas_tags.*','canvas_topics.*')
				->join('canvas_tags','canvas_tags.id','=','canvas_posts.id','left')
				->select('canvas_posts.*')
				->where('canvas_posts.published_at','!=',null)
				
				//->where('slug',$slug)
                ->get();
        $post = $posts->firstWhere('slug', $slug);
        
        if (optional($post)->published_at) {
            $next = $posts->sortBy('published_at')->firstWhere('published_at', '>', optional($post)->published_at);
             
            $filtered = $posts->filter(function ($value, $key) use ($slug, $next) {
                return $value->slug != $slug && $value->slug != optional($next)->slug;
            });

            $words = str_word_count(strip_tags($post->body));
            $minutes = ceil($words / 250);
            $formattedDate = Carbon::parse($post->published_at)->format('M-y');
            $read_time = $formattedDate .' '. $minutes .' '. __('frontend.index.footer.links.minute').' '.__('frontend.index.footer.links.read_time');

            $data = [
                'author' => '',
                'post'   => $post,
                'meta'   => $post->meta,
                'next'   => $next,
                'random' => '',
                'topic'  => null,
                'read_time'=>$read_time,
            ];
            //echo "<pre>";
            //print_r(json_decode($data['meta'],true)['meta_description']);exit();
        
            // event(new PostViewed($post));


             // return view('frontend.blog.show', compact('data'));


             // Modified by obhi
            $uuid = Str::uuid()->toString();
            $ip= request()->ip();
            $DFIQ=config('settings.dfiq.status');
            $geodata = geoip($ip);
            $countries = $this->generalRepository->getActiveCountries();
            $country=$geodata->getAttribute('country');
            $countryCode = $geodata->getAttribute('iso_code');
            
            if($countryCode!='US'){
                if(!empty($request->session()->get('locale'))){
                    $flags=str_replace('_','-',strtoupper($request->session()->get('locale')));
                }else{
                    app()->setLocale('EN-'.$countryCode);
                    $flags='EN-'.$countryCode;  
                }
                
            }else{
                $flags=str_replace('_','-',strtoupper($request->session()->get('locale')));
            }

         
            return view('frontend.blog.show')->with('ip',str_replace('.','-',$ip))
            ->with('uuid',$uuid)
            ->with('dfiq',$DFIQ)
            ->withCountries($countries) 
            ->with('country_name',strtoupper($country))
            ->with('countryCode',$countryCode)
            ->with('flags',$flags)
            ->with('data',$data);
            // Modified by obhi

        } else {
            abort(404);
        }
    }

    
}

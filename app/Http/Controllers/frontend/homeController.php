<?php

namespace App\Http\Controllers\frontend;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\slider;
use App\Models\whereToStudy;
use App\Models\studentInformation;
use App\Models\Blog;
use App\Models\webInner;
use App\Models\siteInformation;
use App\Models\feesCategory;
use App\Models\contactForm;
use App\Models\PremiumCourse;
use App\Models\onlineFee;
use App\Models\Booking;
use App\Models\internationalStudentLife;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\TimeZone;
use Carbon\Carbon;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;
use App\Mail\BookingReplyMail;
use App\Mail\AdmissionReciveMail;
use App\Mail\AdmissionReplyMail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
 // At the top

class homeController extends Controller
{
    public function index(){
        $slider = slider::where('status', 1)->latest()->first();
        $whereToStudies = whereToStudy::where('is_done', 1)->orderBy('priority', 'ASC')->get();
        $blogs = Blog::where('homePage', 1)->latest()->limit(6)->get();
         $cover = Blog::where('homePage', 1)
                ->where('cover', 1)
                ->latest()
                ->first();
         $info = siteInformation::first();
         $premiumCourses = PremiumCourse::where('type', '!=', 'single')->where('type', '!=', 'free')->latest()->limit(6)->get();

                // dd($cover);
        // dd( $whereToStudies );
        return view('frontend.home', compact('slider', 'whereToStudies', 'blogs', 'cover', 'info' , 'premiumCourses'));
    }
    public function apply_now(){
        return view('frontend.apply_now_page');
    }

    public function about_us(){
        return view('frontend.about_us');
    }
   

public function apply_now_form(Request $request){
    $rules = [
        'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
        'surname' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
        'email' => 'required|email|max:255',
        'country_code' => 'required|string',
        'phone' => 'required|numeric|min:8',
        'nationality' => '',
        'country_of_residence' => 'required|string|max:255',
        'course_and_degree' => 'required|string|max:255',
        'subject_of_interest' => 'required|string|max:255',
        'course_name' => 'required|string|max:255',
        'preferred_session' => 'required|string|max:255',
        'comments' => 'required|string',
    ];

    $validatedData = $request->validate($rules);

    $studentInformation = new studentInformation();
    $studentInformation->fill($validatedData);
    // dd($studentInformation);
    $studentInformation->save();

    try {
        Mail::to($validatedData['email'])->send(new AdmissionReplyMail($validatedData));
    } catch (\Exception $e) {
        Log::error('Admission email to user failed: ' . $e->getMessage());
    }

    try {
        Mail::to('imad@thehorizonsunlimited.com')->send(new AdmissionReciveMail($validatedData));
    } catch (\Exception $e) {
        Log::error('Admission email to admin failed: ' . $e->getMessage());
    }

    return redirect()->back()->with('success', 'Student information saved successfully');
}


    public function contact_form(Request $request){
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|min:8',
            'message' => '',
        ]);

        // Create a new instance of the model and fill it with validated data
        $contactForm = new contactForm();
        $contactForm->fill($validatedData);

        // Save the model instance to the database
        $contactForm->save();
        
        
         // Send the email to the user (who submitted the form)
            Mail::to($validatedData['email'])->send(new ContactFormMail($validatedData));

        //   Send the email to your email (roynirjon18@gmail.com)
          Mail::to('imad@thehorizonsunlimited.com')->send(new ContactFormMail($validatedData));
 
        // Redirect back with a success message

        return redirect()->back()->with('success', 'Message Sent Successfully');
    }

    public function whereToStudyId(int $id)
{
    $study = WhereToStudy::findOrFail($id);
    return redirect()->route('where.to.study', ['slug' => $study->slug], 301);
}

public function whereToStudy(string $slug)
{
    $studies = WhereToStudy::where('slug', $slug)->firstOrFail(); // 404 if not found

    if ((int) $studies->is_done === 1) {
        $id = $studies->id;

        $blogs = Blog::where('where_to_study_id', $id)
            ->latest()->limit(6)->get();

        $cover = Blog::where('where_to_study_id', $id)
            ->where('cover', 1)
            ->latest()->first();

        $categories = FeesCategory::whereHas('onlineFees', function ($q) use ($id) {
                $q->where('university_id', $id);
            })->with(['onlineFees' => function ($q) use ($id) {
                $q->where('university_id', $id);
            }])->get();

        $latest_course = OnlineFee::where('university_id', $id)
            ->where('recommend', 1)
            ->latest()->limit(4)->get();

        return view('frontend.where_to_study',
            compact('studies', 'blogs', 'cover', 'categories', 'latest_course'));
    }

    return view('frontend.commingsoon', compact('studies'));
}

    public function onlineStudyOption(){
        $study = whereToStudy::all();
        return view('frontend.online_study_options', compact('study'));
    }
    public function student_life($id){
        $lifes = internationalStudentLife::find($id);
        $blogs = Blog::where('life_style_id', $id)->latest()->limit(6)->get();
        $cover =  Blog::where('life_style_id', $id)
             ->where('cover', 1)
             ->latest()
             ->first();
        return view('frontend.life_style', compact('lifes', 'blogs', 'cover'));
    }
    public function how_to_apply(){
        return view('frontend.how_to_apply');
    }
    public function fees_cost(){
        return view('frontend.fees_cost');
    }
    public function entry_requirement(){
        return view('frontend.entry_requirement');
    }

    public function application_process(){
        return view('frontend.application_process');
    }

    public function accommodation(){
        return view('frontend.accommodation');
    }
    
    public function premium_courses(Request $request){
        $search = trim((string) $request->input('search', ''));

        $singleQuery = PremiumCourse::where('type', 'single')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $like = '%' . $search . '%';
                    $inner->where('title', 'like', $like)
                        ->orWhere('instructor', 'like', $like)
                        ->orWhere('short_description', 'like', $like);
                });
            })
            ->latest();

        $all_courses = $singleQuery->paginate(20)->withQueryString();

        $full_access = PremiumCourse::where('type', '!=', 'single')
            ->where('type', '!=', 'free')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $like = '%' . $search . '%';
                    $inner->where('title', 'like', $like)
                        ->orWhere('instructor', 'like', $like)
                        ->orWhere('short_description', 'like', $like);
                });
            })
            ->latest()
            ->get();

        return view('frontend.premium_courses', compact('all_courses', 'full_access', 'search'));
    }

public function free_courses(){
        $all_courses = PremiumCourse::where('type', 'single')->latest()->paginate(20);
        $full_access = PremiumCourse::where('type',  'free')->latest()->get();
        // dd($all_courses);
        return view('frontend.free_courses', compact('all_courses', 'full_access'));
    }
    
    

public function premium_course_details(string $slug)
    {
        // Fetch course by slug only
        $course = PremiumCourse::where('slug', $slug)->firstOrFail();

        // Get most popular courses (excluding current)
        $mostPopularCourses = DB::table('premium_courses')
            ->select(
                'premium_courses.id',
                'premium_courses.slug',
                'premium_courses.title',
                'premium_courses.instructor',
                'premium_courses.long_description',
                'premium_courses.short_description',
                'premium_courses.price',
                'premium_courses.image',
                'premium_courses.duration',
                'premium_courses.effort',
                'premium_courses.questions',
                'premium_courses.format',
                'premium_courses.status',
                'premium_courses.created_at',
                'premium_courses.updated_at',
                DB::raw('COUNT(orders.id) AS order_count')
            )
            ->leftJoin('orders', function ($join) {
                // assuming orders.items is JSON array containing {"id": course_id}
                $join->on(DB::raw("JSON_CONTAINS(orders.items, JSON_OBJECT('id', premium_courses.id), '$')"), '=', DB::raw('1'));
            })
            ->where('premium_courses.id', '!=', $course->id)
            ->groupBy(
                'premium_courses.id',
                'premium_courses.slug',
                'premium_courses.title',
                'premium_courses.instructor',
                'premium_courses.long_description',
                'premium_courses.short_description',
                'premium_courses.price',
                'premium_courses.image',
                'premium_courses.duration',
                'premium_courses.effort',
                'premium_courses.questions',
                'premium_courses.format',
                'premium_courses.status',
                'premium_courses.created_at',
                'premium_courses.updated_at'
            )
            ->orderByDesc('order_count')
            ->limit(5)
            ->get();

        return view('frontend.premium_course_details', compact('course', 'mostPopularCourses'));
    }

    
    public function support_study_abroad(){
        return view('frontend.support_study_abroad');
    }

    public function career_preparation(){
        return view('frontend.career_preparation');
    }

    public function contact_us(){
        $info = siteInformation::first();
        return view('frontend.contact_us', compact('info'));
    }

    public function clear_cache(){
         \Artisan::call('cache:clear');
    \Artisan::call('route:clear');
    \Artisan::call('view:clear');
    \Artisan::call('config:clear');
    \Artisan::call('config:cache');
    dd("Application all cached has been cleared!");
    }
    
    public function webinners()
    {
        $webinners = webInner::latest()->paginate(30);
        return view('frontend.webinners', compact('webinners'));

    }
    
    public function all_blogs()
    {
        $blogs = Blog::latest()->paginate(30);
        return view('frontend.all_blogs', compact('blogs'));

    }

    public function blog_details($slug){
        // dd($id);
        $blog = Blog::where('slug', $slug)->first();

        // dd($blog);
        return view('frontend.blog_details', compact('blog'));
    }

// public function getTimeZoneData()
// {
//     $apiKey = 'A8PRL7GQ6QVQ';
//     $response = Http::get("http://api.timezonedb.com/v2.1/list-time-zone", [
//         'key' => $apiKey,
//         'format' => 'json',
//     ]);

//     if ($response->successful()) {
//         $timeZones = $response->json()['zones'];
//         // Process and use $timeZones as needed
//     } else {
//         // Handle error
//     }
// }



public function consultation_book()
{

    
    

        return view('frontend.book_consultancy');
   
}




    public function showStep1()
    {
       // Cache for 1 day (adjust duration as needed)
    $timeZones = Cache::remember('time_zones', 86400, function () {
        return DB::table('time_zone')
            ->select('zone_name', 'gmt_offset')
            ->orderBy('zone_name', 'asc')
            ->get();
    });
        
        $timeSlots = $this->generateTimeSlots();
        return view('frontend.book_consultancy', compact('timeSlots', 'timeZones'));
    }
    
 private function generateTimeSlots($timezone = null)
{
    // Use provided timezone or fallback to app timezone
    $startTime = Carbon::createFromTime(7, 0, 0, $timezone ?? config('app.timezone')); // 7:00 AM
    $endTime = Carbon::createFromTime(19, 0, 0, $timezone ?? config('app.timezone'));  // 7:00 PM

    $interval = 20; // minutes
    $timeSlots = [];

    while ($startTime->lte($endTime)) {
        $timeSlots[] = $startTime->format('g:i A'); // e.g., 7:00 AM
        $startTime->addMinutes($interval);
    }

    return $timeSlots;
}


    
    public function showStep2(Request $request)
    {
        // Validate the query parameters
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
        ]);
    
        // Render the second step with the passed data
        return view('frontend.book_consultancy_step2', [
            'date' => $request->query('date'),
            'time' => $request->query('time'),
            'time_zone' => $request->query('time_zone'),
        ]);
    }
    

    

public function submitBooking(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'date' => 'required|date|after_or_equal:today',
        'time' => 'required',
        'time_zone' => 'required',
        'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
        'last_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
        'phone' => 'required|string|max:15',
        'email' => 'required|email|max:255',
        'additional_info' => 'nullable|string|max:1000',
    ]);

    // Create a new booking
    $booking = Booking::create($validatedData);

    // Try sending to the user
    try {
        Mail::to($validatedData['email'])->send(new BookingReplyMail($booking));
    } catch (\Exception $e) {
        Log::error('Booking email to user failed: ' . $e->getMessage());
    }

    // Try sending to the admin
    try {
        Mail::to('imad@thehorizonsunlimited.com')->send(new BookingConfirmationMail($booking));
    } catch (\Exception $e) {
        Log::error('Booking email to admin failed: ' . $e->getMessage());
    }

    // Redirect with success message
    return redirect()->route('consultation.confirmation')->with('success', 'Booking confirmed successfully!');
}


    

    
    public function confirmation()
{

    

    // Retrieve the latest booking from the database
    $booking = Booking::latest()->first();

    if (!$booking) {
        // Redirect to Step 1 if no booking data is found
        return redirect()->route('consultation.step1')->with('error', 'No booking found.');
    }

    

    // Display confirmation page with booking details
    return view('frontend.consultation_confirmation', compact('booking'));
}

    

}

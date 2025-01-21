<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Swapping\BidController;
use App\Http\Controllers\Swapping\BlockController;
use App\Http\Controllers\Swapping\OfferController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Swapping\ChatController;
use App\Http\Controllers\Auth\NotificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog\CommentController;
use App\Http\Controllers\Blog\ImageUploadController;
use App\Http\Controllers\Website\PagesController;
use App\Http\Controllers\Auth\UserDashboardController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Middleware\IsAdmin;
use App\Models\UserDashboard;

Route::middleware([IsAdmin::class])->group(function () {
    Route::get('/admin-dash', [AdminController::class, 'index'])->name('admin.dashboard.index');

    Route::get('/admin-dash/users', [AdminController::class, 'users'])->name('admin.dashboard.users');

    Route::get('/admin-dash/offers', [AdminController::class, 'offers'])->name('admin.offers.index');
    Route::post('/admin-dash/offers/{offer}/approve', [AdminController::class, 'offersApprove'])->name('admin.offers.approve');

    Route::get('/admin-dash/frameworks', [AdminController::class, 'frameWorksManage'])->name('admin.frameworks.index');
    Route::post('/admin-dash/frameworks/create', [AdminController::class, 'frameWroksCreate'])->name('admin.frameworks.save');
    Route::post('/admin-dash/frameworks/update', [AdminController::class, 'frameWroksUpdate'])->name('admin.frameworks.update');
    Route::post('/admin-dash/frameworks/delete', [AdminController::class, 'frameWroksDelete'])->name('admin.frameworks.delete');


    Route::get('/admin-dash/website-settings', [AdminController::class, 'websiteManage'])->name('admin.wsettings.index');
    Route::post('/admin-dash/website-settings/create', [AdminController::class, 'wSettingsCreate'])->name('admin.wsettings.save');
    Route::post('/admin-dash/website-settings/update', [AdminController::class, 'wSettingsUpdate'])->name('admin.wsettings.update');
    Route::post('/admin-dash/website-settings/delete', [AdminController::class, 'wSettingsDelete'])->name('admin.wsettings.delete');



    Route::get('/admin/chat-rooms', [AdminController::class, 'chatRooms'])->name('admin.chatRooms');
    Route::get('/admin/chat-room/{id}', [AdminController::class, 'showChatRoom'])->name('admin.showChatRoom');

    //blog controll
    Route::get('/admin/blogs', [AdminController::class, 'blogIndex'])->name('admin.blogs');
    Route::post('/admin/blogs/store', [AdminController::class, 'blogStore'])->name('admin.blogs.store');
    Route::post('/admin/blogs/update/{id}', [AdminController::class, 'blogUpdate'])->name('admin.blogs.update');
    Route::post('/admin/blogs/delete', [AdminController::class, 'blogDelete'])->name('admin.blogs.delete');

    Route::get('/admin/blogs/divisions', [AdminController::class, 'blogDivision'])->name('admin.blogs.divisions');
    Route::post('/admin/blogs/division/store', [AdminController::class, 'blogDivisionStore'])->name('admin.blogs.division.store');
    Route::post('/admin/blogs/division/update/{id}', [AdminController::class, 'divisionUpdate'])->name('admin.blogs.division.update');
    Route::post('/admin/blogs/division/delete', [AdminController::class, 'divisionDelete'])->name('admin.blogs.division.delete');

    Route::get('/admin/blogs/categories', [AdminController::class, 'blogCategories'])->name('admin.blogs.categories');
    Route::post('/admin/blogs/category/store', [AdminController::class, 'blogCategoryStore'])->name('admin.blogs.category.store');
    Route::post('/admin/blogs/category/update/{id}', [AdminController::class, 'categoryUpdate'])->name('admin.blogs.category.update');
    Route::post('/admin/blogs/category/delete', [AdminController::class, 'categoryDelete'])->name('admin.blogs.category.delete');

    Route::get('/admin/blog/article/review', [AdminController::class, 'articlesReview'])->name('admin.blogs.articles.review');
    Route::post('admin/blogs/articles/approve', [AdminController::class, 'articlesApprove'])->name('admin.blogs.articles.approve');
    Route::post('admin/blogs/articles/disapprove', [AdminController::class, 'articlesDisapprove'])->name('admin.blogs.articles.disapprove');
    Route::delete('admin/blogs/articles/delete', [AdminController::class, 'articlesDelete'])->name('admin.blogs.articles.delete');
    Route::post('admin/blogs/articles/o/delete', [AdminController::class, 'articlesOriginalDelete'])->name('admin.blogs.articles.delete_2'); //deletes orginal aricle
    
        Route::get('/admin-dash/run-matching-logic', [AdminController::class, 'runMatchingLogic'])->name('admin.runMatchingLogic');

});

Route::middleware('auth')->group(function () {

    Route::post('/upload-image', [ImageUploadController::class, 'uploadImage'])->name('auth.upload.image');
    Route::get('/blog/article/create', [BlogController::class, 'create'])->name('blog.article.create');
    Route::post('/blog/article/store', [BlogController::class, 'store'])->name('blog.article.store');
    Route::post('/blog/article/update', [BlogController::class, 'update'])->name('blog.article.update');
    Route::get('/get-categories/{divisionId}', [BlogController::class, 'getCategories']);



    Route::resource('offers', OfferController::class)->except('show');
    Route::post('offers/{id}/update-status/done', [OfferController::class, 'updateStatusToDone'])->name('offers.updateStatusToDone');
    Route::get('/place-bid/{offer}', [BidController::class, 'show'])->name('bids.create');
    Route::post('/store-bid', [BidController::class, 'store'])->name('bids.store');
    Route::get('/rec-bids/{offerId}', [BidController::class, 'list'])->name('recieved.bids');
    Route::get('/my-bids', [BidController::class, 'mylist'])->name('bids.mylist');
    Route::post('/bids/{bidId}/accept', [BidController::class, 'acceptBid'])->name('bids.accept');

    Route::get('/logout', [UserAuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/account', function () {
        return view('dashboard/account');
    })->name('dashboard.account');
    Route::get('/dashboard/account#security', function () {
        return view('dashboard/account');
    })->name('hashed.update.password.user');
    Route::post('/update-account', [UserController::class, 'update'])->name('update.user');
    Route::post('/update-password', [UserController::class, 'updatePassword'])->name('update.password.user');



    Route::get('/chat/{chatRoomId}', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/messages/{chatRoomId}', [ChatController::class, 'getMessages'])->name('chat.getMessages');
    Route::post('/chat/{chatRoomId}/close', [ChatController::class, 'close'])->name('chat.close');


    Route::post('/block/{userId}', [BlockController::class, 'block'])->name('block.user');
    Route::delete('/unblock/{userId}', [BlockController::class, 'unblock'])->name('unblock.user');

    Route::get('notifications/mark-as-read', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('notifications.markAsRead');
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.get');

    Route::get('/json/unreadMessages/count/{id}', [BidController::class, 'unreadMessagesCount']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login_proc', [UserAuthController::class, 'processLogin'])->name('login.process');
    Route::get('/register', [UserAuthController::class, 'index'])->name('register');
    Route::post('/register', [UserAuthController::class, 'process'])->name('register.process');

    Route::get('password/forgot', [ForgotPasswordController::class, 'showForgotForm'])->name('password.forgot');
    Route::post('password/forgot', [ForgotPasswordController::class, 'sendResetLink'])->name('password.forgot.send');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'resetPassword'])->name('password.reset.submit');
});

Route::get('/admin/generate-sitemap', [AdminController::class, 'generateSitemap'])->name('admin.generate-sitemap');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('offers/{offer}', [OfferController::class, 'show'])->name('offers.show');
Route::get('blog', [BlogController::class, 'index'])->name('blog.index');

Route::get('/blog/article/{slug}/{date?}/{original?}', [BlogController::class, 'show'])->name('blog.article.show');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/comments/delete/{id}', [CommentController::class, 'delete'])->name('comments.delete');

Route::get('/privacy-policy', [PagesController::class, 'privacy'])->name('pages.privacy');
Route::get('/Who-are-we', [PagesController::class, 'aboutUs'])->name('pages.about_us');
Route::get('/usage-agreement', [PagesController::class, 'usageAgreement'])->name('pages.usage_agreement');
Route::get('/team', [PagesController::class, 'team'])->name('pages.team');
Route::get('/contact-us', [PagesController::class, 'contactUs'])->name('pages.contact');
